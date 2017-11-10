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

use LundSite\Entity\ProductRegistrationInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * ProductRegistration Repository
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductRegistrationRepository implements ProductRegistrationRepositoryInterface, ObjectRepository
{
/**
     * @var ObjectRepository
     */
    protected $productRegistrationRepository;

    /**
     * @param ObjectRepository $productRegistrationRepository
     */
    public function __construct(ObjectRepository $productRegistrationRepository)
    {
        $this->productRegistrationRepository = $productRegistrationRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                               $id
     * @return ProductRegistrationInterface|null
     */
    public function find($id)
    {
        return $this->productRegistrationRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ProductRegistrationInterface[]
     */
    public function findAll()
    {
        return $this->productRegistrationRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                          $criteria
     * @param  array|null                     $orderBy
     * @param  int|null                       $limit
     * @param  int|null                       $offset
     * @return ProductRegistrationInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productRegistrationRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                             $criteria
     * @return ProductRegistrationInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->productRegistrationRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->productRegistrationRepository->getClassName();
    }
}
