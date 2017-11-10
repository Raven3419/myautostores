<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/com for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Repository;

use LundProducts\Repository\ProductReviewsRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Product Reviews Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductReviewsRepository implements ProductReviewsRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $productReviewsRepository;

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $productReviewsRepository
     */
    public function __construct(
        ObjectManager    $objectManager,
        ObjectRepository $productReviewsRepository)
    {
        $this->objectManager            = $objectManager;
        $this->productReviewsRepository = $productReviewsRepository;
    }

    /**
     * Return all active records
     *
     * @return Product Reviews
     */
    public function findActive($limit = null, $offset = null, $orderBy = array(), $sSearch = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query = $this->buildQuery($query);

        if (((INT)$limit >= 0) && ((INT)$offset >= 0)) {
            $query->setFirstResult($offset)
                  ->setMaxResults($limit);
        }

        if ($sSearch != null) {
            $query = $this->buildWhere($query, $sSearch);
        }

        if ($orderBy) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->getQuery()
            ->useResultCache(true, 7200, 'productreviews_find_active')
            ->getResult();;
    }

    /*
     * @return mixed
     */
    public function buildQuery($query)
    {
        $query->select(array('r', 'pl'))
              ->from('LundProducts\Entity\ProductReviews', 'r')
              ->where('r.deleted = false')
              ->leftJoin('r.productLines', 'pl');

        return $query;
    }

    /*
     * @return mixed
     */
    public function buildWhere($query = null, $sSearch = null)
    {
        $query->where(
            $query->expr()->orX(
                $query->expr()->like('r.rating', '?1'),
                $query->expr()->like('r.review', '?1'),
                $query->expr()->like('pl.name', '?1')
            )
        )->setParameter(1, '%' . $sSearch . '%');

        return $query;
    }

    /**
     * return total rows in product reviews table, for datatables JSON pagination primarily
     *
     * @return mixed
     */
    public function getTotalRows($sSearch = null)
    {
        $query = $this->objectManager->createQueryBuilder();
        $query = $this->buildQuery($query);
        $query->add('select', 'COUNT(r.productReviewId)');

        if (null != $sSearch) {
            $query = $this->buildWhere($query, $sSearch);
        }

        return $query->getQuery()
                     ->useResultCache(true, 7200, 'productreviews_get_total_rows')
                     ->getSingleScalarResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                          $id
     * @return ProductReviewsInterface|null
     */
    public function find($id)
    {
        return $this->productReviewsRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ProductReviewsInterface[]
     */
    public function findAll()
    {
        return $this->productReviewsRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                     $criteria
     * @param  array|null                $orderBy
     * @param  int|null                  $limit
     * @param  int|null                  $offset
     * @return ProductReviewsInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productReviewsRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                        $criteria
     * @return ProductReviewsInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->productReviewsRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->productReviewsRepository->getClassName();
    }
}
