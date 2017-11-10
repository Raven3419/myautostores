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

use LundSite\Entity\CustomerReviewInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * CustomerReview Repository
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerReviewRepository implements CustomerReviewRepositoryInterface, ObjectRepository
{
/**
     * @var ObjectRepository
     */
    protected $customerReviewRepository;

    /**
     * @param ObjectRepository $customerReviewRepository
     */
    public function __construct(ObjectRepository $customerReviewRepository)
    {
        $this->customerReviewRepository = $customerReviewRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                       $id
     * @return CustomerReviewInterface|null
     */
    public function find($id)
    {
        return $this->customerReviewRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return CustomerReviewInterface[]
     */
    public function findAll()
    {
        return $this->customerReviewRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                  $criteria
     * @param  array|null             $orderBy
     * @param  int|null               $limit
     * @param  int|null               $offset
     * @return CustomerReviewInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->customerReviewRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                     $criteria
     * @return CustomerReviewInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->customerReviewRepository->findOneBy($criteria);
    }


    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
    	return $this->customerReviewRepository->getClassName();
    }
}
