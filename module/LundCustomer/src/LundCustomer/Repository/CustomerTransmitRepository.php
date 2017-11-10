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

use LundCustomer\Repository\CustomerTransmitRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Customer Transmit Repository
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerTransmitRepository implements CustomerTransmitRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectRepository
     */
    protected $customerTransmitRepository;

    /**
     * @param ObjectRepository $customerTransmitRepository
     */
    public function __construct(ObjectRepository $customerTransmitRepository)
    {
        $this->customerTransmitRepository = $customerTransmitRepository;
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
        return $this->customerTransmitRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return CustomerInterface[]
     */
    public function findAll()
    {
        return $this->customerTransmitRepository->findAll();
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
        return $this->customerTransmitRepository->findBy($criteria, $orderBy, $limit, $offset);
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
        return $this->customerTransmitRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->customerTransmitRepository->getClassName();
    }
}
