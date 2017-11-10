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
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Repository;

use LundProducts\Repository\ProductLinesRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Product Lines Repository
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class ProductLinesRepository implements ProductLinesRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $productLinesRepository;

    /**
     * @param ObjectRepository $productLinesRepository
     */
    public function __construct(
        ObjectManager        $objectManager,
        ObjectRepository $productLinesRepository)
    {
        $this->objectManager        = $objectManager;
        $this->productLinesRepository = $productLinesRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                        $id
     * @return ProductLinesInterface|null
     */
    public function find($id)
    {
        return $this->productLinesRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return ProductLinesInterface[]
     */
    public function findAll()
    {
        return $this->productLinesRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                   $criteria
     * @param  array|null              $orderBy
     * @param  int|null                $limit
     * @param  int|null                $offset
     * @return ProductLinesInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->productLinesRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                      $criteria
     * @return ProductLinesInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->productLinesRepository->findOneBy($criteria);
    }

    public function findByQuery($search = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query->select('r')
              ->from('LundProducts\Entity\ProductLines', 'r')
              ->where('r.deleted = false')
              ->where('r.disabled = false');
        $query->where(
            $query->expr()->orX(
                $query->expr()->like('r.name', '?1'),
                $query->expr()->like('r.shortCode', '?1')
            )
        )->setParameter(1, '%' . $search['name'] . '%');

        return $query->getQuery()
                     ->getResult();
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->productLinesRepository->getClassName();
    }
}
