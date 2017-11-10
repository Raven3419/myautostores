<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Module
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Repository;

use LundSite\Entity\LifestyleHouseholdInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * LifestyleHousehold Repository
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class LifestyleHouseholdRepository implements LifestyleHouseholdRepositoryInterface, ObjectRepository
{
/**
     * @var ObjectRepository
     */
    protected $lifestyleHouseholdRepository;

    /**
     * @param ObjectRepository $lifestyleHouseholdRepository
     */
    public function __construct(ObjectRepository $lifestyleHouseholdRepository)
    {
        $this->lifestyleHouseholdRepository = $lifestyleHouseholdRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                              $id
     * @return LifestyleHouseholdInterface|null
     */
    public function find($id)
    {
        return $this->lifestyleHouseholdRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return LifestyleHouseholdInterface[]
     */
    public function findAll()
    {
        return $this->lifestyleHouseholdRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                         $criteria
     * @param  array|null                    $orderBy
     * @param  int|null                      $limit
     * @param  int|null                      $offset
     * @return LifestyleHouseholdInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->lifestyleHouseholdRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                            $criteria
     * @return LifestyleHouseholdInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->lifestyleHouseholdRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->lifestyleHouseholdRepository->getClassName();
    }
}
