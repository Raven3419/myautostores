<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use RocketUser\Entity\UserInterface;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\CustomerReview;
use LundSite\Entity\CustomerReviewInterface;
use LundSite\Repository\CustomerReviewRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\CustomerReviewForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of CustomerReview.
 */
class CustomerReviewService implements EventManagerAwareInterface
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
     * @var SiteRepositoryInterface
     */
    protected $siteRepository;

    /**
     * @var CustomerReviewRepositoryInterface
     */
    protected $customerReviewRepository;

    /**
     * @var CustomerReviewForm
     */
    protected $customerReviewForm;

    /**
     * @var CustomerReviewInterface
     */
    protected $customerReviewPrototype;

    /**
     * @param ObjectManager                  		$objectManager
     * @param UserRepositoryInterface        		$userRepository
     * @param SiteRepositoryInterface        		$siteRepository
     * @param CustomerReviewRepositoryInterface 	$customerReviewRepository
     * @param FormInterface                  		$customerReviewForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        CustomerReviewRepositoryInterface $customerReviewRepository,
        FormInterface $customerReviewForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->customerReviewRepository = $customerReviewRepository;
        $this->customerReviewForm       = $customerReviewForm;
    }

    /**
     * Return a list of active CustomerReview
     *
     * @return CustomerReviewInterface
     */
    public function getActiveCustomerReview()
    {
        return $this->customerReviewRepository->findBy(
            array(
                'deleted'  => false,
            )
        );
    }

    /**
     * Return a list of active CustomerReview
     *
     * @return CustomerReviewInterface
     */
    public function getCustomerReviewByProduct($id = null)
    {
        return $this->customerReviewRepository->findBy(
            array(
                'productLine'  => $id,
                'status'  => '0',
            ),
            array(
                'createdAt' => 'ASC',
            )
        );
    }
    
    
    /**
     * Return a list of active CustomerReview
     *
     * @return CustomerReviewInterface
     */
    public function getCustomerReviewByCustomer($id = null)
    {
        return $this->customerReviewRepository->findBy(
            array(
                'ecomCustomer'  => $id,
                'status'  => '0',
            ),
            array(
                'createdAt' => 'ASC',
            )
            );
    }

    /**
     * Return create CustomerReview form
     *
     * @return CustomerReviewForm
     */
    public function getCreateCustomerReviewForm()
    {
        $this->customerReviewForm->bind(clone $this->getCustomerReviewPrototype());

        return $this->customerReviewForm;
    }

    /**
     * Return edit CustomerReview form
     *
     * @param  string          $customerReviewId
     * @return CustomerReviewForm
     */
    public function getEditCustomerReviewForm($customerReviewId)
    {
        $customerReview = $this->customerReviewRepository->find($customerReviewId);

        $this->customerReviewForm->bind($customerReview);

        return $this->customerReviewForm;
    }

    /**
     * Return CustomerReview entity
     *
     * @param  string               $customerReviewId
     * @return CustomerReviewInterface
     */
    public function getCustomerReview($customerReviewId)
    {
        $customerReview = $this->customerReviewRepository->find($customerReviewId);

        return $customerReview;
    }

    /**
     * Creates a new CustomerReview.
     *
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerReviewInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->customerReviewForm->bind(clone $this->getCustomerReviewPrototype());
        $this->customerReviewForm->setData($data);

        if (!$this->customerReviewForm->isValid()) {

        	//print_r($this->customerReviewForm->getMessages()); //error messages
        	//exit;
            return null;
        }

        $customerReview = $this->customerReviewForm->getData();

        if (!$customerReview instanceof CustomerReviewInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerReviewEntity($customerReview);
        }

        $customerReview->setCreatedAt(new DateTime('now'))
            	  		->setCreatedBy($identity->getUsername())
            	  		->setDeleted(false);;

        $this->objectManager->persist($customerReview);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerReviewEvent('customerReviewCreated', $customerReview));

        return $customerReview;
    }

    /**
     * Edit an existing CustomerReview.
     *
     * @param  UserInterface                      	$identity
     * @param  \Zend\Stdlib\Parameters            	$data
     * @param  CustomerReviewInterface          	$customerReview
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerReviewInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, CustomerReviewInterface $customerReview)
    {
        $this->customerReviewForm->bind(clone $this->getCustomerReviewPrototype());
        $this->customerReviewForm->setData($data);

        if (!$this->customerReviewForm->isValid()) {
            return null;
        }

        $customerReview = $this->customerReviewForm->getData();

        if (!$customerReview instanceof CustomerReviewInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerReviewEntity($customerReview);
        }
        
        $value = $customerReview->getValue();
        $price = $customerReview->getPrice();
        $quality = $customerReview->getQuality();
        

        $customerReview->setModifiedAt(new DateTime('now'))
            	  	   ->setModifiedBy($identity->getUsername())
        			   ->setTotal(($value + $price + $quality)/3);

        
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerReviewEvent('customerReviewEdited', $customerReview));

        return $customerReview;
    }

    /**
     * Delete an existing CustomerReview.
     *
     * @param  UserInterface                      		$identity
     * @param  CustomerReviewInterface             		$CustomerReview
     * @throws Exception\UnexpectedValueException
     * @return null|CustomerReviewInterface
     */
    public function delete(UserInterface $identity, CustomerReviewInterface $customerReview)
    {
        if (!$customerReview instanceof CustomerReviewInterface) {
            throw Exception\UnexpectedValueException::invalidCustomerReviewEntity($customerReview);
        }

        $customerReview->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername())
            	  ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new CustomerReviewEvent('customerReviewDeleted', $customerReview));

        return $customerReview;
    }

    /**
     * @return CustomerReviewInterface
     */
    public function getCustomerReviewPrototype()
    {
        if ($this->customerReviewPrototype === null) {
            $this->setCustomerReviewPrototype(new CustomerReview());
        }

        return $this->customerReviewPrototype;
    }

    /**
     * @param  CustomerReviewInterface $customerReviewPrototype
     * @return CustomerReviewService
     */
    public function setCustomerReviewPrototype(CustomerReviewInterface $customerReviewPrototype)
    {
        $this->customerReviewPrototype = $customerReviewPrototype;

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
