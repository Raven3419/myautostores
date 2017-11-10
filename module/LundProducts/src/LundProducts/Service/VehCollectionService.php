<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use Zend\EventManager\Eventmanager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\VehCollection;
use LundProducts\Entity\VehCollectionInterface;
use LundProducts\Repository\VehCollectionRepositoryInterface;
use LundProducts\Repository\VehYearRepositoryInterface;
use RocketUser\Entity\User;
use DateTime;

/*
 * Service managing the CRUD of vehicles.
 */
class VehCollectionService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @var VehYearRepositoryInterface
     */
    protected $vehYearRepository;

    /**
     * @param ObjectManager                    $objectManager
     * @param VehCollectionRepositoryInterface $repository
     * @param VehYearRepositoryInterface       $vehYearRepository
     */
    public function __construct(
        ObjectManager                     $objectManager,
        VehCollectionRepositoryInterface  $repository,
        VehYearRepositoryInterface $vehYearRepository
    )
    {
        $this->objectManager = $objectManager;
        $this->repository    = $repository;
        $this->vehYearRepository = $vehYearRepository;
    }

    /**
     * @return mixed
     */
    public function getAllVehCollections()
    {
        return $this->repository->findAll(array(
            'vehMake'     => 'ASC',
            'vehModel'    => 'ASC',
            'vehSubmodel' => 'ASC',
            'vehYear'     => 'ASC')
        );
    }

    /**
     * @return mixed
     */
    public function getVehCollections($limit = null, $offset = null, $orderBy = array(), $sSearch = null)
    {
        return $this->repository->findActive($limit, $offset, $orderBy, $sSearch);
    }

    /**
     * @param integer $recordId
     *
     * @return mixed
     */
    public function getVehCollection($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @return mixed
     */
    public function getVehCollectionTotalCount($sSearch = null)
    {
        return $this->repository->getTotalRows($sSearch);
    }

    /**
     * @return array
     */
    public function getVehCollectionListings(AbstractActionController $controller, $limit = null, $offset = null, $sEcho = null, $sortingCols = null, $sSearch = null)
    {
        $columns = array('r.vehYear', 'r.vehMake', 'r.vehModel', 'r.vehSubmodel', );
        $orderBy     = array();

        if ($sortingCols > 0) {
            for ($i = 0; $i < $sortingCols; $i++) {
                if ($controller->params()->fromQuery('bSortable_' . $controller->params()->fromQuery('iSortCol_' . $i)) == 'true') {
                    // column name
                    $orderBy[] = $columns[(INT)$controller->params()->fromQuery('iSortCol_' . $i)];
                    // order direction
                    $orderBy[] = (($controller->params()->fromQuery('sSortDir_' . $i) === 'asc') ? 'ASC' : 'DESC');
                }
            }
        }

        $records           = $this->getVehCollections($limit, $offset, $orderBy, $sSearch);
        $recordsCount      = count($records);
        $totalRecordsCount = $this->getVehCollectionTotalCount($sSearch);
        $aaData            = array();

        if ($recordsCount > 0) {
            foreach ($records as $record) {
                $aaData[] = array($record->getVehYear()->getName(),
                                  $record->getVehMake()->getName(),
                                  $record->getVehModel()->getName(),
                                  ($record->getVehSubmodel()) ? $record->getVehSubmodel()->getName() : '',
                                  $record->getVehCollectionId()
                );
            }
        }

        return array('sEcho'                => $sEcho,
                     'aaData'               => $aaData,
                     'iTotalRecords'        => $totalRecordsCount,
                     'iTotalDisplayRecords' => $totalRecordsCount);
    }

    /**
     * Return a list of years in the system
     *
     * @return mixed
     */
    public function getVehYears()
    {
        return $this->vehYearRepository->findBy(
            array(),
            array(
                'name' => 'DESC',
            )
        );
    }

    /**
     * Return a list of years in the system
     *
     * @return mixed
     */
    public function getVehYearsByName($name)
    {
        return $this->vehYearRepository->findOneBy(
            array('name'  => $name)
        );
    }

    /**
     * Return a list of makes by year
     */
    public function getMake($make)
    {
        return $this->repository->findMake($make);
    }

    /**
     * Return a list of model by make
     */
    public function getModel($model, $make)
    {
        //echo $model;
        return $this->repository->findModel($model, $make);
    }

    /**
     * Return a list of submodels by model
     */
    public function getSubModel($submodel, $model)
    {
        return $this->repository->findSubModel($submodel, $model);
    }

    /**
     * Return a list of makes by year
     */
    public function getVehMake($year)
    {
        return $this->repository->findByYear($year);
    }

    /**
     * Return a list of models by year and make
     */
    public function getVehModel($year, $make)
    {
        return $this->repository->findByYearMake($year, $make);
    }

    /**
     * Return a list of submodels by year and make and model
     */
    public function getVehSubmodel($year, $make, $model)
    {
        return $this->repository->findByYearMakeModel($year, $make, $model);
    }

    /**
     * Return a list of vehicle collections by year make model submodel
     */
    public function getVehCollSelector($year, $make, $model, $submodel=null)
    {
        return $this->repository->findBySelector($year, $make, $model, $submodel);
    }

    /**
     * setEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::setEventManager()
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__, get_class($this)));

        $this->eventManager = $eventManager;
    }

    /**
     * getEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::getEventManager()
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }
}
