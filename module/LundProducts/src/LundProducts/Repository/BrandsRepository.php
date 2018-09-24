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
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Repository;

use LundProducts\Repository\BrandsRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Brands Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 */
class BrandsRepository implements BrandsRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectRepository
     */
    protected $brandsRepository;

    /**
     * @param ObjectRepository $brandsRepository
     */
    public function __construct(ObjectRepository $brandsRepository)
    {
        $this->brandsRepository = $brandsRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                  $id
     * @return BrandsInterface|null
     */
    public function find($id)
    {
        return $this->brandsRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return BrandsInterface[]
     */
    public function findAll()
    {
        return $this->brandsRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array             $criteria
     * @param  array|null        $orderBy
     * @param  int|null          $limit
     * @param  int|null          $offset
     * @return BrandsInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->brandsRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                $criteria
     * @return BrandsInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->brandsRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->brandsRepository->getClassName();
    }
}
