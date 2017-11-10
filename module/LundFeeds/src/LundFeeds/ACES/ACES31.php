<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage ACES
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\ACES;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\AcesService;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;
use SimpleXMLElement;
use DOMDocument;
use Exception;

class ACES31 implements AcesInterface
{
    /**
     * @var SimpleXMLElement
     */
    protected $xml = null;

    /**
     * @var PartService
     */
    protected $partService = null;

    /**
     * @var AcesService
     */
    protected $acesService = null;

    /**
     * @var int
     */
    protected $recordCount = 0;

    /**
     * @var BrandsRepository
     */
    protected $brandsRepository = null;

    /**
     * @var ChangesetsService
     */
    protected $changesetsService = null;

    /**
     * @var ChangesetDetailsService
     */
    protected $changesetDetailsService = null;

    /**
     * @var ChangesetDetailsVehiclesService
     */
    protected $changesetDetailsVehiclesService = null;

    /**
     * @var string
     */
    protected $brand = null;

    /**
     * @var string
     */
    protected $lundonly = null;

    /**
     * @var string
     */
    protected $generate = null;

    /**
     * @var int
     */
    protected $changeset_id = null;

    /**
     * @param PartService                     $partService
     * @param AcesService                     $acesService
     * @param BrandsRepository                $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetaisVehiclesService
     * @param string                          $brand
     * @param string                          $generate
     * @param int                             $changeset_id
     */
    public function __construct(PartService      $partService = null,
                                AcesService      $acesService = null,
                                BrandsRepository $brandsRepository = null,
                                ChangesetsService $changesetsService = null,
                                ChangesetDetailsService $changesetDetailsService = null,
                                ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
                                $brand        = null,
                                $generate     = null,
                                $changeset_id = null)
    {
        if (null == $this->xml) {
            $this->xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><ACES></ACES>');
            $this->xml->addAttribute('version', '3.1');
        }

        if (null != $partService) {
            if (null == $this->partService) {
                $this->partService = $partService;
            }
        }

        if (null != $acesService) {
            $this->acesService = $acesService;
        }

        if (null != $brandsRepository) {
            $this->brandsRepository = $brandsRepository;
        }

        if (null != $changesetsService) {
            $this->changesetsService = $changesetsService;
        }

        if (null != $changesetDetailsService) {
            $this->changesetDetailsService = $changesetDetailsService;
        }

        if (null != $changesetDetailsVehiclesService) {
            $this->changesetDetailsVehiclesService = $changesetDetailsVehiclesService;
        }

        if (null != $brand) {
            if ($brand == 'LUNDONLY') {
                $this->brand = $this->brandsRepository->findOneBy(['name' => 'LUND']);
                $this->lundonly = true;
            } else {
                $this->brand = $this->brandsRepository->findOneBy(['name' => trim(strtoupper($brand))]);
            }

            if (!$this->brand) {
                throw new Exception('Couldn\'t find brand \'' . $brand . '\'');
            }
        } else {
            $this->brand = null;
        }

        if (null != $generate) {
            $this->generate = $generate;
        }

        if (null != $changeset_id) {
            $this->changeset_id = $changeset_id;
        } else {
            $this->changeset_id = null;
        }
    }

    /**
     * @return void
     */
    public function getHeader()
    {
        $header = $this->xml->addChild('Header');
        $header->addChild('Company', 'Lund International');
        $header->addChild('SenderName', 'Raven Sampson');
        $header->addChild('SenderPhone', '6788043803');
        $header->addChild('TransferDate', date('Y-m-d'));
        $header->addChild('BrandAAIAID', ((null != $this->brand) ? $this->brand->getAaiaid() : 'BLHW')); // if brand is not null, use that brand, else, use BLHW for parent code/brand
        if (null != $this->brand) {
            if ($this->brand->getName() == 'LUND' && null == $this->lundonly) {
                $header->addChild('DocumentTitle', 'Lund International ACES ' . ((null != $this->brand) ? $this->brand->getName() . ' +NIFTY +DFS ALUM' : '') . ' ' . date('Y-m-d'));
            } else {
                $header->addChild('DocumentTitle', 'Lund International ACES ' . ((null != $this->brand) ? $this->brand->getName() : '') . ' ' . date('Y-m-d'));
            }
        } else {
            $header->addChild('DocumentTitle', 'Lund International ACES Lund International' . date('Y-m-d'));
        }

        $header->addChild('EffectiveDate', date('Y-m-d'));
        $header->addChild('SubmissionType', ($this->generate == 'full' ? 'FULL' : 'NET'));
        $header->addChild('VcdbVersionDate', '2015-06-26');
        $header->addChild('QdbVersionDate', '2015-06-26');
        $header->addChild('PcdbVersionDate', '2015-06-26');
    }

    /**
     * @return void
     */
    public function getBody()
    {
        $partIdArray = array();

        $iterator = 1;

        if ($this->generate == 'incr' && isset($this->changeset_id)) {
            $changeset = $this->changesetsService->getChangeset($this->changeset_id);
            $changeset_details = $this->changesetDetailsService->getChangesetDetailsByChangesetId($this->changeset_id);

            foreach ($changeset_details as $record) {
                if (null != $record->getParts()) {
                    $part = $record->getParts();
                } else {
                    $part = $this->partService->getPartByPartNumber($record->getPartNumber());
                }

                if (null != $this->brand) {
                    $partBrand = $part->getProductLine()->getBrand()->getName();
                    $partOrigBrand = $part->getProductLine()->getOrigBrand()->getName();

                    if (null != $this->lundonly) {
                        if ($partOrigBrand != 'LUND') {
                            continue;
                        }
                    } elseif ($this->brand->getName() == 'LUND') {
                        if ($partBrand != $this->brand->getName()) {
                            continue;
                        }
                    } else {
                        if ($partOrigBrand != $this->brand->getName()) {
                            continue;
                        }
                    }
                }

                if (!array_key_exists($part->getPartId(), $partIdArray)) {
                    $partIdArray[$part->getPartId()] = array();
                }

                $vehicles = $this->changesetDetailsVehiclesService->getChangesetDetailsVehiclesByChangesetDetailsId($record->getChangesetDetailId());

                $vehicleArray = array();

                foreach ($vehicles as $vehicle) {
                    if (null != $vehicle->getVehCollection()) {
                        $vehCollection = $vehicle->getVehCollection();
                    } else {
                        $vehSubmodel = ($vehicle->getVehSubmodel() ? $vehicle->getVehSubmodel()->getVehSubmodelId() : null);
                        $vehCollection = $this->changesetsService->getVehicleCollection(
                            $vehicle->getVehYear()->getVehYearId(),
                            $vehicle->getVehMake()->getVehMakeId(),
                            $vehicle->getVehModel()->getVehModelId(),
                            $vehSubmodel);
                    }

                    if (null == $vehCollection) {
                        continue;
                    }

                    if (is_array($vehCollection)) {
                        $vehCollection = $vehCollection[0];
                    }

                    $partIdArray[$part->getPartId()]['vehcols'][] = $vehCollection->getVehCollectionId();

                    $thisHash = (STRING)(($vehCollection->getVehMake()) ? $vehCollection->getVehMake()->getVehMakeId() : '') .
                                (($vehCollection->getVehModel()) ? '-' . $vehCollection->getVehModel()->getVehModelId() : '') .
                                (($vehCollection->getVehSubmodel()) ? '-' . $vehCollection->getVehSubmodel()->getVehSubmodelId() : '');

                    $vehicleArray[$thisHash]['years'][]           = $vehCollection->getVehYear()->getName();
                    $vehicleArray[$thisHash]['make_id']           = $vehCollection->getMakeId();;
                    $vehicleArray[$thisHash]['model_id']          = $vehCollection->getModelId();
                    $vehicleArray[$thisHash]['submodel_id']       = $vehCollection->getSubmodelId();
                    $vehicleArray[$thisHash]['body_type_id']      = $vehCollection->getBodyTypeId();
                    $vehicleArray[$thisHash]['body_num_doors_id'] = $vehCollection->getBodyNumDoorsId();
                    $vehicleArray[$thisHash]['bed_type_id']       = $vehCollection->getBedTypeId();

                    $partVehicleCollection = $this->changesetsService->getPartVehicleCollection(
                        $part->getPartId(),
                        $vehCollection->getVehCollectionId());

                    if (null != $partVehicleCollection) {
                        if (is_array($partVehicleCollection)) {
                            $partVehicleCollection = $partVehicleCollection[0];
                        }

                        $vehicleArray[$thisHash]['subdetail'] = $partVehicleCollection->getSubdetail();
                    } else {
                        $vehicleArray[$thisHash]['subdetail'] = null;
                    }
                }

                foreach ($vehicleArray as $veh) {
                    $years = [];

                    foreach ($veh['years'] as $year) {
                        $years[] = $year;
                    }

                    $app = $this->xml->addChild('App');

                    if ($record->getChange() == 'delete') {
                        $appAction = 'D';
                    } else {
                        $appAction = 'A';
                    }

                    $app->addAttribute('action', $appAction);
                    $app->addAttribute('id', $iterator);

                    $fromYear = min($years);
                    $toYear   = max($years);

                    $years = $app->addChild('Years');
                    $years->addAttribute('from', (STRING)$fromYear);
                    $years->addAttribute('to', (STRING)$toYear);

                    if ($veh['make_id'] > 0) {
                        $make = $app->addChild('Make');
                        $make->addAttribute('id', $veh['make_id']);
                    }

                    if ($veh['model_id'] > 0) {
                        $model = $app->addChild('Model');
                        $model->addAttribute('id', $veh['model_id']);
                    }

                    if ($veh['submodel_id'] > 0) {
                        $submodel = $app->addChild('SubModel');
                        $submodel->addAttribute('id', $veh['submodel_id']);
                    }

                    if ($veh['body_type_id'] > 0) {
                        $bodytype = $app->addChild('BodyType');
                        $bodytype->addAttribute('id', $veh['body_type_id']);
                    }
					
                    $note = ($veh['subdetail'] ? '; ' . $veh['subdetail'] : '');
                    
                    $note = preg_replace('/&/', 'and', $note);
                    
                    if ($part->getDima() != '0.00') {
                        $note .= ' ' . $part->getDima() . 'x' . $part->getDimb() . 'x' . $part->getDimc() . 'x' . $part->getDimd() . 'x' . $part->getDime() . 'x' . $part->getDimf() . 'x' . $part->getDimg();
                    }

                    $app->addChild('Note', $note);

                    $app->addChild('Qty', '1');

                    if ($part->getPartTypeId() > 0) {
                        $parttype = $app->addChild('PartType');
                        $parttype->addAttribute('id', $part->getPartTypeId());
                    }
                    
                    if ($part->getBedLengthId() > 0) {
                    	$parttype = $app->addChild('BedLength');
                    	$parttype->addAttribute('id', $part->getBedLengthId());
                    }

                    if ($veh['body_num_doors_id'] > 0) {
                        $bodynumdoors = $app->addChild('BodyNumDoors');
                        $bodynumdoors->addAttribute('id', $veh['body_num_doors_id']);
                    }

                    if ($veh['bed_type_id'] > 0) {
                        $bedtype = $app->addChild('BedType');
                        $bedtype->addAttribute('id', $veh['bed_type_id']);
                    }

                    $app->addChild('Part', $part->getPartNumber());

                    $iterator++;

                    $this->recordCount++;
                }
            }
        }


        if ($this->generate == 'full') {
            $records = $this->partService->getAcesParts($this->brand, $this->generate, null, $this->lundonly);

            foreach ($records as $record) {
                $vehicles = array();

                if(!$record->getDisabled())
                {
	                foreach ($record->getVehCollections() as $vehCollection) {
	                    $vehColl = $vehCollection->getVehCollection();
	
	                    if (!empty($vehColl->getBaseVehId())) {
//	                    	if( $vehColl->getBaseVehId() == '6680') {
	                    	
	                    	$partVehicleCollection = $this->changesetsService->getPartVehicleCollection(
	                    			$record->getPartId(),
	                    			$vehCollection->getVehCollection()->getVehCollectionId());
	                    	
	                    	if (null != $partVehicleCollection) {
	                    		if (is_array($partVehicleCollection)) {
	                    			$partVehicleCollection = $partVehicleCollection[0];
	                    		}
	                    	
	                    		$vehicle['subdetail'] = $partVehicleCollection->getSubdetail();
	                    	
	                    		if ($vehColl->getBodyType()) {
	                    			$vehicle['subdetail'] .= '; ' . $vehColl->getBodyType();
	                    		}
	                    	} else {
	                    		if ($vehColl->getBodyType()) {
	                    			$vehicle['subdetail'] = $vehColl->getBodyType();
	                    		} else {
	                    			$vehicle['subdetail'] = null;
	                    		}
	                    	}
	                    	
	                    
		                    $app = $this->xml->addChild('App');
		                    $app->addAttribute('action', 'A');
		                    $app->addAttribute('id', $iterator);
		                    
		                    if (!empty($vehColl->getBaseVehId())) {
		                    	$make = $app->addChild('BaseVehicle');
		                    	$make->addAttribute('id', $vehColl->getBaseVehId());
		                    }
		                    
		                    if (!empty($vehColl->getBodyTypeId())) {
		                    	$make = $app->addChild('BodyType');
		                    	$make->addAttribute('id', $vehColl->getBodyTypeId());
		                    }
                    
		                    if ($record->getBedLengthId() > 0) {
		                    	$parttype = $app->addChild('BedLength');
		                    	$parttype->addAttribute('id', $record->getBedLengthId());
		                    }

		                    if ($vehColl->getBodyNumDoorsId() > 0) {
		                        $bodynumdoors = $app->addChild('BodyNumDoors');
		                        $bodynumdoors->addAttribute('id', $vehColl->getBodyNumDoorsId());
		                    }
		
		                    if (!empty($vehColl->getBedTypeId())) {
		                        $bedtype = $app->addChild('BedType');
		                        $bedtype->addAttribute('id', $vehColl->getBedTypeId());
		                    }
		                    
		                    $note = ($vehicle['subdetail'] ?  $vehicle['subdetail']. '; ' : '');
		                    
		                    $note = preg_replace('/&/', 'and', $note);
		                    
		                    
		                    if (!empty($note)) {
		                    	$app->addChild('Note', $note);
		                    }
		                    
		                    $app->addChild('Qty', '1');
		                    
		                    if (!in_array(trim($record->getPartTypeId()), array('', '0'))) {
		                    	$parttype = $app->addChild('PartType');
		                    	$parttype->addAttribute('id', $record->getPartTypeId());
		                    }
		
		                    $app->addChild('Part', $record->getPartNumber());
		
		                    $iterator++;
		
		                    $this->recordCount++;
//	                    }
	                    
	                	}
	                    
	                }
                }

            }
            
        }
        
    }

    /**
     * @return void
     */
    public function getFooter()
    {
        $footer = $this->xml->addChild('Footer');
        $footer->addChild('RecordCount', $this->recordCount);
    }

    /**
     * @return string
     */
    public function getXML()
    {
        $this->getHeader();
        $this->getBody();
        $this->getFooter();

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;
        $dom->loadXML($this->xml->asXML());

        return $dom->saveXML();
    }

    /**
     * @param  string $location
     * @return void
     */
    public function saveXML($location = null)
    {
        $this->getHeader();
        $this->getBody();
        $this->getFooter();

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput       = true;
        $dom->loadXML($this->xml->asXML());

        return $dom->save($location);
    }
}
