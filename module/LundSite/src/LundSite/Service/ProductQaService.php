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
use LundSite\Entity\ProductQa;
use LundSite\Entity\ProductQaInterface;
use LundSite\Repository\ProductQaRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\ProductQaForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of productQa.
 */
class ProductQaService implements EventManagerAwareInterface
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
     * @var ProductQaRepositoryInterface
     */
    protected $productQaRepository;

    /**
     * @var ProductQaForm
     */
    protected $productQaForm;

    /**
     * @var ProductQaInterface
     */
    protected $productQaPrototype;

    /**
     * @param ObjectManager                  $objectManager
     * @param UserRepositoryInterface        $userRepository
     * @param SiteRepositoryInterface        $siteRepository
     * @param ProductQaRepositoryInterface 	 $productQaRepository
     * @param FormInterface                  $productQaForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        ProductQaRepositoryInterface $productQaRepository,
        FormInterface $productQaForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->productQaRepository = $productQaRepository;
        $this->productQaForm       = $productQaForm;
    }

    /**
     * Return a list of active productQa
     *
     * @return ProductQaInterface
     */
    public function getActiveProductQa()
    {
        return $this->productQaRepository->findBy(
            array(
                'deleted'  => false,
            )
        );
    }

    /**
     * Return a list of active productQa
     *
     * @return ProductQaInterface
     */
    public function getProductQaByProduct($id = null)
    {
        return $this->productQaRepository->findBy(
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
     * Return a list of active productQa
     *
     * @return ProductQaInterface
     */
    public function getProductQaByCustomer($id = null)
    {
        return $this->productQaRepository->findBy(
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
     * Return create productQa form
     *
     * @return ProductQaForm
     */
    public function getCreateProductQaForm()
    {
        $this->productQaForm->bind(clone $this->getProductQaPrototype());

        return $this->productQaForm;
    }

    /**
     * Return edit ProductQa form
     *
     * @param  string          $productQaId
     * @return ProductQaForm
     */
    public function getEditProductQaForm($productQaId)
    {
        $productQa = $this->productQaRepository->find($productQaId);

        $this->productQaForm->bind($productQa);

        return $this->productQaForm;
    }

    /**
     * Return productQa entity
     *
     * @param  string               $productQaId
     * @return ProductQaInterface
     */
    public function getProductQa($productQaId)
    {
        $productQa = $this->productQaRepository->find($productQaId);

        return $productQa;
    }

    /**
     * Creates a new productQa.
     *
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ProductQaInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->productQaForm->bind(clone $this->getproductQaPrototype());
        $this->productQaForm->setData($data);

        if (!$this->productQaForm->isValid()) {

        	//print_r($this->productQaForm->getMessages()); //error messages
        	//exit;
            return null;
        }

        $productQa = $this->productQaForm->getData();

        if (!$productQa instanceof ProductQaInterface) {
            throw Exception\UnexpectedValueException::invalidProductQaEntity($productQa);
        }

        $productQa->setCreatedAt(new DateTime('now'))
            	  ->setCreatedBy($identity->getUsername())
            	  ->setDeleted(false);;

        $this->objectManager->persist($productQa);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductQaEvent('productQaCreated', $productQa));

        return $productQa;
    }

    /**
     * Edit an existing productQa.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  ProductQaInterface               		  $productQa
     * @throws Exception\UnexpectedValueException
     * @return null|ProductQaInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, ProductQaInterface $productQa)
    {
        $this->productQaForm->bind(clone $this->getProductQaPrototype());
        $this->productQaForm->setData($data);

        if (!$this->productQaForm->isValid()) {
            return null;
        }

        $productQa = $this->productQaForm->getData();

        if (!$productQa instanceof ProductQaInterface) {
            throw Exception\UnexpectedValueException::invalidProductQaEntity($productQa);
        }

        $productQa->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductQaEvent('productQaEdited', $productQa));

        return $productQa;
    }

    /**
     * Delete an existing productQa.
     *
     * @param  UserInterface                      $identity
     * @param  ProductQaInterface               		  $productQa
     * @throws Exception\UnexpectedValueException
     * @return null|ProductQaInterface
     */
    public function delete(UserInterface $identity, ProductQaInterface $productQa)
    {
        if (!$productQa instanceof ProductQaInterface) {
            throw Exception\UnexpectedValueException::invalidProductQaEntity($productQa);
        }

        $productQa->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername())
            	  ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ProductQaEvent('productQaDeleted', $productQa));

        return $productQa;
    }

    /**
     * @return ProductQaInterface
     */
    public function getProductQaPrototype()
    {
        if ($this->productQaPrototype === null) {
            $this->setProductQaPrototype(new ProductQa());
        }

        return $this->productQaPrototype;
    }

    /**
     * @param  ProductQaInterface $productQaPrototype
     * @return ProductQaService
     */
    public function setProductQaPrototype(ProductQaInterface $productQaPrototype)
    {
        $this->productQaPrototype = $productQaPrototype;

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
