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

use LundSite\Entity\SpecialOffersInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * NewsRelease Repository
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class SpecialOffersRepository implements SpecialOffersRepositoryInterface, ObjectRepository
{
/**
     * @var ObjectRepository
     */
    protected $specialOffersRepository;

    /**
     * @param ObjectRepository $newsReleaseRepository
     */
    public function __construct(ObjectRepository $specialOffersRepository)
    {
        $this->specialOffersRepository = $specialOffersRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                       $id
     * @return SpecialOffersInterface|null
     */
    public function find($id)
    {
        return $this->specialOffersRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return SpecialOffersInterface[]
     */
    public function findAll()
    {
        return $this->specialOffersRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                  $criteria
     * @param  array|null             $orderBy
     * @param  int|null               $limit
     * @param  int|null               $offset
     * @return SpecialOffersInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->specialOffersRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                     $criteria
     * @return SpecialOffersInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->specialOffersRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->specialOffersRepository->getClassName();
    }
}
