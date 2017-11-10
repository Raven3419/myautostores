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

use LundSite\Entity\VideoTestimonialsInterface;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * VideoTestimonials Repository
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Repository
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class VideoTestimonialsRepository implements VideoTestimonialsRepositoryInterface, ObjectRepository
{
/**
     * @var ObjectRepository
     */
    protected $videoTestimonialsRepository;

    /**
     * @param ObjectRepository $videoTestimonialsRepository
     */
    public function __construct(ObjectRepository $videoTestimonialsRepository)
    {
        $this->videoTestimonialsRepository = $videoTestimonialsRepository;
    }

    /**
     * find(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::find()
     * @param  int                       $id
     * @return VideoTestimonialsInterface|null
     */
    public function find($id)
    {
        return $this->videoTestimonialsRepository->find($id);
    }

    /**
     * findAll(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findAll()
     * @return VideoTestimonialsInterface[]
     */
    public function findAll()
    {
        return $this->videoTestimonialsRepository->findAll();
    }

    /**
     * findBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findBy()
     * @param  array                  $criteria
     * @param  array|null             $orderBy
     * @param  int|null               $limit
     * @param  int|null               $offset
     * @return VideoTestimonialsInterface[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->videoTestimonialsRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * findOneBy(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::findOneBy()
     * @param  array                     $criteria
     * @return VideoTestimonialsInterface|null
     */
    public function findOneBy(array $criteria)
    {
        return $this->videoTestimonialsRepository->findOneBy($criteria);
    }


    /**
     * getClassName(): defined by ObjectRepository.
     *
     * @see    ObjectRepository::getClassName()
     * @return string
     */
    public function getClassName()
    {
    	return $this->videoTestimonialsRepository->getClassName();
    }
}
