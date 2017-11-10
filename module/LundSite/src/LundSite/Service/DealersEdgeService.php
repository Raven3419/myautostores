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
use LundSite\Entity\DealersEdge;
use LundSite\Entity\DealersEdgeInterface;
use LundSite\Repository\DealersEdgeRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\DealersEdgeForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of dealersEdges.
 */
class DealersEdgeService implements EventManagerAwareInterface
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
     * @var DealersEdgeRepositoryInterface
     */
    protected $dealersEdgeRepository;

    /**
     * @var DealersEdgeForm
     */
    protected $dealersEdgeForm;

    /**
     * @var DealersEdgeInterface
     */
    protected $dealersEdgePrototype;

    /**
     * @param ObjectManager                  $objectManager
     * @param UserRepositoryInterface        $userRepository
     * @param SiteRepositoryInterface        $siteRepository
     * @param DealersEdgeRepositoryInterface $dealersEdgeRepository
     * @param FormInterface                  $dealersEdgeForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        DealersEdgeRepositoryInterface $dealersEdgeRepository,
        FormInterface $dealersEdgeForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->dealersEdgeRepository = $dealersEdgeRepository;
        $this->dealersEdgeForm       = $dealersEdgeForm;
    }

    /**
     * Return a list of active dealersEdges
     *
     * @return DealersEdgeInterface
     */
    public function getActiveDealersEdges()
    {
        return $this->dealersEdgeRepository->findBy(
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
     * Return a list of active dealersEdges by site
     *
     * @param  SiteInterface        $site
     * @return DealersEdgeInterface
     */
    public function getActiveDealersEdgesBySite(SiteInterface $site)
    {
        return $this->dealersEdgeRepository->findBy(
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
     * Return create dealersEdge form
     *
     * @return DealersEdgeForm
     */
    public function getCreateDealersEdgeForm()
    {
        $this->dealersEdgeForm->bind(clone $this->getDealersEdgePrototype());

        return $this->dealersEdgeForm;
    }

    /**
     * Return edit dealersEdge form
     *
     * @param  string          $dealersEdgeId
     * @return DealersEdgeForm
     */
    public function getEditDealersEdgeForm($dealersEdgeId)
    {
        $dealersEdge = $this->dealersEdgeRepository->find($dealersEdgeId);

        $this->dealersEdgeForm->bind($dealersEdge);

        return $this->dealersEdgeForm;
    }

    /**
     * Return dealersEdge entity
     *
     * @param  string               $dealersEdgeId
     * @return DealersEdgeInterface
     */
    public function getDealersEdge($dealersEdgeId)
    {
        $dealersEdge = $this->dealersEdgeRepository->find($dealersEdgeId);

        return $dealersEdge;
    }

    /**
     * Creates a new dealersEdge.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|DealersEdgeInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->dealersEdgeForm->bind(clone $this->getDealersEdgePrototype());
        $this->dealersEdgeForm->setData($data);

        if (!$this->dealersEdgeForm->isValid()) {
            var_dump($this->dealersEdgeForm->getMessages());
            return null;
        }

        $dealersEdge = $this->dealersEdgeForm->getData();

        if (!$dealersEdge instanceof DealersEdgeInterface) {
            throw Exception\UnexpectedValueException::invalidDealersEdgeEntity($dealersEdge);
        }

        $dealersEdge->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($dealersEdge);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new DealersEdgeEvent('dealersEdgeCreated', $dealersEdge));

        return $dealersEdge;
    }

    /**
     * Edit an existing dealersEdge.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  DealersEdgeInterface               $dealersEdge
     * @throws Exception\UnexpectedValueException
     * @return null|DealersEdgeInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, DealersEdgeInterface $dealersEdge)
    {
        $this->dealersEdgeForm->bind(clone $this->getDealersEdgePrototype());
        $this->dealersEdgeForm->setData($data);

        if (!$this->dealersEdgeForm->isValid()) {
            return null;
        }

        $dealersEdge = $this->dealersEdgeForm->getData();

        if (!$dealersEdge instanceof DealersEdgeInterface) {
            throw Exception\UnexpectedValueException::invalidDealersEdgeEntity($dealersEdge);
        }

        $dealersEdge->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new DealersEdgeEvent('dealersEdgeEdited', $dealersEdge));

        return $dealersEdge;
    }

    /**
     * Delete an existing dealersEdge.
     *
     * @param  UserInterface                      $identity
     * @param  DealersEdgeInterface               $dealersEdge
     * @throws Exception\UnexpectedValueException
     * @return null|DealersEdgeInterface
     */
    public function delete(UserInterface $identity, DealersEdgeInterface $dealersEdge)
    {
        if (!$dealersEdge instanceof DealersEdgeInterface) {
            throw Exception\UnexpectedValueException::invalidDealersEdgeEntity($dealersEdge);
        }

        $dealersEdge->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new DealersEdgeEvent('dealersEdgeDeleted', $dealersEdge));

        return $dealersEdge;
    }

    /**
     * @return DealersEdgeInterface
     */
    public function getDealersEdgePrototype()
    {
        if ($this->dealersEdgePrototype === null) {
            $this->setDealersEdgePrototype(new DealersEdge());
        }

        return $this->dealersEdgePrototype;
    }

    /**
     * @param  DealersEdgeInterface $dealersEdgePrototype
     * @return DealersEdgeService
     */
    public function setDealersEdgePrototype(DealersEdgeInterface $dealersEdgePrototype)
    {
        $this->dealersEdgePrototype = $dealersEdgePrototype;

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
