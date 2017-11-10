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

use LundProducts\Repository\VehCollectionRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * VehCollection Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class VehCollectionRepository implements VehCollectionRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $vehCollectionRepository;

    /**
     * @param ObjectManager    $objectManager
     * @param ObjectRepository $vehCollectionRepository
     */
    public function __construct(
        ObjectManager    $objectManager,
        ObjectRepository $vehCollectionRepository)
    {
        $this->objectManager           = $objectManager;
        $this->vehCollectionRepository = $vehCollectionRepository;
    }

    /**
     * Return all active records
     *
     * @return mixed
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
                     ->useResultCache(true, 7200, 'vehcollection_find_active')
                     ->getResult();
    }

    /*
     * returns the query definition minus the where clause, for use in both findActive() and getTotalRows()
     * @return mixed
     */
    public function buildQuery($query)
    {
        $query->select(array('r', 'vmake', 'vmod', 'vsubmod', 'vy'))
              ->from('LundProducts\Entity\VehCollection', 'r')
              ->leftJoin('r.vehMake', 'vmake')
              ->leftJoin('r.vehModel', 'vmod')
              ->leftJoin('r.vehSubmodel', 'vsubmod')
              ->leftJoin('r.vehYear', 'vy');

        return $query;
    }

    /*
     * returns the where clause for both getTotalRows() and findActive()
     * @return mixed
     */
    public function buildWhere($query = null, $sSearch = null)
    {
        $query->where(
            $query->expr()->orX(
                $query->expr()->like('vmake.name', '?1'),
                $query->expr()->like('vmod.name', '?1'),
                $query->expr()->like('vsubmod.name', '?1'),
                $query->expr()->like('vy.name', '?1')
            )
        )->setParameter(1, '%' . $sSearch . '%');

        return $query;
    }

    public function findByYear($year)
    {
        $query = $this->objectManager->createQueryBuilder('r');

        $query->select(array('r', 'vyear'))
            ->from('LundProducts\Entity\VehCollection', 'r')
            ->leftJoin('r.vehYear', 'vyear');
        $query->where('vyear.name = :yearname')
            ->setParameter('yearname',$year);

 //       echo $query->getQuery()->getSql();exit;
        return $query->getQuery()
            ->getResult();
    }

    public function findByYearMake($year, $make)
    {
        $query = $this->objectManager->createQueryBuilder('r');

        $query->select(array('r', 'vyear', 'vmake'))
            ->from('LundProducts\Entity\VehCollection', 'r')
            ->leftJoin('r.vehYear', 'vyear')
            ->leftJoin('r.vehMake', 'vmake');
        $query->where('vyear.name = :yearname')
            ->andWhere('vmake.name = :makename')
            ->setParameters(array('yearname' => $year, 'makename' => $make));

        return $query->getQuery()
            ->getResult();
    }

    public function findByYearMakeModel($year, $make, $model)
    {
        $query = $this->objectManager->createQueryBuilder('r');

        $query->select(array('r', 'vyear', 'vmake', 'vmodel'))
            ->from('LundProducts\Entity\VehCollection', 'r')
            ->leftJoin('r.vehYear', 'vyear')
            ->leftJoin('r.vehMake', 'vmake')
            ->leftJoin('r.vehModel', 'vmodel');
        $query->where('vyear.name = :yearname')
            ->andWhere('vmake.name = :makename')
            ->andWhere('vmodel.name = :modelname')
            ->setParameters(array('yearname' => $year, 'makename' => $make, 'modelname' => $model));

        return $query->getQuery()
            ->getResult();
    }

    public function findBySelector($year, $make, $model, $submodel = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');

        $query->select(array('r', 'vyear', 'vmake', 'vmodel', 'vsubmodel'))
            ->from('LundProducts\Entity\VehCollection', 'r')
            ->leftJoin('r.vehYear', 'vyear')
            ->leftJoin('r.vehMake', 'vmake')
            ->leftJoin('r.vehModel', 'vmodel')
            ->leftJoin('r.vehSubmodel', 'vsubmodel');
        $query->where('vyear.name = :yearname')
            ->andWhere('vmake.name = :makename')
            ->andWhere('vmodel.name = :modelname');

        $parameters = array(
            'yearname'  => $year,
            'makename'  => $make,
            'modelname' => $model);

        if (null != $submodel) {
            $query->andWhere('vsubmodel.name = :submodelname');
            $parameters['submodelname'] = $submodel;
        //} else {
        //    $query->andWhere('r.vehSubmodel IS NULL');
        }

        $query->setParameters($parameters);

        //echo $year." - ".$make." - ".$model." - ".$submodel." - ";
        //echo $query->getQuery()->getSql();exit;
        return $query->getQuery()
            ->getResult();
    }

    public function findMake($make)
    {
        $query = $this->objectManager->createQueryBuilder('r');

        $query->select(array('r'))
            ->from('LundProducts\Entity\VehMake', 'r');
        $query->where('r.name = :makename')
            ->setParameter('makename',$make);

 //       echo $query->getQuery()->getSql();exit;
        return $query->getQuery()
            ->getResult();
    }

    public function findModel($model, $make)
    {
        $query = $this->objectManager->createQueryBuilder('r');

        $query->select(array('r'))
            ->from('LundProducts\Entity\VehModel', 'r');
        $query->where('r.name = :modelname')
              ->andWhere('r.vehMakeId = :makeID');
        
        $parameters = array(
            'modelname'  => $model,
            'makeID'  => $make[0]->getVehMakeId());
              
        $query->setParameters($parameters);

        echo $query->getQuery()->getSql();exit;
        return $query->getQuery()
            ->getResult();
    }

    public function findSubModel($submodel, $model)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        
        $query->select(array('r'))
        ->from('LundProducts\Entity\VehSubModel', 'r');
        $query->where('r.name = :submodelname')
        ->setParameter('submodelname',$submodel);
        
        //echo $query->getQuery()->getSql();
        //echo "hi";
        return $query->getQuery()
            ->getResult();
    }
    

    /**
     * return total rows in veh_collection table, for datatables JSON pagination primarily
     *
     * @return mixed
     */
    public function getTotalRows($sSearch = null)
    {
        $query = $this->objectManager->createQueryBuilder();
        $query = $this->buildQuery($query);
        $query->add('select', 'COUNT(r.vehCollectionId)');

        if (null != $sSearch) {
            $query = $this->buildWhere($query, $sSearch);
        }

        return $query->getQuery()
                     ->useResultCache(true, 7200, 'vehcollection_get_total_rows')
                     ->getSingleScalarResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                         $id
     * @return VehCollectionInterface|null
     */
    public function find($id)
    {
        return $this->vehCollectionRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return VehCollectionInterface[]
     */
    public function findAll()
    {
        return $this->vehCollectionRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                    $criteria
     * @param  array|null               $orderBy
     * @param  int|null                 $limit
     * @param  int|null                 $offset
     * @return VehCollectionInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->vehCollectionRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                       $criteria
     * @return VehCollectionInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->vehCollectionRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->vehCollectionRepository->getClassName();
    }

}
