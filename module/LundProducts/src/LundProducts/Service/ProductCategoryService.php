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
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use Zend\EventManager\Eventmanager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\ProductCategories;
use LundProducts\Repository\ProductCategoriesRepositoryInterface;
use LundProducts\Form\ProductCategoryForm;
use LundProducts\Entity\ProductCategoriesInterface;
use RocketUser\Entity\User;
use DateTime;

class ProductCategoryService implements EventManagerAwareInterface
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

    /*
     * @var ProductCategoryForm
     */
    protected $productCategoryForm;

    /**
     * @var ProdcuctCategoriesInterface
     */
    protected $productCategoriesPrototype;

    /**
     * @param ObjectManager
     * @param ObjectRepository
     * @param ProductCategoryForm
     */
    public function __construct(ObjectManager                        $objectManager,
                                ProductCategoriesRepositoryInterface $repository,
                                ProductCategoryForm                  $productCategoryForm)
    {
        $this->objectManager       = $objectManager;
        $this->repository          = $repository;
        $this->productCategoryForm = $productCategoryForm;
    }

    /**
     * Return count of active product categories
     *
     * @return integer
     */
    public function getCount()
    {
        $dql = 'SELECT COUNT(p) FROM LundProducts\Entity\ProductCategories p WHERE p.deleted = :deleted';
        $q = $this->objectManager->createQuery($dql);
        $q->setParameters(array('deleted' => 0));

        return $q->getSingleScalarResult();
    }

    /**
     * Return product category by name
     *
     * @param  string                          $name
     * @return ProductCategoriesInterface|null
     */
    public function getProductCategoryByName($name = null)
    {
        return $this->repository->findOneBy(
            array(
                'deleted'  => false,
                'displayName'     => $name,
            )
        );
    }

    /**
     * Return view ProductCategoryForm
     *
     * @param  string              $productCategoryId
     * @return ProductCategoryForm
     */
    public function getViewProductCategoryForm($productCategoryId)
    {
        $productCategory = $this->repository->find($productCategoryId);

        $this->productCategoryForm->bind($productCategory);

        return $this->productCategoryForm;
    }

    /**
     * Return create ProductCategoryForm
     *
     * @return ProductCategoryForm
     */
    public function getCreateProductCategoryForm()
    {
        $this->productCategoryForm->bind(clone $this->getProductCategoriesPrototype());

        return $this->productCategoryForm;
    }

    /**
     * Return edit ProductCategoryForm
     *
     * @param  string              $productCategoryId
     * @return ProductCategoryForm
     */
    public function getEditProductCategoryForm($productCategoryId)
    {
        $productCategory = $this->repository->find($productCategoryId);

        $this->productCategoryForm->bind($productCategory);

        return $this->productCategoryForm;
    }

    /**
     * @return ProductCategoriesInterface
     */
    public function getProductCategoriesPrototype()
    {
        if ($this->productCategoriesPrototype === null) {
            $this->setProductCategoriesPrototype(new ProductCategories());
        }

        return $this->productCategoriesPrototype;
    }

    /**
     * @param  ProductCategoriesInterface $productLinesPrototype
     * @return ProductCategoryService
     */
    public function setProductCategoriesPrototype(ProductCategoriesInterface $productCategoriesPrototype)
    {
        $this->productCategoriesPrototype = $productCategoriesPrototype;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActiveProductCategories()
    {
        return $this->repository->findActive();
    }

    /**
     * @return mixed
     */
    public function getActiveLiveProductCategories()
    {
        return $this->repository->findBy(
            array(
                'deleted' => false,
            ),
            array(
                'name' => 'ASC',
            )
        );
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getProductCategory($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @param \LundProducts\Entity\ProductCategories $recordEntity
     * @param \RocketUser\Entity\User                $usersEntity
     *
     * @return \LundProducts\Entity\ProductCategories $recordEntity
     */
    public function createProductCategory(ProductCategories $recordEntity, User $usersEntity)
    {
        $recordEntity->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($usersEntity->getUsername())
            ->setDeleted(false)
            ->setDisabled(false);

        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductCategories $recordEntity
     * @param \RocketUser\Entity\User                $usersEntity
     *
     * @return \LundProducts\Entity\ProductCategories $recordEntity
     */
    public function editProductCategory(ProductCategories $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername());

        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\ProductCategories $recordEntity
     * @param \RocketUser\Entity\User                $usersEntity
     *
     * @return \LundProducts\Entity\ProductCategories $recordEntity
     */
    public function deleteProductCategory(ProductCategories $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($usersEntity->getUsername())
            ->setDeleted(true)
            ->setDisabled(true);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @return void
     */
    public function flushCache()
    {
        $cacheDriver = $this->objectManager->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('productcategories_find_active');
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
