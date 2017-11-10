<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundCustomer\Service;

use RocketUser\Entity\UserInterface;
use LundCustomer\Entity\Retailer;
use LundCustomer\Entity\RetailerInterface;
use LundCustomer\Repository\RetailerRepositoryInterface;
use LundCustomer\Form\RetailerForm;
use LundCustomer\Options\LundCustomerOptionsInterface;
use LundCustomer\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use DateTime;
use GoogleMaps;
use LundCustomer\Repository\PostalCodeRepositoryInterface;

define('_UNIT_MILES', 'm');
define('_UNIT_KILOMETERS', 'k');
define('_ZIPS_SORT_BY_DISTANCE_ASC', 1);
define('_ZIPS_SORT_BY_DISTANCE_DESC', 2);
define('_ZIPS_SORT_BY_ZIP_ASC', 3);
define('_ZIPS_SORT_BY_ZIP_DESC', 4);
define('_M2KM_FACTOR', 1.609344);

/**
 * Service managing the management of retailers.
 */
class RetailerService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var RetailerRepositoryInterface
     */
    protected $retailerRepository;

    /**
     * @var RetailerForm
     */
    protected $retailerForm;

    /**
     * @var LundCustomerOptionsInterface
     */
    protected $options;

    /**
     * @var RetailerInterface
     */
    protected $retailerPrototype;

    /**
     * @var PostalCodeRepositoryInterface
     */
    protected $postalCodeRepository;

    protected $last_error;
    protected $last_time;
    protected $units;
    protected $decimals;

    /**
     * @param ObjectManager                 $objectManager
     * @param RetailerRepositoryInterface   $retailerRepository
     * @param FormInterface                 $retailerForm
     * @param LundCustomerOptionsInterface  $options
     * @param PostalCodeRepositoryInterface $postalCodeRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        RetailerRepositoryInterface $retailerRepository,
        FormInterface $retailerForm,
        LundCustomerOptionsInterface $options,
        PostalCodeRepositoryInterface $postalCodeRepository
    ) {
        $this->objectManager  = $objectManager;
        $this->retailerRepository = $retailerRepository;
        $this->retailerForm       = $retailerForm;
        $this->options        = $options;
        $this->postalCodeRepository = $postalCodeRepository;

        $this->last_error = '';
        $this->last_time = 0;
        $this->units = _UNIT_MILES;
        $this->decimals = 2;
    }

    /**
     * Return a list of active retailers
     *
     * @return RetailerInterface
     */
    public function getActiveRetailers()
    {
        return $this->retailerRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            ),
            array(
                'companyName'   => 'ASC',
            )
        );
    }

    /**
     * Return a list of active online retailers
     *
     * @return RetailerInterface
     */
    public function getActiveOnlineRetailers()
    {
        return $this->retailerRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'retailerType' => 'online',
            ),
            array(
                'companyName' => 'ASC',
            )
        );
    }

    /**
     * Return a list of active physical retailers
     *
     * @return RetailerInterface
     */
    public function getActivePhysicalRetailers()
    {
        return $this->retailerRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'retailerType' => 'physical',
            ),
            array(
                'companyName' => 'ASC',
            )
        );
    }
    
    /**
     * Return a Retailer by the name of the company
     * 
     * @param Retailer $name
     */
    public function getRetailerByName($name)
    {
        return $this->retailerRepository->findOneBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'companyName' => $name,
            )
        );
    }
    
    /**
     * Return a Retailer by the company phone number
     * 
     * @param Retailer $name
     */
    public function getRetailerByPhone($phonenumber)
    {
        return $this->retailerRepository->findOneBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'phoneNumber' => $phonenumber,
            )
        );
    }

    /**
     * @return mixed
     */
    public function getActiveRetailerRecords($limit = null, $offset = null, $orderBy = array(), $sSearch = null)
    {
        return $this->retailerRepository->findActive($limit, $offset, $orderBy, $sSearch);
    }

    /*
     * @return mixed
     */
    public function getRetailersTotalCount($sSearch = null)
    {
        return $this->retailerRepository->getTotalRows($sSearch);
    }

    /**
     * Return a segment of active retailers for datatables
     *
     * @return mixed
     */
    public function getRetailerListings(AbstractActionController $controller, $limit = null, $offset = null, $sEcho = null, $sortingCols = null, $sSearch = null)
    {
        $columns = array('r.companyName', 'r.retailerType', 'r.streetAddress', 'r.extStreetAddress', 'r.locality', 'r.state', 'r.postCode', 'r.country', 'r.phoneNumber');
        $orderBy = array();

        if ($sortingCols > 0) {
            for ($i = 0; $i < $sortingCols; $i++) {
                if ($controller->params()->fromQuery('bSortable_' . $controller->params()->fromQuery('iSortCol_' . $i)) == 'true') {
                    // column name
                    $orderBy[] = $columns[(INT)$controller->params()->fromQuery('iSortCol_' . $i)];
                    // order direction
                    $orderBy[] = (($controller->params()->fromQuery('sSortDir_' . $i) === 'asc') ? 'ASC' : 'DESC');
                }
            }
        }

        $records           = $this->getActiveRetailerRecords($limit, $offset, $orderBy, $sSearch);
        $recordsCount      = count($records);
        $totalRecordsCount = $this->getRetailersTotalCount($sSearch);
        $aaData            = array();
        $address           = null;

        if ($recordsCount > 0) {
            foreach ($records as $record) {
                $address = null;
                if(!$record->getDeleted() && !$record->getDisabled())
                {

	                if ($record->getRetailerType() == 'physical') {
	                    $address = $record->getStreetAddress();
	                    $address .= ($record->getExtStreetAddress() ? '<br>' . $record->getExtStreetAddress() : '');
	                    $address .= '<br>' . $record->getLocality() . ', ' . $record->getRegion()->getSubdivisionName() . ' ' . $record->getPostCode();
	                    $address .= '<br>' . $record->getCountry()->getName();
	                }
	                $aaData[] = array($record->getCompanyName(),
	                                  $record->getRetailerType(),
	                                  $address,
	                                  $record->getPhoneNumber(),
	                                  $record->getRetailerId()
	                );
                }
            }
        }

        return array('sEcho'                => $sEcho,
                     'aaData'               => $aaData,
                     'iTotalRecords'        => $totalRecordsCount,
                     'iTotalDisplayRecords' => $totalRecordsCount);
    }

    /**
     * Return create retailer form
     *
     * @return RetailerForm
     */
    public function getCreateRetailerForm()
    {
        $this->retailerForm->bind(clone $this->getRetailerPrototype());

        return $this->retailerForm;
    }

    /**
     * Return edit retailer form
     *
     * @param  string       $retailerId
     * @return RetailerForm
     */
    public function getEditRetailerForm($retailerId)
    {
        $retailer = $this->retailerRepository->find($retailerId);

        $this->retailerForm->bind($retailer);

        return $this->retailerForm;
    }

    /**
     * Return retailer entity
     *
     * @param  string            $retailerId
     * @return RetailerInterface
     */
    public function getRetailer($retailerId)
    {
        $retailer = $this->retailerRepository->find($retailerId);

        return $retailer;
    }

    /**
     * Creates a new retailer.
     *
     */
    public function insertRetailer($newRetailer)
    {
    	
    	echo $newRetailer['phoneNumber']." - ";
    	$retailer = clone $this->getRetailerPrototype();
    	
    	$clientId = '28355364645-p7c6kq57urm028sa823vu9q6j38n3dss.apps.googleusercontent.com'; // AIzaSyCX9e39FqekekGdV_yhl7rU3OU-8x0DbXw 
    	$privateKey = '-e-R9j_hWL3wUO8RWcF7x4NH';
    	
    	$address = $newRetailer['streetAddress'];
    	$address .= ($newRetailer['extStreetAddress'] ? ', ' . $newRetailer['extStreetAddress'] : '');
    	$address .= ', ' . $newRetailer['locality'] . ', ' . $newRetailer['region']->getSubdivisionName() . ' ' . $newRetailer['postCode'];
    	
    	//echo $address;exit;
    	$request = new \GoogleMaps\Request();
    	$request->setAddress($address);
    	//$request->setClient($clientId);
    	//$request->sign($privateKey);
    	
    	$proxy = new \GoogleMaps\Geocoder();
    	$response = $proxy->geocode($request);
    	$results = $response->getResults();
    	
    	//print_r($response);exit;
    	foreach ($results as $result) {
    		$geometry = $result->getGeometry();
    		$location = $geometry->getLocation();
    		$lat = $location->getLat();
    		$long = $location->getLng();
    	}
    	
    	$retailer->setLatitude($lat)
    	->setLongitude($long)
    	->setCreatedAt(new DateTime('now'))
    	->setCreatedBy('system')
    	->setDeleted(false)
    	->setDisabled($newRetailer['disabled'])
    	->setRetailerType($newRetailer['retailerType'])
    	->setCompanyName($newRetailer['companyName'])
    	->setStreetAddress($newRetailer['streetAddress'])
    	->setExtStreetAddress($newRetailer['extStreetAddress'])
    	->setLocality($newRetailer['locality'])
    	->setRegion($newRetailer['region'])
    	->setPostCode($newRetailer['postCode'])
    	->setCountry($newRetailer['country'])
    	->setPhoneNumber($newRetailer['phoneNumber'])
    	->setDiscount($newRetailer['discount'])
    	->setCustomerId($newRetailer['customerId'])
    	->setCustomerOrDealer($newRetailer['customerOrDealer']);
    	
    	
    	$this->objectManager->persist($retailer);
    	$this->objectManager->flush();
    	
    	
    	return $retailer;
    }
    
    
    /**
     * Creates a new retailer.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|RetailerInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->retailerForm->bind(clone $this->getRetailerPrototype());
        $this->retailerForm->setData($data);

        if (!$this->retailerForm->isValid()) {
        	//print_r($this->retailerForm->getMessages()); //error messages
        	//echo $this->retailerForm->getErrors(); //error codes
        	//echo $this->retailerForm->getErrorMessages(); //any custom error messages

            return null;
        }

        $retailer = $this->retailerForm->getData();

        if (!$retailer instanceof RetailerInterface) {
            throw Exception\UnexpectedValueException::invalidRetailerEntity($retailer);
        }

        if ($retailer->getRetailerType() == 'physical') {
            $address = $retailer->getStreetAddress();
            $address .= ($retailer->getExtStreetAddress() ? ', ' . $retailer->getExtStreetAddress() : '');
            $address .= ', ' . $retailer->getLocality() . ', ' . $retailer->getRegion()->getSubdivisionName() . ' ' . $retailer->getPostCode();
            $request = new \GoogleMaps\Request();
            $request->setAddress($address);
            $proxy = new \GoogleMaps\Geocoder();
            $response = $proxy->geocode($request);
            $results = $response->getResults();

            foreach ($results as $result) {
                $geometry = $result->getGeometry();
                $location = $geometry->getLocation();
                $lat = $location->getLat();
                $long = $location->getLng();
            }

            $retailer->setLatitude($lat)
                ->setLongitude($long);
        }

        $retailer->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($retailer);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new RetailerEvent('retailerCreated', $retailer));

        return $retailer;
    }

    /**
     * Edit an existing retailer.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  RetailerInterface                  $retailer
     * @throws Exception\UnexpectedValueException
     * @return null|RetailerInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, RetailerInterface $retailer)
    {
        $this->retailerForm->bind($retailer);
        $this->retailerForm->setData($data);

        if (!$this->retailerForm->isValid()) {
            return null;
        }

        $retailer = $this->retailerForm->getData();

        if (!$retailer instanceof RetailerInterface) {
            throw Exception\UnexpectedValueException::invalidRetailerEntity($retailer);
        }

        if ($retailer->getRetailerType() == 'physical') {
            $address = $retailer->getStreetAddress();
            $address .= ($retailer->getExtStreetAddress() ? ', ' . $retailer->getExtStreetAddress() : '');
            $address .= ', ' . $retailer->getLocality() . ', ' . $retailer->getRegion()->getSubdivisionName() . ' ' . $retailer->getPostCode();
            $request = new \GoogleMaps\Request();
            $request->setAddress($address);
            $proxy = new \GoogleMaps\Geocoder();
            $response = $proxy->geocode($request);
            $results = $response->getResults();

            foreach ($results as $result) {
                $geometry = $result->getGeometry();
                $location = $geometry->getLocation();
                $lat = $location->getLat();
                $long = $location->getLng();
            }

            $retailer->setLatitude($lat)
                ->setLongitude($long);
        }

        $retailer->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new RetailerEvent('retailerEdited', $retailer));

        return $retailer;
    }

    /**
     * Delete an existing retailer.
     *
     * @param  UserInterface                      $identity
     * @param  RetailerInterface                  $retailer
     * @throws Exception\UnexpectedValueException
     * @return null|RetailerInterface
     */
    public function delete(UserInterface $identity, RetailerInterface $retailer)
    {
        if (!$retailer instanceof RetailerInterface) {
            throw Exception\UnexpectedValueException::invalidRetailerEntity($retailer);
        }

        $retailer->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new RetailerEvent('retailerDeleted', $retailer));

        return $retailer;
    }

    /**
     * @return RetailerInterface
     */
    public function getRetailerPrototype()
    {
        if ($this->retailerPrototype === null) {
            $this->setRetailerPrototype(new Retailer());
        }

        return $this->retailerPrototype;
    }

    /**
     * @param  RetailerInterface $retailerPrototype
     * @return RetailerService
     */
    public function setRetailerPrototype(RetailerInterface $retailerPrototype)
    {
        $this->retailerPrototype = $retailerPrototype;

        return $this;
    }

    /**
     * setEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::setEventManager()
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__, get_class($this)));

        $this->eventManager = $eventManager;
    }

    /**
     * getEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::getEventManager()
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }

    public function getGeo($zip)
    {
        $request = new \GoogleMaps\Request();
        $request->setAddress($zip);
        $proxy = new \GoogleMaps\Geocoder();
        $response = $proxy->geocode($request);
        $results = $response->getResults();

        foreach ($results as $result) {
            $geometry = $result->getGeometry();
            $location = $geometry->getLocation();
            $lat = $location->getLat();
            $long = $location->getLng();
        }

        $geoArray = array(
            'lat' => $lat,
            'lon' => $long);

        return $geoArray;
    }

    public function getDistance($zip1 = null, $zip2 = null)
    {
        // returns the distance between to zip codes.  If there is an error, the
        // function will return false and set the $last_error variable.

        $this->chronometer();         // start the clock

        if ($zip1 == $zip2) { return 0; } // same zip code means 0 miles between. :)

        // get details from database about each zip and exit if there is an error

        $details1 = $this->getZipPoint($zip1);
        $details2 = $this->getZipPoint($zip2);
        if ($details1 == false) {
            $this->last_error = "No details found for postal code: $zip1";

            return false;
        }
        if ($details2 == false) {
            $this->last_error = "No details found for postal code: $zip2";

            return false;
        }

        // calculate the distance between the two points based on the lattitude
        // and longitude pulled out of the database.

        $miles = $this->calculateMileage($details1[0], $details2[0], $details1[1], $details2[1]);

        $this->last_time = $this->chronometer();

        if ($this->units == _UNIT_KILOMETERS) { return round($miles * _M2KM_FACTOR, $this->decimals); } else { return round($miles, $this->decimals); }       // must be miles
    }
    				
    public function getZipRetailers($zipstring = null, $zips = null )
    {
        $records = $this->retailerRepository->getZipRetailers($zipstring, $zips);

        if (null != $records) {
            foreach ($records as $record) {
            	
                $id = $record->getRetailerId();
                $pc = $record->getPostCode();
                $retailers[$id]['retailer'] = $record;
                $retailers[$id]['distance'] = $zips[$pc];
                
            }

            return $records;
        } else {
            return false;
        }
    }

    public function getZipDetails($zip = null)
    {
        // This function pulls the details from the database for a
        // given zip code.
        $records = $this->postalCodeRepository->findBy(
            array(
                'code' => $zip,
            ),
            array()
        );

        if (null == $records) {
            $this->last_error = 'No records found';

            return false;
        } else {
            return $records;
        }
    }

    public function getZipPoint($zip = null)
    {
        // This function pulls just the lattitude and longitude from the
        // database for a given zip code.

        $records = $this->postalCodeRepository->findBy(
            array(
                'code' => $zip,
            ),
            array()
        );

        if (null == $records) {
            $this->last_error = 'No records found';

            return false;
        } else {
            return $records;
        }
    }

    public function calculateMileage($lat1 = null, $lat2 = null, $lon1 = null, $lon2 = null)
    {
        // used internally, this function actually performs that calculation to
        // determine the mileage between 2 points defined by lattitude and
        // longitude coordinates.  This calculation is based on the code found
        // at http://www.cryptnet.net/fsp/zipdy/

        // Convert lattitude/longitude (degrees) to radians for calculations
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Find the deltas
        $delta_lat = $lat2 - $lat1;
        $delta_lon = $lon2 - $lon1;

        // Find the Great Circle distance
        $temp = pow(sin($delta_lat/2.0),2) + cos($lat1) * cos($lat2) * pow(sin($delta_lon/2.0),2);
        $distance = 3956 * 2 * atan2(sqrt($temp),sqrt(1-$temp));

        return $distance;
    }

    public function getZipsInRange($zip = null, $range = null, $sort = 1, $include_base = null)
    {
        // returns an array of the zip codes within $range of $zip. Returns
        // an array with keys as zip codes and values as the distance from
        // the zipcode defined in $zip.

        $this->chronometer();                     // start the clock

        $records = $this->getZipPoint($zip);  // base zip details
        if (null == $records) { return false; }

        $details[0] = $records[0]->getLat();
        $details[1] = $records[0]->getLon();

        // This portion of the routine  calculates the minimum and maximum lat and
        // long within a given range.  This portion of the code was written
        // by Jeff Bearer (http://www.jeffbearer.com). This significanly decreases
        // the time it takes to execute a query.  My demo took 3.2 seconds in
        // v1.0.0 and now executes in 0.4 seconds!  Greate job Jeff!

        // Find Max - Min Lat / Long for Radius and zero point and query
        // only zips in that range.
        $lat_range = $range/69.172;
        $lon_range = abs($range/(cos($details[0]) * 69.172));
        $min_lat = number_format($details[0] - $lat_range, "4", ".", "");
        $max_lat = number_format($details[0] + $lat_range, "4", ".", "");
        $min_lon = number_format($details[1] - $lon_range, "4", ".", "");
        $max_lon = number_format($details[1] + $lon_range, "4", ".", "");

        $return = array();    // declared here for scope

        if (!$include_base) {
            $includbasezip = $zip;
        } else {
            $includbasezip = null;
        }

        $records = $this->postalCodeRepository->findBetween($min_lat, $max_lat, $min_lon, $max_lon, $includbasezip);

        if (null == $records) {    // sql error
            $this->last_error = 'No records found';

            return false;
        } else {
            foreach ($records as $record) {
                // loop through all 40 some thousand zip codes and determine whether
                // or not it's within the specified range.
                $dist = $this->calculateMileage($details[0],$record->getLat(),$details[1],$record->getLon());
                if ($this->units == _UNIT_KILOMETERS) { $dist = $dist * _M2KM_FACTOR; }
                if ($dist <= $range) {
                    $return[str_pad($record->getCode(), 5, "0", STR_PAD_LEFT)] = round($dist, $this->decimals);
                }
            }
        }

        // sort array
        switch ($sort) {
            case _ZIPS_SORT_BY_DISTANCE_ASC:
                asort($return);
                break;
            case _ZIPS_SORT_BY_DISTANCE_DESC:
                arsort($return);
                break;
            case _ZIPS_SORT_BY_ZIP_ASC:
                ksort($return);
                break;
            case _ZIPS_SORT_BY_ZIP_DESC:
                krsort($return);
            break;
        }

        $this->last_time = $this->chronometer();
        if (empty($return)) { return false; }

        return $return;
    }

    public function chronometer()
    {
        // chronometer function taken from the php manual.  This is used primarily
        // for debugging and anlyzing the functions while developing this class.

        $now = microtime(TRUE);  // float, in _seconds_
        $now = $now + time();
        $malt = 1;
        $round = 7;

        if ($this->last_time > 0) {
            /* Stop the chronometer : return the amount of time since it was started,
            in ms with a precision of 3 decimal places, and reset the start time.
            We could factor the multiplication by 1000 (which converts seconds
            into milliseconds) to save memory, but considering that floats can
            reach e+308 but only carry 14 decimals, this is certainly more precise */

            $retElapsed = round($now * $malt - $this->last_time * $malt, $round);

            $this->last_time = $now;

            return $retElapsed;
        } else {
            // Start the chronometer : save the starting time

            $this->last_time = $now;

            return 0;
        }
    }
}
