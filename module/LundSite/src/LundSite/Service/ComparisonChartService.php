<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use RocketUser\Entity\UserInterface;
use RocketCms\Entity\SiteInterface;
use LundSite\Entity\ComparisonChart;
use LundSite\Entity\ComparisonChartInterface;
use LundSite\Repository\ComparisonChartRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\ComparisonChartForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of ComparisonChart.
 */
class ComparisonChartService implements EventManagerAwareInterface
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
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var SiteRepositoryInterface
     */
    protected $siteRepository;

    /**
     * @var ComparisonChartRepositoryInterface
     */
    protected $comparisonChartRepository;

    /**
     * @var ComparisonChartForm
     */
    protected $comparisonChartForm;

    /**
     * @var ComparisonChartInterface
     */
    protected $comparisonChartPrototype;

    /**
     * @param ObjectManager                  		$objectManager
     * @param UserRepositoryInterface        		$userRepository
     * @param SiteRepositoryInterface        		$siteRepository
     * @param ComparisonChartRepositoryInterface 	$comparisonChartRepository
     * @param FormInterface                  		$comparisonChartForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        ComparisonChartRepositoryInterface $comparisonChartRepository,
        FormInterface $comparisonChartForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->comparisonChartRepository = $comparisonChartRepository;
        $this->comparisonChartForm       = $comparisonChartForm;
    }

    /**
     * Return a list of active ComparisonChart
     *
     * @return ComparisonChartInterface
     */
    public function getActiveComparisonChart()
    {
        return $this->comparisonChartRepository->findBy(
            array(
                'deleted'  => false,
            )
        );
    }

    /**
     * Return a list of active ComparisonChart
     *
     * @return ComparisonChartInterface
     */
    public function getComparisonChartByProduct($id = null)
    {
        return $this->comparisonChartRepository->findBy(
            array(
                'productLine'  => $id,
                'status'  => '0',
            ),
            array(
                'createdAt' => 'ASC',
            )
        );
    }

    /**
     * Return create ComparisonChart form
     *
     * @return ComparisonChartForm
     */
    public function getCreateComparisonChartForm()
    {
        $this->comparisonChartForm->bind(clone $this->getComparisonChartPrototype());

        return $this->comparisonChartForm;
    }

    /**
     * Return edit ComparisonChart form
     *
     * @param  string          $comparisonChartId
     * @return ComparisonChartForm
     */
    public function getEditComparisonChartForm($comparisonChartId)
    {
        $comparisonChart = $this->comparisonChartRepository->find($comparisonChartId);

        $this->comparisonChartForm->bind($comparisonChart);

        return $this->comparisonChartForm;
    }

    /**
     * Return ComparisonChart entity
     *
     * @param  string               $comparisonChartId
     * @return ComparisonChartInterface
     */
    public function getComparisonChart($comparisonChartId)
    {
        $comparisonChart = $this->comparisonChartRepository->find($comparisonChartId);

        return $comparisonChart;
    }

    /**
     * Creates a new ComparisonChart.
     *
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ComparisonChartInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->comparisonChartForm->bind(clone $this->getComparisonChartPrototype());
        $this->comparisonChartForm->setData($data);

        if (!$this->comparisonChartForm->isValid()) {

        	//print_r($this->comparisonChartForm->getMessages()); //error messages
        	//exit;
            return null;
        }

        $comparisonChart = $this->comparisonChartForm->getData();

        if (!$comparisonChart instanceof ComparisonChartInterface) {
            throw Exception\UnexpectedValueException::invalidComparisonChartEntity($comparisonChart);
        }

        $comparisonChart->setCreatedAt(new DateTime('now'))
            	  		->setCreatedBy($identity->getUsername())
            	  		->setDeleted(false);;

        $this->objectManager->persist($comparisonChart);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ComparisonChartEvent('comparisonChartCreated', $comparisonChart));

        return $comparisonChart;
    }

    /**
     * Edit an existing ComparisonChart.
     *
     * @param  UserInterface                      	$identity
     * @param  \Zend\Stdlib\Parameters            	$data
     * @param  ComparisonChartInterface          	$comparisonChart
     * @throws Exception\UnexpectedValueException
     * @return null|ComparisonChartInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, ComparisonChartInterface $comparisonChart)
    {
    	
        $this->comparisonChartForm->bind(clone $this->getComparisonChartPrototype());
        $this->comparisonChartForm->setData($data);

        if (!$this->comparisonChartForm->isValid()) {
            return null;
        }

        $comparisonChart = $this->comparisonChartForm->getData();

        if (!$comparisonChart instanceof ComparisonChartInterface) {
            throw Exception\UnexpectedValueException::invalidComparisonChartEntity($comparisonChart);
        }

        $comparisonChart->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ComparisonChartEvent('comparisonChartEdited', $comparisonChart));

        return $comparisonChart;
    }

    /**
     * Delete an existing ComparisonChart.
     *
     * @param  UserInterface                      		$identity
     * @param  ComparisonChartInterface             		$ComparisonChart
     * @throws Exception\UnexpectedValueException
     * @return null|ComparisonChartInterface
     */
    public function delete(UserInterface $identity, ComparisonChartInterface $comparisonChart)
    {
        if (!$comparisonChart instanceof ComparisonChartInterface) {
            throw Exception\UnexpectedValueException::invalidComparisonChartEntity($comparisonChart);
        }

        $comparisonChart->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername())
            	  ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ComparisonChartEvent('comparisonChartDeleted', $comparisonChart));

        return $comparisonChart;
    }

    /**
     * @return ComparisonChartInterface
     */
    public function getComparisonChartPrototype()
    {
        if ($this->comparisonChartPrototype === null) {
            $this->setComparisonChartPrototype(new ComparisonChart());
        }

        return $this->comparisonChartPrototype;
    }

    /**
     * @param  ComparisonChartInterface $comparisonChartPrototype
     * @return ComparisonChartService
     */
    public function setComparisonChartPrototype(ComparisonChartInterface $comparisonChartPrototype)
    {
        $this->comparisonChartPrototype = $comparisonChartPrototype;

        return $this;
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
