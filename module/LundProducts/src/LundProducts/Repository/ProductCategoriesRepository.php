<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Repository;

use LundProducts\Repository\ProductCategoriesRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Product Categories Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductCategoriesRepository implements ProductCategoriesRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $productCategoriesRepository;

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $productCategoriesRepository
     */
    public function __construct(
        ObjectManager    $objectManager,
        ObjectRepository $productCategoriesRepository)
    {
        $this->objectManager               = $objectManager;
        $this->productCategoriesRepository = $productCategoriesRepository;
    }

    /**
     * Return all active records
     *
     * @return ProductCategories
     */
    public function findActive()
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query->select('r')
            ->from('LundProducts\Entity\ProductCategories', 'r')
            ->where('r.deleted = false')
            ->orderBy('r.name', 'ASC');

        return $query->getQuery()
            ->useResultCache(true, 7200, 'productcategories_find_active')
            ->getResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                             $id
     * @return ProductCategoriesInterface|null
     */
    public function find($id)
    {
        return $this->productCategoriesRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ProductCategoriesInterface[]
     */
    public function findAll()
    {
        return $this->productCategoriesRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                        $criteria
     * @param  array|null                   $orderBy
     * @param  int|null                     $limit
     * @param  int|null                     $offset
     * @return ProductCategoriesInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productCategoriesRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                           $criteria
     * @return ProductCategoriesInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->productCategoriesRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->productCategoriesRepository->getClassName();
    }
}
