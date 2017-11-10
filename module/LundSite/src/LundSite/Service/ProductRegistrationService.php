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
use LundSite\Entity\ProductRegistration;
use LundSite\Entity\ProductRegistrationInterface;
use LundSite\Repository\ProductRegistrationRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\ProductRegistrationForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of productRegistrations.
 */
class ProductRegistrationService implements EventManagerAwareInterface
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
     * @var ProductRegistrationRepositoryInterface
     */
    protected $productRegistrationRepository;

    /**
     * @var ProductRegistrationForm
     */
    protected $productRegistrationForm;

    /**
     * @var ProductRegistrationInterface
     */
    protected $productRegistrationPrototype;

    /**
     * @param ObjectManager                          $objectManager
     * @param UserRepositoryInterface                $userRepository
     * @param SiteRepositoryInterface                $siteRepository
     * @param ProductRegistrationRepositoryInterface $productRegistrationRepository
     * @param FormInterface                          $productRegistrationForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        ProductRegistrationRepositoryInterface $productRegistrationRepository,
        FormInterface $productRegistrationForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->productRegistrationRepository = $productRegistrationRepository;
        $this->productRegistrationForm       = $productRegistrationForm;
    }

    /**
     * Return a list of active productRegistrations
     *
     * @return ProductRegistrationInterface
     */
    public function getActiveProductRegistrations()
    {
        return $this->productRegistrationRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            ),
            array(
                'createdAt'   => 'ASC',
            )
        );
    }

    /**
     * Return a list of active productRegistrations by site
     *
     * @param  SiteInterface                $site
     * @return ProductRegistrationInterface
     */
    public function getActiveProductRegistrationsBySite(SiteInterface $site)
    {
        return $this->productRegistrationRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            ),
            array(
                'createdAt'   => 'ASC',
            )
        );
    }

    /**
     * Return create productRegistration form
     *
     * @return ProductRegistrationForm
     */
    public function getCreateProductRegistrationForm()
    {
        $this->productRegistrationForm->bind(clone $this->getProductRegistrationPrototype());

        return $this->productRegistrationForm;
    }

    /**
     * Return edit productRegistration form
     *
     * @param  string                  $productRegistrationId
     * @return ProductRegistrationForm
     */
    public function getEditProductRegistrationForm($productRegistrationId)
    {
        $productRegistration = $this->productRegistrationRepository->find($productRegistrationId);

        $this->productRegistrationForm->bind($productRegistration);

        return $this->productRegistrationForm;
    }

    /**
     * Return productRegistration entity
     *
     * @param  string                       $productRegistrationId
     * @return ProductRegistrationInterface
     */
    public function getProductRegistration($productRegistrationId)
    {
        $productRegistration = $this->productRegistrationRepository->find($productRegistrationId);

        return $productRegistration;
    }

    /**
     * Creates a new productRegistration.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ProductRegistrationInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->productRegistrationForm->bind(clone $this->getProductRegistrationPrototype());
        $this->productRegistrationForm->setData($data);
        
        //print_r($this->productRegistrationForm->getData());exit;
        
    	$form = $this->getCreateProductForm();
    	
//    	if ($this->request->isPost()) {
    		
//    	}
    	//$form->setData($data);
        
        //print_r($data);
        
        if (!$form->isValid()) {
        	echo "bad  - ";
            return null;
        }
		

        $productRegistration = $this->productRegistrationForm->getData();


        if (!$productRegistration instanceof ProductRegistrationInterface) {
            throw Exception\UnexpectedValueException::invalidProductRegistrationEntity($productRegistration);
        }

        $productRegistration->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDisabled(false);

        $this->objectManager->persist($productRegistration);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductRegistrationEvent('productRegistrationCreated', $productRegistration));

        return $productRegistration;
        
    }

    /**
     * Edit an existing productRegistration.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  ProductRegistrationInterface       $productRegistration
     * @throws Exception\UnexpectedValueException
     * @return null|ProductRegistrationInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, ProductRegistrationInterface $productRegistration)
    {
        $this->productRegistrationForm->bind(clone $this->getProductRegistrationPrototype());
        $this->productRegistrationForm->setData($data);

        if (!$this->productRegistrationForm->isValid()) {
            return null;
        }

        $productRegistration = $this->productRegistrationForm->getData();

        if (!$productRegistration instanceof ProductRegistrationInterface) {
            throw Exception\UnexpectedValueException::invalidProductRegistrationEntity($productRegistration);
        }

        $productRegistration->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductRegistrationEvent('productRegistrationEdited', $productRegistration));

        return $productRegistration;
    }

    /**
     * Delete an existing productRegistration.
     *
     * @param  UserInterface                      $identity
     * @param  ProductRegistrationInterface       $productRegistration
     * @throws Exception\UnexpectedValueException
     * @return null|ProductRegistrationInterface
     */
    public function delete(UserInterface $identity, ProductRegistrationInterface $productRegistration)
    {
        if (!$productRegistration instanceof ProductRegistrationInterface) {
            throw Exception\UnexpectedValueException::invalidProductRegistrationEntity($productRegistration);
        }

        $productRegistration->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductRegistrationEvent('productRegistrationDeleted', $productRegistration));

        return $productRegistration;
    }

    /**
     * @return ProductRegistrationInterface
     */
    public function getProductRegistrationPrototype()
    {
        if ($this->productRegistrationPrototype === null) {
            $this->setProductRegistrationPrototype(new ProductRegistration());
        }

        return $this->productRegistrationPrototype;
    }

    /**
     * @param  ProductRegistrationInterface $productRegistrationPrototype
     * @return ProductRegistrationService
     */
    public function setProductRegistrationPrototype(ProductRegistrationInterface $productRegistrationPrototype)
    {
        $this->productRegistrationPrototype = $productRegistrationPrototype;

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

    /**
     * Return create ProductForm
     *
     * @return ProductForm
     */
    public function getCreateProductForm()
    {
    	$this->productRegistrationForm->bind(clone $this->getProductRegistrationPrototype());

        return $this->productRegistrationForm;
    }
}
