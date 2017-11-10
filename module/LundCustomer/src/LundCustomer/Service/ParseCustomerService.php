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

use LundCustomer\Entity\Customer;
use LundCustomer\Entity\CustomerInterface;
use LundCustomer\Repository\CustomerRepositoryInterface;
use LundCustomer\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use DateTime;

/**
 * Service managing the management of customers.
 */
class ParseCustomerService implements EventManagerAwareInterface
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
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerInterface
     */
    protected $customerPrototype;

    /**
     * @param ObjectManager               $objectManager
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->objectManager  = $objectManager;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Creates a new customer.
     *
     * @param  string                  $custId
     * @param  string                  $name
     * @param  string                  $filePickup
     * @param  string                  $filePush
     * @param  string                  $ftpSite
     * @param  string                  $ftpUser
     * @param  string                  $ftpPass
     * @param  \RocketUser\Entity\User $user
     * @param  string                  $email
     * @param  string                  $contactName
     * @param  string                  $updateType
     * @param  string                  $frequency
     * @param  string                  $acesVersion
     * @param  string                  $piesVersion
     * @param  string                  $lund
     * @param  string                  $dfmal
     * @param  string                  $avs
     * @param  string                  $nifty
     * @param  string                  $tradesman
     * @param  string                  $lmp
     * @param  string                  $amp
     * @param  string                  $htam
     * @param  string                  $belmor
     * @param  string                  $lundAll
     * @param  string                  $imageType
     * @param  string                  $renameImages
     * @param  string                  $acceptVideo
     * @param  string                  $videoType
     * @return null|CustomerInterface
     */
    public function insertCustomer($custId = null, $name = null, $filePickup = null, $filePush = null, $ftpSite = null,
                                   $ftpUser = null, $ftpPass = null, $user = null,
                                   $email = null, $contactName = null, $updateType = null, $frequency = null,
                                   $acesVersion = null, $piesVersion = null, $lund = null, $dfmal = null, $avs = null,
                                   $nifty = null, $tradesman = null, $lmp = null, $amp = null, $htam = null, $belmor = null,
                                   $lundAll = null,  $rampage = null, $bushwacker = null, $stampede = null, $tonnopro = null, $imageType = null, 
    							   $renameImages = null, $acceptVideo = null, $videoType = null, $customerOrDealer = null)
    {
        $customer = clone $this->getCustomerPrototype();

        $customer->setCreatedAt(new DateTime('now'))
            ->setCreatedBy('system')
            ->setDeleted(false)
            ->setDisabled(false)
            ->setCustId($custId)
            ->setName($name)
            ->setFilePickup($filePickup)
            ->setFilePush($filePush)
            ->setFtpSite($ftpSite)
            ->setFtpUser($ftpUser)
            ->setFtpPass($ftpPass)
            ->setUser($user)
            ->setEmail($email)
            ->setContactName($contactName)
            ->setUpdateType($updateType)
            ->setFrequency($frequency)
            ->setAcesVersion($acesVersion)
            ->setPiesVersion($piesVersion)
            ->setLund($lund)
            ->setDfmal($dfmal)
            ->setAvs($avs)
            ->setNifty($nifty)
            ->setTradesman($tradesman)
            ->setLmp($lmp)
            ->setAmp($amp)
            ->setHtam($htam)
            ->setBelmor($belmor)
            ->setLundAll($lundAll)
            ->setRampage($rampage)
            ->setBushwacker($bushwacker)
            ->setStampede($stampede)
            ->setTonnopro($tonnopro)
            ->setImageType($imageType)
            ->setRenameImages($renameImages)
            ->setAcceptVideo($acceptVideo)
            ->setVideoType($videoType)
            ->setCustomerOrDealer($customerOrDealer);

        $this->objectManager->persist($customer);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerEvent('customerCreated', $customer));

        return $customer;
    }

    /**
     * Edits existing customer.
     *
     * @param  CustomerInterface      $customer
     * @param  string                 $custId
     * @param  string                 $name
     * @param  string                 $filePickup
     * @param  string                 $filePush
     * @param  string                 $ftpSite
     * @param  string                 $ftpUser
     * @param  string                 $ftpPass
     * @param  string                 $email
     * @param  string                 $contactName
     * @param  string                 $updateType
     * @param  string                 $frequency
     * @param  string                 $acesVersion
     * @param  string                 $piesVersion
     * @param  string                 $lund
     * @param  string                 $dfmal
     * @param  string                 $avs
     * @param  string                 $nifty
     * @param  string                 $tradesman
     * @param  string                 $lmp
     * @param  string                 $amp
     * @param  string                 $htam
     * @param  string                 $belmor
     * @param  string                 $lundAll
     * @param  string                 $imageType
     * @param  string                 $renameImages
     * @param  string                 $acceptVideo
     * @param  string                 $videoType
     * @return null|CustomerInterface
     */
    public function editCustomer(CustomerInterface $customer,
                                 $custId = null, $name = null, $filePickup = null, $filePush = null, $ftpSite = null,
                                 $ftpUser = null, $ftpPass = null,
                                 $email = null, $contactName = null, $updateType = null, $frequency = null,
                                 $acesVersion = null, $piesVersion = null, $lund = null, $dfmal = null, $avs = null,
                                 $nifty = null, $tradesman = null, $lmp = null, $amp = null, $htam = null, $belmor = null,
                                 $lundAll = null, $rampage = null, $bushwacker = null, $stampede = null, $tonnopro = null, $imageType = null, 
    							 $renameImages = null, $acceptVideo = null, $videoType = null, $customerOrDealer = null, $disabled = null)
    {
        $customer->setModifiedAt(new DateTime('now'))
            ->setModifiedBy('system')
            ->setCustId($custId)
            ->setName($name)
            ->setFilePickup($filePickup)
            ->setFilePush($filePush)
            ->setFtpSite($ftpSite)
            ->setFtpuser($ftpUser)
            ->setFtpPass($ftpPass)
            ->setEmail($email)
            ->setContactName($contactName)
            ->setUpdateType($updateType)
            ->setFrequency($frequency)
            ->setAcesVersion($acesVersion)
            ->setPiesVersion($piesVersion)
            ->setLund($lund)
            ->setDfmal($dfmal)
            ->setAvs($avs)
            ->setNifty($nifty)
            ->setTradesman($tradesman)
            ->setLmp($lmp)
            ->setAmp($amp)
            ->setHtam($htam)
            ->setBelmor($belmor)
            ->setLundAll($lundAll)
            ->setRampage($rampage)
            ->setBushwacker($bushwacker)
            ->setStampede($stampede)
            ->setTonnopro($tonnopro)
            ->setImageType($imageType)
            ->setRenameImages($renameImages)
            ->setAcceptVideo($acceptVideo)
            ->setVideoType($videoType)
            ->setCustomerOrDealer($customerOrDealer)
        	->setDisabled($disabled);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerEvent('customerEdited', $customer));

        return $customer;
    }
    /**
     * @return CustomerInterface
     */
    public function getCustomerPrototype()
    {
        if ($this->customerPrototype === null) {
            $this->setCustomerPrototype(new Customer());
        }

        return $this->customerPrototype;
    }

    /**
     * @param  CustomerInterface    $customerPrototype
     * @return ParseCustomerService
     */
    public function setCustomerPrototype(CustomerInterface $customerPrototype)
    {
        $this->customerPrototype = $customerPrototype;

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
}
