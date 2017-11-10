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
use LundSite\Entity\DriversCouncil;
use LundSite\Entity\DriversCouncilInterface;
use LundSite\Repository\DriversCouncilRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\DriversCouncilForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of driversCouncils.
 */
class DriversCouncilService implements EventManagerAwareInterface
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
     * @var DriversCouncilRepositoryInterface
     */
    protected $driversCouncilRepository;

    /**
     * @var DriversCouncilForm
     */
    protected $driversCouncilForm;

    /**
     * @var DriversCouncilInterface
     */
    protected $driversCouncilPrototype;

    /**
     * @param ObjectManager                     $objectManager
     * @param UserRepositoryInterface           $userRepository
     * @param SiteRepositoryInterface           $siteRepository
     * @param DriversCouncilRepositoryInterface $driversCouncilRepository
     * @param FormInterface                     $driversCouncilForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        DriversCouncilRepositoryInterface $driversCouncilRepository,
        FormInterface $driversCouncilForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->driversCouncilRepository = $driversCouncilRepository;
        $this->driversCouncilForm       = $driversCouncilForm;
    }

    /**
     * Return a list of active driversCouncils
     *
     * @return DriversCouncilInterface
     */
    public function getActiveDriversCouncils()
    {
        return $this->driversCouncilRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            ),
            array(
                'createdAt'   => 'ASC',
            )
        );
    }

    /**
     * Return a list of active driversCouncils by site
     *
     * @param  SiteInterface           $site
     * @return DriversCouncilInterface
     */
    public function getActiveDriversCouncilsBySite(SiteInterface $site)
    {
        return $this->driversCouncilRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            ),
            array(
                'createdAt'   => 'ASC',
            )
        );
    }

    /**
     * Return create driversCouncil form
     *
     * @return DriversCouncilForm
     */
    public function getCreateDriversCouncilForm()
    {
        $this->driversCouncilForm->bind(clone $this->getDriversCouncilPrototype());

        return $this->driversCouncilForm;
    }

    /**
     * Return edit driversCouncil form
     *
     * @param  string             $driversCouncilId
     * @return DriversCouncilForm
     */
    public function getEditDriversCouncilForm($driversCouncilId)
    {
        $driversCouncil = $this->driversCouncilRepository->find($driversCouncilId);

        $this->driversCouncilForm->bind($driversCouncil);

        return $this->driversCouncilForm;
    }

    /**
     * Return driversCouncil entity
     *
     * @param  string                  $driversCouncilId
     * @return DriversCouncilInterface
     */
    public function getDriversCouncil($driversCouncilId)
    {
        $driversCouncil = $this->driversCouncilRepository->find($driversCouncilId);

        return $driversCouncil;
    }

    /**
     * Creates a new driversCouncil.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|DriversCouncilInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->driversCouncilForm->bind(clone $this->getDriversCouncilPrototype());
        $this->driversCouncilForm->setData($data);

        if (!$this->driversCouncilForm->isValid()) {
            return null;
        }

        $driversCouncil = $this->driversCouncilForm->getData();

        if (!$driversCouncil instanceof DriversCouncilInterface) {
            throw Exception\UnexpectedValueException::invalidDriversCouncilEntity($driversCouncil);
        }

        $driversCouncil->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($driversCouncil);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new DriversCouncilEvent('driversCouncilCreated', $driversCouncil));

        return $driversCouncil;
    }

    /**
     * Edit an existing driversCouncil.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  DriversCouncilInterface            $driversCouncil
     * @throws Exception\UnexpectedValueException
     * @return null|DriversCouncilInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, DriversCouncilInterface $driversCouncil)
    {
        $this->driversCouncilForm->bind(clone $this->getDriversCouncilPrototype());
        $this->driversCouncilForm->setData($data);

        if (!$this->driversCouncilForm->isValid()) {
            return null;
        }

        $driversCouncil = $this->driversCouncilForm->getData();

        if (!$driversCouncil instanceof DriversCouncilInterface) {
            throw Exception\UnexpectedValueException::invalidDriversCouncilEntity($driversCouncil);
        }

        $driversCouncil->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new DriversCouncilEvent('driversCouncilEdited', $driversCouncil));

        return $driversCouncil;
    }

    /**
     * Delete an existing driversCouncil.
     *
     * @param  UserInterface                      $identity
     * @param  DriversCouncilInterface            $driversCouncil
     * @throws Exception\UnexpectedValueException
     * @return null|DriversCouncilInterface
     */
    public function delete(UserInterface $identity, DriversCouncilInterface $driversCouncil)
    {
        if (!$driversCouncil instanceof DriversCouncilInterface) {
            throw Exception\UnexpectedValueException::invalidDriversCouncilEntity($driversCouncil);
        }

        $driversCouncil->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new DriversCouncilEvent('driversCouncilDeleted', $driversCouncil));

        return $driversCouncil;
    }

    /**
     * @return DriversCouncilInterface
     */
    public function getDriversCouncilPrototype()
    {
        if ($this->driversCouncilPrototype === null) {
            $this->setDriversCouncilPrototype(new DriversCouncil());
        }

        return $this->driversCouncilPrototype;
    }

    /**
     * @param  DriversCouncilInterface $driversCouncilPrototype
     * @return DriversCouncilService
     */
    public function setDriversCouncilPrototype(DriversCouncilInterface $driversCouncilPrototype)
    {
        $this->driversCouncilPrototype = $driversCouncilPrototype;

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
