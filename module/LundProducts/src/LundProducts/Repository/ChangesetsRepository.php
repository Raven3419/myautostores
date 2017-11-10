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

use LundProducts\Entity\ChangesetsInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

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
class ChangesetsRepository implements ChangesetsRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $changesetsRepository;

    /**
     * @param ObjectRepository $changesetsRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $changesetsRepository)
    {
        $this->objectManager        = $objectManager;
        $this->changesetsRepository = $changesetsRepository;
    }

    /**
     * findByFrequency(): Custom repository method
     *
     * @param  DateTime                 $startDate
     * @param  DateTime                 $endDate
     * @return ChangesetsInterface|null
     */
    public function findByFrequency(DateTime $startDate, DateTime $endDate)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query->select(array('r'))
            ->from('LundProducts\Entity\Changesets', 'r')
            ->where('r.deleted = false')
            ->where('r.disabled = false')
            ->where('r.approved = true')
            ->where('r.deployed = true')
        	->setMaxResults(3);

        $query->where('r.createdAt BETWEEN :startdate AND :enddate')
            ->setParameter('startdate', $startDate->format('Y-m-d 00:00:00'))
            ->setParameter('enddate', $endDate->format('Y-m-d H:i:s'))
        	->addOrderBy('r.createdAt', 'DESC');

        //echo $startDate->format('Y-m-d 00:00:00'). " - ".$endDate->format('Y-m-d H:i:s');exit;
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
        return $this->changesetsRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ChangesetsInterface[]
     */
    public function findAll()
    {
        return $this->changesetsRepository->findAll();
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
        return $this->changesetsRepository->findBy($criteria, $orderBy, $limit, $offset);
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
        return $this->changesetsRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->changesetsRepository->getClassName();
    }
}
