<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Repository;

use LundCustomer\Repository\RetailerRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Retailer Repository
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class RetailerRepository implements RetailerRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $retailerRepository;

    /**
     * @param ObjectRepository $retailerRepository
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $retailerRepository)
    {
        $this->objectManager = $objectManager;
        $this->retailerRepository = $retailerRepository;
    }

    /**
     * Return all active records
     *
     * @return Parts
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
            ->getResult();
    }

    public function getZipRetailers($zipstring = null, $zips = null)
    {
        //echo $zipstring;exit;
        $query = $this->objectManager->createQueryBuilder('r');
        $query->select(array('r'))
            ->from('LundCustomer\Entity\Retailer', 'r')
            ->where('r.deleted = false')
            ->andWhere('r.disabled = false')
            //->andWhere('r.retailerType = "physical"')
            ->andWhere('r.postCode IN ('.$zipstring.')');

        //->where('r.deleted = false and r.postCode IN ('.$zipstring.')');
        $query->setMaxResults(50);

        return $query->getQuery()
            ->getResult();
    }

    /*
     * @return mixed
     */
    public function buildQuery($query)
    {
        $query->select(array('r'))
              ->from('LundCustomer\Entity\Retailer', 'r')
              ->where('r.deleted = false')
              ->where('r.disabled = false');

        return $query;
    }

    /*
     * @return mixed
     */
    public function buildWhere($query = null, $sSearch = null)
    {
        $query->where(
            $query->expr()->orX(
                $query->expr()->like('r.companyName', '?1'),
                $query->expr()->like('r.retailerType', '?1'),
                $query->expr()->like('r.streetAddress', '?1'),
                $query->expr()->like('r.extStreetAddress', '?1'),
                $query->expr()->like('r.locality', '?1'),
                $query->expr()->like('r.postCode', '?1'),
                $query->expr()->like('r.phoneNumber', '?1'),
                $query->expr()->like('r.website', '?1')
            )
        )->setParameter(1, '%' . $sSearch . '%');

        return $query;
    }

    /**
     * return total rows in retailer table, for datatables JSON pagination primarily
     *
     * @return mixed
     */
    public function getTotalRows($sSearch = null)
    {
        $query = $this->objectManager->createQueryBuilder();
        $query = $this->buildQuery($query);
        $query->add('select', 'COUNT(r.retailerId)');

        if (null != $sSearch) {
            $query = $this->buildWhere($query, $sSearch);
        }

        return $query->getQuery()
                     ->getSingleScalarResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                    $id
     * @return RetailerInterface|null
     */
    public function find($id)
    {
        return $this->retailerRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return RetailerInterface[]
     */
    public function findAll()
    {
        return $this->retailerRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array               $criteria
     * @param  array|null          $orderBy
     * @param  int|null            $limit
     * @param  int|null            $offset
     * @return RetailerInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->retailerRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                  $criteria
     * @return RetailerInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->retailerRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->retailerRepository->getClassName();
    }
}
