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

use LundCustomer\Entity\CustomerTransmit;
use LundCustomer\Entity\CustomerTransmitInterface;
use LundCustomer\Entity\Customer;
use LundCustomer\Entity\CustomerInterface;
use RocketDam\Entity\Asset;
use LundProducts\Entity\Brands;
use LundCustomer\Repository\CustomerTransmitRepositoryInterface;
use LundCustomer\Repository\CustomerRepositoryInterface;
use RocketDam\Repository\AssetRepositoryInterface;
use LundProducts\Repository\BrandsRepositoryInterface;
use LundProducts\Service\ChangesetsService;
use LundCustomer\Options\LundCustomerOptionsInterface;
use LundCustomer\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use Ftp;
use LundProducts\Service\FileLogService;
use LundCustomer\Service\CustomerService;
use Zend\Mail;

/**
 * Service managing the management of customer transmit logs.
 */
class CustomerTransmitService implements EventManagerAwareInterface
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
     * @var CustomerTransmitRepositoryInterface
     */
    protected $customerTransmitRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var AssetRepositoryInterface
     */
    protected $assetRepository;

    /**
     * @var BrandsRepositoryInterface;
     */
    protected $brandsRepository;

    /**
     * @var ChangesetsService;
     */
    protected $changesetsService;

    /**
     * @var FileLogService;
     */
    protected $fileLogService;

    /**
     * @var CustomerService
     */
    protected $customerService;

    /**
     * @var LundCustomerOptionsInterface
     */
    protected $options;

    /**
     * @var CustomerTransmitInterface
     */
    protected $customerTransmitPrototype;

    /**
     * @param ObjectManager                       $objectManager
     * @param CustomerTransmitRepositoryInterface $customerTransmitRepository
     * @param CustomerRepositoryInterface         $customerRepository
     * @param AssetRepositoryInterface            $assetRepository
     * @param BrandsRepositoryInterface           $brandsRepository
     * @param ChangesetsService                   $changesetsService
     * @param FileLogService                      $fileLogService
     * @param CustomerService                     $customerService
     * @param LundCustomerOptionsInterface        $options
     */
    public function __construct(
        ObjectManager $objectManager,
        CustomerTransmitRepositoryInterface $customerTransmitRepository,
        CustomerRepositoryInterface $customerRepository,
        AssetRepositoryInterface $assetRepository,
        BrandsRepositoryInterface $brandsRepository,
        ChangesetsService $changesetsService,
        FileLogService $fileLogService,
        CustomerService $customerService,
        LundCustomerOptionsInterface $options
    ) {
        $this->objectManager  = $objectManager;
        $this->customerTransmitRepository = $customerTransmitRepository;
        $this->customerRepository = $customerRepository;
        $this->assetRepository = $assetRepository;
        $this->brandsRepository = $brandsRepository;
        $this->changesetsService = $changesetsService;
        $this->fileLogService = $fileLogService;
        $this->customerService = $customerService;
        $this->options        = $options;
    }

    /**
     * Return a list of customer transmit logs
     *
     * @return CustomerTransmitInterface
     */
    public function getCustomerTransmitLogs()
    {
        return $this->customerTransmitRepository->findBy(
            array(),
            array(
                'createdAt'   => 'DESC',
            )
        );
    }

    /**
     * Return a list of customer transmit logs by customer
     *
     * @return CustomerTransmitInterface
     */
    public function getCustomerTransmitLogsByCustomer(CustomerInterface $customer)
    {
        return $this->customerTransmitRepository->findBy(
            array(
                'customer' => $customer->getCustomerId(),
            ),
            array(
                'createdAt' => 'DESC',
            )
        );
    }

    /**
     * Return customerTransmit  entity
     *
     * @param  string                    $transmitId
     * @return CustomerTransmitInterface
     */
    public function getCustomerTransmit($transmitId)
    {
        $customerTransmit = $this->customerTransmitRepository->find($transmitId);

        return $customerTransmit;
    }

    /**
     * Transmit packages to customer
     *
     * @param  CustomerInterface $customer
     * @return mixed
     */
    public function transmit(CustomerInterface $customer)
    {
        $data = array(
            'customer' => $customer->getCustomerId(),
        );

        if ($customer->getFilePush()) {
            $changesets = $this->changesetsService->getChangesetByFrequency($customer->getFrequency());

            foreach ($changesets as $changeset) {
                $files = $this->fileLogService->getFileLogByChangeset($changeset);

                echo count($files);exit;
                foreach ($files as $file) {
                    if ($file->getBrand() == 'BELMOR') { continue; }
                    $result = null;
                    $data['asset'] = $file->getAsset()->getAssetId();

                    if ($customer->getUpdateType() == 'net' && ($file->getType() == 'master' || $file->getType() == 'aces-incr' || $file->getType() == 'pies-incr-xml' || $file->getType() == 'pies-incr-csv' || $file->getType() == 'assetpackage')) {

                        if ($file->getType() == 'aces-incr' && $customer->getAcesVersion() == 'FLAT') {
                            continue;
                        } elseif ($file->getType() == 'master' && $customer->getAcesVersion() != 'FLAT') {
                            continue;
                        } elseif ($file->getType() == 'pies-incr-xml' && $customer->getPiesVersion() == 'FLAT') {
                            continue;
                        } elseif ($file->getType() == 'pies-incr-csv' && $customer->getPiesVersion() != 'FLAT') {
                            continue;
                        }

                        if ($file->getBrand() == 'AVS' && !$customer->getAvs()) {
                            continue;
                        } elseif ($file->getBrand() == 'LUNDONLY' && !$customer->getLund()) {
                            continue;
                        } elseif ($file->getbrand() == 'LUND' && !$customer->getLundAll()) {
                            continue;
                        } elseif ($file->getBrand() == 'NIFTY' && !$customer->getNifty()) {
                            continue;
                        } elseif ($file->getBrand() == 'DFS ALUM' && !$customer->getDfmal()) {
                            continue;
                        }

                        if ($file->getBrand() == 'LUNDONLY') {
                            $theBrand = 'LUND';
                        } else {
                            $theBrand = $file->getBrand();
                        }

                        $data['brand'] = $this->brandsRepository->findOneBy(array('name' => $theBrand));

                        if ($customer->getFtpSite() && $customer->getFtpUser() && $customer->getFtpPass()) {
                            $ftp = new Ftp();
                            //$ftp->connect('lundlibrary.com');
                            //$ftp->login('newtest', 'newt');
                            $ftp->connect($customer->getFtpSite());
                            $ftp->login($customer->getFtpUser(), $customer->getFtpPass());

                            $sourceFile = realpath(__DIR__ . '/../../../../../public/assets/' . $file->getAsset()->getFilePath());

                            $result = $ftp->put($file->getAsset()->getFileName(), $sourceFile, FTP_BINARY);

                            if ($result) {
                                $customerTransmit = $this->create($data);
                                $customerUpdate = $this->customerService->transmitUpdate($customer);
                            }
                        } else {
                            // FIRE AN EMAIL
                            $message = 'Please log in to the customer portal for your new data files http://myautostores.com/login.<br>';
                            $mail = new Mail\Message();
                            $html = new \Zend\Mime\Part($message);
                            $html->type = 'text/html';
                            //echo $file->getAsset()->getFilePath()." - ";
                            //$attachment = new \Zend\Mime\Part(fopen(realpath(__DIR__ . '/../../../../../public/assets/' . $file->getAsset()->getFilePath()), 'r'));
                            //$attachment->type = $file->getAsset()->getMime();
                            //$attachment->filename = $file->getAsset()->getFileName();
                            //$attachment->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
                            $body = new \Zend\Mime\Message();
                            $body->setParts(array($html));
                            $mail->setBody($body);
                            $mail->setFrom('webit@thesmartdata.com');
                            $mail->addTo($customer->getEmail());
                            $mail->setSubject('You have received a product update from My Auto Stores');
                            $transport = new Mail\Transport\Sendmail();
                            $transport->send($mail);

                            $customerTransmit = $this->create($data);
                            $customerUpdate = $this->customerService->transmitUpdate($customer);
                        }
                    } elseif ($customer->getUpdateType() == 'full' && ($file->getType() == 'aces-full' || $file->getType() == 'pies-full-xml' || $file->getType() == 'pies-full-csv' || $file->getType() == 'master' || $file->getType() == 'assetpackage')) {
                        if ($file->getType() == 'aces-full' && $customer->getAcesVersion() == 'FLAT') {
                            continue;
                        } elseif ($file->getType() == 'master' && $customer->getAcesVersion() != 'FLAT') {
                            continue;
                        } elseif ($file->getType() == 'pies-full-xml' && $customer->getPiesVersion() == 'FLAT') {
                            continue;
                        } elseif ($file->getType() == 'pies-full-csv' && $customer->getPiesVersion() != 'FLAT') {
                            continue;
                        }

                        if ($file->getBrand() == 'AVS' && !$customer->getAvs()) {
                            continue;
                        } elseif ($file->getBrand() == 'LUNDONLY' && !$customer->getLund()) {
                            continue;
                        } elseif ($file->getbrand() == 'LUND' && !$customer->getLundAll()) {
                            continue;
                        } elseif ($file->getBrand() == 'NIFTY' && !$customer->getNifty()) {
                            continue;
                        } elseif ($file->getBrand() == 'DFS ALUM' && !$customer->getDfmal()) {
                            continue;
                        }

                        if ($file->getBrand() == 'LUNDONLY') {
                            $theBrand = 'LUND';
                        } else {
                            $theBrand = $file->getBrand();
                        }

                        $data['brand'] = $this->brandsRepository->findOneBy(array('name' => $theBrand));

                        if ($customer->getFtpSite() && $customer->getFtpUser() && $customer->getFtpPass()) {
                            $ftp = new Ftp();
                            $ftp->connect('lundlibrary.com');
                            $ftp->login('newtest', 'newt');
                            //$ftp->connect($customer->getFtpSite());
                            //$ftp->login($customer->getFtpUser(), $customer->getFtpPass());

                            $sourceFile = realpath(__DIR__ . '/../../../../../public/assets/' . $file->getAsset()->getFilePath());

                            $result = $ftp->put($file->getAsset()->getFileName(), $sourceFile, FTP_BINARY);

                            if ($result) {
                                $customerTransmit = $this->create($data);
                                $customerUpdate = $this->customerService->transmitUpdate($customer);
                            }
                        } else {
                            // FIRE AN EMAIL
                            $message = 'Please log in to the customer portal for your new data files http://myautostores.com/login.<br>';
                            $mail = new Mail\Message();
                            $html = new \Zend\Mime\Part($message);
                            $html->type = 'text/html';
                            //$attachment = new \Zend\Mime\Part(fopen(realpath(__DIR__ . '/../../../../../public/assets/' . $file->getAsset()->getFilePath())));
                            //$attachment->type = $file->getMime();
                            $body = new \Zend\Mime\Message();
                            $body->setParts(array($html));
                            $mail->setBody($body);
                            $mail->setFrom('webit@thesmartdata.com');
                            //$mail->addTo($customer->getEmail());
                            $mail->addTo('rsampson@thesmartdata.com');
                            $mail->setSubject('You have received a product update from My Auto Stores');
                            $transport = new Mail\Transport\Sendmail();
                            $transport->send($mail);

                            $customerTransmit = $this->create($data);
                            $customerUpdate = $this->customerService->transmitUpdate($customer);
                        }
                    }
                }
            }
        } elseif ($customer->getFilePickup()) {
            // TODO: Send notification that files are ready for pickup
        }
    }

    /**
     * Creates a new customer transmit log
     *
     * @param  mixed                              $data
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerTransmitInterface
     */
    public function create($data)
    {
        $customerTransmit = clone $this->getCustomerTransmitPrototype();

        if (!$customerTransmit instanceof CustomerTransmitInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerTransmitEntity($customerTransmit);
        }

        $customer = $this->customerRepository->findOneBy(array('customerId' => $data['customer']));
        $asset    = $this->assetRepository->findOneBy(array('assetId' => $data['asset']));
        $brand    = $this->brandsRepository->findOneBy(array('brandId' => $data['brand']));

        $customerTransmit->setCreatedAt(new DateTime('now'))
            ->setCreatedBy('system')
            ->setCustomer($customer)
            ->setAsset($asset)
            ->setBrand($brand);

        $this->objectManager->persist($customerTransmit);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerTransmitEvent('customerTransmitCreated', $customerTransmit));

        return $customerTransmit;
    }

    /**
     * @return CustomerTransmitInterface
     */
    public function getCustomerTransmitPrototype()
    {
        if ($this->customerTransmitPrototype === null) {
            $this->setCustomerTransmitPrototype(new CustomerTransmit());
        }

        return $this->customerTransmitPrototype;
    }

    /**
     * @param  CustomerTransmitInterface $customerTransmitPrototype
     * @return CustomerTransmitService
     */
    public function setCustomerTransmitPrototype(CustomerTransmitInterface $customerTransmitPrototype)
    {
        $this->customerTransmitPrototype = $customerTransmitPrototype;

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
