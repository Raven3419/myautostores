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
use LundCustomer\Entity\Customer;
use LundCustomer\Entity\CustomerInterface;
use LundCustomer\Repository\CustomerRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use LundCustomer\Form\CustomerForm;
use LundCustomer\Options\LundCustomerOptionsInterface;
use LundCustomer\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use RocketDam\Service\AssetService;
use RocketDam\ElFinder\ElFinder;

/**
 * Service managing the management of customers.
 */
class CustomerService implements EventManagerAwareInterface
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
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var CustomerForm
     */
    protected $customerForm;

    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @var LundCustomerOptionsInterface
     */
    protected $options;

    /**
     * @var CustomerInterface
     */
    protected $customerPrototype;

    /**
     * @var string $header
     */
    protected $header = 'Content-Type: application/json';

    /**
     * @param ObjectManager                $objectManager
     * @param UserRepositoryInterface      $userRepository
     * @param CustomerRepositoryInterface  $customerRepository
     * @param FormInterface                $customerForm
     * @param AssetService                 $assetService
     * @param LundCustomerOptionsInterface $options
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        CustomerRepositoryInterface $customerRepository,
        FormInterface $customerForm,
        AssetService $assetService,
        LundCustomerOptionsInterface $options
    ) {
        $this->objectManager  = $objectManager;
        $this->userRepository = $userRepository;
        $this->customerRepository = $customerRepository;
        $this->customerForm       = $customerForm;
        $this->assetService = $assetService;
        $this->options        = $options;
    }

    /**
     * Return a list of active customers
     *
     * @return CustomerInterface
     */
    public function getActiveCustomers()
    {
        return $this->customerRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            ),
            array(
                'name'   => 'ASC',
            )
        );
    }

    /**
     * Return customers based on frequency
     *
     * @param  string            $frequency
     * @return CustomerInterface
     */
    public function getCustomerByLoginPassword($username = null, $password = null)
    {
        return $this->customerRepository->findBy(
            array(
                'email' => $username,
                'disabled' => false,
            ),
            array(
                'customerId' => 'ASC',
            )
        );
    }

    /**
     * Return customers based on frequency
     *
     * @param  string            $frequency
     * @return CustomerInterface
     */
    public function getCustomersByFrequency($frequency)
    {
        return $this->customerRepository->findBy(
            array(
                'deleted' => false,
                'disabled' => false,
                'frequency' => $frequency,
            ),
            array(
                'customerId' => 'ASC',
            )
        );
    }

    /**
     * Return create customer form
     *
     * @return CustomerForm
     */
    public function getCreateCustomerForm()
    {
        $this->customerForm->bind(clone $this->getCustomerPrototype());

        return $this->customerForm;
    }

    /**
     * Return edit customer form
     *
     * @param  string       $customerId
     * @return CustomerForm
     */
    public function getEditCustomerForm($customerId)
    {
        $customer = $this->customerRepository->find($customerId);

        $this->customerForm->bind($customer);

        return $this->customerForm;
    }

    /**
     * Return customer entity
     *
     * @param  string            $customerId
     * @return CustomerInterface
     */
    public function getCustomer($customerId)
    {
        $customer = $this->customerRepository->find($customerId);

        return $customer;
    }

    /**
     * Return customer by custId
     *
     * @param  integer           $custId
     * @return CustomerInterface
     */
    public function findCustomerByCustId($custId)
    {
        $customer = $this->customerRepository->findOneBy(
            array(
                'custId' => $custId,
            )
        );

        return $customer;
    }

    /**
     * Return customer by userId
     *
     * @param  integer           $userId
     * @return CustomerInterface
     */
    public function findCustomerByUserId($userId)
    {
        $customer = $this->customerRepository->findOneBy(
            array(
                'user' => $userId,
            )
        );

        return $customer;
    }

    /**
     * Creates a new customer.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->customerForm->bind(clone $this->getCustomerPrototype());
        $this->customerForm->setData($data);

        if (!$this->customerForm->isValid()) {
            return null;
        }

        $customer = $this->customerForm->getData();

        if (!$customer instanceof CustomerInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerEntity($customer);
        }

        $customer->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($customer);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerEvent('customerCreated', $customer));

        return $customer;
    }

    /**
     * Edit an existing customer.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  CustomerInterface                  $customer
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, CustomerInterface $customer)
    {
        $this->customerForm->bind($customer);
        $this->customerForm->setData($data);

        if (!$this->customerForm->isValid()) {
            return null;
        }

        $customer = $this->customerForm->getData();

        if (!$customer instanceof CustomerInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerEntity($customer);
        }

        $customer->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerEvent('customerEdited', $customer));

        return $customer;
    }

    /**
     * Edit customer last update value
     *
     * @param  CustomerInterface                  $customer
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerInterface
     */
    public function transmitUpdate(CustomerInterface $customer)
    {
        if (!$customer instanceof CustomerInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerEntity($customer);
        }

        $customer->setLastUpdate(new DateTime('now'))
            ->setModifiedBy('system');

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerEvent('customerEdited', $customer));

        return $customer;
    }

    /**
     * Delete an existing customer.
     *
     * @param  UserInterface                      $identity
     * @param  CustomerInterface                  $customer
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerInterface
     */
    public function delete(UserInterface $identity, CustomerInterface $customer)
    {
        if (!$customer instanceof CustomerInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerEntity($customer);
        }

        $customer->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerEvent('customerDeleted', $customer));

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
     * @param  CustomerInterface $customerPrototype
     * @return CustomerService
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

    public function run($cmd = null, $customer = null, $request = null, $post = false)
    {
    	if($customer->getCustomerOrDealer() == 'D')
    	{
    		$customerName = 'Dealer';
    	}
    	else
    	{
    		$customerName = str_replace(" ","_", $customer->getName());
    	}
    	
    	//echo $customerName;exit;
        $custId = $customer->getCustomerId();

        $mount = array(
            'roots' => array(
                'library' => array(
                    'driver'        => 'LocalFileSystem',
                    'path'          => __DIR__ . '/../../../../../public/assets/library/customers/accounts/' . $customerName,
                    'tmbPath'       => 'thumbnails',
                    'accessControl' => 'access',
                    'mimeDetect'    => 'internal',
                    'imgLib'        => 'gd',
                	'disabled'		=>array('rename', 'rm'),
                ),
            ),
        );
        $elFinder = new ElFinder($mount, $this->assetService);

        $args = array();

        if (!$elFinder->loaded()) {
            $this->output(array(
                'error' => $elFinder->error(ElFinder::ERROR_CONF, ElFinder::ERROR_CONF_NO_VOL),
                'debug' => $elFinder->mountErrors,
            ));
        }

        if ($cmd === null && $post == true) {
            $this->output(array(
                'error'  => $elFinder->error(ElFinder::ERROR_UPLOAD, ElFinder::ERROR_UPLOAD_TOTAL_SIZE),
                'header' => 'Content-Type: text/html',
            ));
        }

        if (!$elFinder->commandExists($cmd)) {
            $this->output(array('error' => $elFinder->error(ElFinder::ERROR_UNKNOWN_CMD)));
        }

        foreach ($elFinder->commandArgsList($cmd) as $name => $req) {
            $arg = ($name == 'FILES' ? $_FILES : (isset($request[$name]) ? $request[$name] : ''));

            if (!is_array($arg)) {
                $arg = trim($arg);
            }

            if ($req && (!isset($arg) || $arg === '')) {
                $this->output(array('error' => $elFinder->error(ElFinder::ERROR_INV_PARAMS, $cmd)));
            }

            $args[$name] = $arg;
        }

        $args['debug'] = (isset($request['debug']) ? !!$request['debug'] : false);

        $this->output($elFinder->exec($cmd, $args));
    }

    protected function output(array $data)
    {
        $header = (isset($data['header']) ? $data['header'] : $this->header);

         unset($data['header']);

        if ($header) {
            if (is_array($header)) {
                foreach ($header as $h) {
                    header($h);
                }
            } else {
                header($header);
            }
        }

        if (isset($data['pointer'])) {
            rewind($data['pointer']);
            fpassthru($data['pointer']);
            if (!empty($data['volume'])) {
                $data['volume']->close($data['pointer'], $data['info']['hash']);
            }
            exit();
        } else {
            if (!empty($data['raw']) && !empty($data['error'])) {
                exit($data['error']);
            } else {
                exit(json_encode($data));
            }
        }
    }
}
