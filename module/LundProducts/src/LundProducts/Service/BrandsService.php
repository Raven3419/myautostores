<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use Zend\EventManager\Eventmanager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\Brands;
use LundProducts\Repository\BrandsRepositoryInterface;
use LundProducts\Form\BrandForm;
use LundProducts\Entity\BrandsInterface;
use RocketUser\Entity\User;
use DateTime;

/*
 * Service managing the CRUD of brands.
 */
class BrandsService implements EventManagerAwareInterface
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
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var BrandsForm
     */
    protected $brandsForm;

    /**
     * @var BrandsInterface
     */
    protected $brandsPrototype;

    /**
     * @param ObjectManager             $objectManager
     * @param BrandsRepositoryInterface $repository
     * @param FormInterface             $brandsForm
     */
    public function __construct(
        ObjectManager             $objectManager,
        BrandsRepositoryInterface $repository,
        FormInterface             $brandsForm
    )
    {
        $this->objectManager = $objectManager;
        $this->repository    = $repository;
        $this->brandsForm    = $brandsForm;
    }

    /**
     * @return mixed
     */
    public function getActiveBrands()
    {
        return $this->repository->findBy(
            array('deleted'  => false,
                  'disabled' => false),
            array('createdAt' => 'ASC')
        );
    }

    /**
     * @return mixed
     */
    public function getCurrentBrands()
    {
        return $this->repository->findBy(
            array('deleted' => false),
            array('createdAt' => 'ASC')
        );
    }

    /**
     * Return brand record
     *
     * @param  string          $name
     * @return BrandsInterface
     */
    public function getBrandByName($name = null)
    {
        return $this->repository->findOneBy(
            array('name' => $name)
        );
    }

    /**
     * Return create BrandForm
     *
     * @return BrandForm
     */
    public function getCreateBrandForm()
    {
        $this->brandsForm->bind(clone $this->getBrandsPrototype());

        return $this->brandsForm;
    }

    /**
     * Return edit BrandForm
     *
     * @param  string    $brandId
     * @return BrandForm
     */
    public function getEditBrandForm($brandId)
    {
        $brand = $this->repository->find($brandId);

        $this->brandsForm->bind($brand);

        return $this->brandsForm;
    }

    /**
     * @return BrandsInterface
     */
    public function getBrandsPrototype()
    {
        if ($this->brandsPrototype === null) {
            $this->setBrandsPrototype(new Brands());
        }

        return $this->brandsPrototype;
    }

    /**
     * @param  BrandsInterface $brandsPrototype
     * @return BrandsService
     */
    public function setBrandsPrototype(BrandsInterface $brandsPrototype)
    {
        $this->brandsPrototype = $brandsPrototype;

        return $this;
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getBrand($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @param \Admin\Entity\Brands $recordEntity
     * @param \Admin\Entity\User   $usersEntity
     *
     * @return \Admin\Entity\Brands $recordEntity
     */
    public function createBrand(Brands $recordEntity, User $usersEntity)
    {
        $recordEntity->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($usersEntity->getUsername())
            ->setDeleted(false)
            ->setDisabled(false);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        //$this->flushCache();
        return $recordEntity;
    }

    /**
     * @param \Admin\Entity\Brands $recordEntity
     * @param \Admin\Entity\User   $usersEntity
     *
     * @return \Admin\Entity\Brands $recordEntity
     */
    public function editBrand(Brands $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername());
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        //$this->flushCache();
        return $recordEntity;
    }

    /**
     * @param \Admin\Entity\Brands $recordEntity
     * @param \Admin\Entity\User   $usersEntity
     *
     * @return \Admin\Entity\Brands $recordEntity
     */
    public function deleteBrand(Brands $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername())
            ->setDeleted(true)
            ->setDisabled(true);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        //$this->flushCache();
        return $recordEntity;
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
