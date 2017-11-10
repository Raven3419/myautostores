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

use LundProducts\Entity\ChangesetDetailsInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use LundProducts\Repository\ChangesetDetailsRepositoryInterface;

/**
 * Changeset Details Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ChangesetDetailsRepository implements ChangesetDetailsRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectRepository
     */
    protected $changesetsDetailsRepository;

    /**
     * @param ObjectRepository $changesetDetailsRepository
     */
    public function __construct(ObjectRepository $changesetDetailsRepository)
    {
        $this->changesetDetailsRepository = $changesetDetailsRepository;
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
        return $this->changesetDetailsRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ChangesetsInterface[]
     */
    public function findAll()
    {
        return $this->changesetDetailsRepository->findAll();
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
        return $this->changesetDetailsRepository->findBy($criteria, $orderBy, $limit, $offset);
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
        return $this->changesetDetailsRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->changesetDetailsRepository->getClassName();
    }

    /**
     * Return all active records
     *
     * @return Changesets
     */
    public function findActive()
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('r')
            ->from('LundPlatform\Entity\ChangesetDetails', 'r');

        return $query->getQuery()
            ->useResultCache(true, 7200, 'changeset_details_find_active')
            ->getResult();
    }
}
