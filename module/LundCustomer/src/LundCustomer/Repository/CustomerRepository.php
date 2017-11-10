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

use LundCustomer\Repository\CustomerRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Customer Repository
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerRepository implements CustomerRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectRepository
     */
    protected $customerRepository;

    /**
     * @param ObjectRepository $customerRepository
     */
    public function __construct(ObjectRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                    $id
     * @return CustomerInterface|null
     */
    public function find($id)
    {
        return $this->customerRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return CustomerInterface[]
     */
    public function findAll()
    {
        return $this->customerRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array               $criteria
     * @param  array|null          $orderBy
     * @param  int|null            $limit
     * @param  int|null            $offset
     * @return CustomerInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->customerRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                  $criteria
     * @return CustomerInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->customerRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->customerRepository->getClassName();
    }
}
