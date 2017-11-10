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
 * @link       https://github.com/rocketred/com for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Repository;

use LundProducts\Repository\VehYearRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * VehYear Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class VehYearRepository implements VehYearRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectRepository
     */
    protected $vehYearRepository;

    /**
     * @param ObjectRepository $vehYearRepository
     */
    public function __construct(ObjectRepository $vehYearRepository)
    {
        $this->vehYearRepository = $vehYearRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                   $id
     * @return VehYearInterface|null
     */
    public function find($id)
    {
        return $this->vehYearRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return VehYearInterface[]
     */
    public function findAll()
    {
        return $this->vehYearRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array              $criteria
     * @param  array|null         $orderBy
     * @param  int|null           $limit
     * @param  int|null           $offset
     * @return VehYearInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->vehYearRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                 $criteria
     * @return VehYearInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->vehYearRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->vehYearRepository->getClassName();
    }
}
