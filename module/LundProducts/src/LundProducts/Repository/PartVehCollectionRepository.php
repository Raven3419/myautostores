<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
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

use LundProducts\Entity\PartVehCollectionInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Changesets Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PartVehCollectionRepository implements PartVehCollectionRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $partVehCollectionRepository;

    /**
     * @param ObjectRepository $partVehCollectionRepository
     */
    public function __construct(
        ObjectManager    $objectManager,
        ObjectRepository $partVehCollectionRepository)
    {
        $this->objectManager           = $objectManager;
        $this->partVehCollectionRepository = $partVehCollectionRepository;
    }

    public function findByVehArray($vehCollections = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        
        $query->select(array('r'))
            ->from('LundProducts\Entity\PartVehCollection', 'r');

        $iterator = 0;

        foreach ($vehCollections as $vehCollection) {
            if ($iterator == 0) {
                $query->where('r.vehCollection = ' . $vehCollection);
            } else {
                $query->orWhere('r.vehCollection = ' . $vehCollection);
            }

            $iterator++;
        }

        return $query->getQuery()
            ->getResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                      $id
     * @return ChangesetsInterface|null
     */
    public function find($id)
    {
        return $this->partVehCollectionRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ChangesetsInterface[]
     */
    public function findAll()
    {
        return $this->partVehCollectionRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                 $criteria
     * @param  array|null            $orderBy
     * @param  int|null              $limit
     * @param  int|null              $offset
     * @return ChangesetsInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->partVehCollectionRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                    $criteria
     * @return ChangesetsInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->partVehCollectionRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->partVehCollectionRepository->getClassName();
    }
}
