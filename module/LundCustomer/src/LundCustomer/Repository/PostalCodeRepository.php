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

use LundCustomer\Repository\PostalCodeRepositoryInterface;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * PostalCode Repository
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PostalCodeRepository implements PostalCodeRepositoryInterface, ObjectRepository
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $postalCodeRepository;

    /**
     * @param ObjectRepository $postalCodeRepository
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $postalCodeRepository)
    {
        $this->objectManager = $objectManager;
        $this->postalCodeRepository = $postalCodeRepository;
    }

    public function findBetween($min_lat = null, $max_lat = null, $min_lon = null, $max_lon = null, $base = null)
    {
        $query = $this->objectManager->createQueryBuilder('r');
        $query->select(array('r'))
            ->from('LundCustomer\Entity\PostalCode', 'r');
        $query->where('r.lat BETWEEN :minlat AND :maxlat')
            ->andWhere('r.lon BETWEEN :minlon AND :maxlon');

        if (null != $base) {
            $query->andWhere('r.code <> :zip');
        }

        $parameters = array(
            'minlat' => $min_lat,
            'maxlat' => $max_lat,
            'minlon' => $min_lon,
            'maxlon' => $max_lon);

        if (null != $base) {
            $parameters['zip'] = $base;
        }

        $query->setParameters($parameters);

        return $query->getQuery()
            ->getResult();
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                      $id
     * @return PostalCodeInterface|null
     */
    public function find($id)
    {
        return $this->postalCodeRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return PostalCodeInterface[]
     */
    public function findAll()
    {
        return $this->postalCodeRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                 $criteria
     * @param  array|null            $orderBy
     * @param  int|null              $limit
     * @param  int|null              $offset
     * @return PostalCodeInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->postalCodeRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                    $criteria
     * @return PostalCodeInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->postalCodeRepository->findOneBy($criteria);
    }

    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
        return $this->postalCodeRepository->getClassName();
    }
}
