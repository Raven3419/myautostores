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

use LundProducts\Repository\ProductLineFeatureRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Part Feature Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductLineFeatureRepository implements ProductLineFeatureRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectRepository
     */
    protected $productLineFeatureRepository;

    /**
     * @param ObjectRepository $productLineFeatureRepository
     */
    public function __construct(ObjectRepository $productLineFeatureRepository)
    {
        $this->productLineFeatureRepository = $productLineFeatureRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                            $id
     * @return ProductLineFeatureInterface|null
     */
    public function find($id)
    {
        return $this->productLineFeatureRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ProductLineFeatureInterface[]
     */
    public function findAll()
    {
        return $this->productLineFeatureRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                       $criteria
     * @param  array|null                  $orderBy
     * @param  int|null                    $limit
     * @param  int|null                    $offset
     * @return ProductLineFeatureInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productLineFeatureRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                          $criteria
     * @return ProductLineFeatureInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->productLineFeatureRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->productLineFeatureRepository->getClassName();
    }
}
