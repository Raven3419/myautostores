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

use LundSite\Entity\SupportRequestInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * SupportRequest Repository
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class SupportRequestRepository implements SupportRequestRepositoryInterface, ObjectRepository
{
/**
     * @var ObjectRepository
     */
    protected $supportRequestRepository;

    /**
     * @param ObjectRepository $supportRequestRepository
     */
    public function __construct(ObjectRepository $supportRequestRepository)
    {
        $this->supportRequestRepository = $supportRequestRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                          $id
     * @return SupportRequestInterface|null
     */
    public function find($id)
    {
        return $this->supportRequestRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return SupportRequestInterface[]
     */
    public function findAll()
    {
        return $this->supportRequestRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                     $criteria
     * @param  array|null                $orderBy
     * @param  int|null                  $limit
     * @param  int|null                  $offset
     * @return SupportRequestInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->supportRequestRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                        $criteria
     * @return SupportRequestInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->supportRequestRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->supportRequestRepository->getClassName();
    }
}
