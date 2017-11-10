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
use LundSite\Entity\SupportRequest;
use LundSite\Entity\SupportRequestInterface;
use LundSite\Repository\SupportRequestRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\SupportRequestForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of supportRequests.
 */
class SupportRequestService implements EventManagerAwareInterface
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
     * @var SupportRequestRepositoryInterface
     */
    protected $supportRequestRepository;

    /**
     * @var SupportRequestForm
     */
    protected $supportRequestForm;

    /**
     * @var SupportRequestInterface
     */
    protected $supportRequestPrototype;

    /**
     * @param ObjectManager                     $objectManager
     * @param UserRepositoryInterface           $userRepository
     * @param SiteRepositoryInterface           $siteRepository
     * @param SupportRequestRepositoryInterface $supportRequestRepository
     * @param FormInterface                     $supportRequestForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        SupportRequestRepositoryInterface $supportRequestRepository,
        FormInterface $supportRequestForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->supportRequestRepository = $supportRequestRepository;
        $this->supportRequestForm       = $supportRequestForm;
    }

    /**
     * Return a list of active supportRequests
     *
     * @return SupportRequestInterface
     */
    public function getActiveSupportRequests()
    {
        return $this->supportRequestRepository->findBy(
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
     * Return a list of active supportRequests by site
     *
     * @param  SiteInterface           $site
     * @return SupportRequestInterface
     */
    public function getActiveSupportRequestsBySite(SiteInterface $site)
    {
        return $this->supportRequestRepository->findBy(
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
     * Return create supportRequest form
     *
     * @return SupportRequestForm
     */
    public function getCreateSupportRequestForm()
    {
        $this->supportRequestForm->bind(clone $this->getSupportRequestPrototype());

        return $this->supportRequestForm;
    }

    /**
     * Return edit supportRequest form
     *
     * @param  string             $supportRequestId
     * @return SupportRequestForm
     */
    public function getEditSupportRequestForm($supportRequestId)
    {
        $supportRequest = $this->supportRequestRepository->find($supportRequestId);

        $this->supportRequestForm->bind($supportRequest);

        return $this->supportRequestForm;
    }

    /**
     * Return supportRequest entity
     *
     * @param  string                  $supportRequestId
     * @return SupportRequestInterface
     */
    public function getSupportRequest($supportRequestId)
    {
        $supportRequest = $this->supportRequestRepository->find($supportRequestId);

        return $supportRequest;
    }

    /**
     * Creates a new supportRequest.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|SupportRequestInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->supportRequestForm->bind(clone $this->getSupportRequestPrototype());
        $this->supportRequestForm->setData($data);

        if (!$this->supportRequestForm->isValid()) {
            return null;
        }

        $supportRequest = $this->supportRequestForm->getData();

        if (!$supportRequest instanceof SupportRequestInterface) {
            throw Exception\UnexpectedValueException::invalidSupportRequestEntity($supportRequest);
        }

        $supportRequest->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($supportRequest);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SupportRequestEvent('supportRequestCreated', $supportRequest));

        return $supportRequest;
    }

    /**
     * Edit an existing supportRequest.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  SupportRequestInterface            $supportRequest
     * @throws Exception\UnexpectedValueException
     * @return null|SupportRequestInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, SupportRequestInterface $supportRequest)
    {
        $this->supportRequestForm->bind(clone $this->getSupportRequestPrototype());
        $this->supportRequestForm->setData($data);

        if (!$this->supportRequestForm->isValid()) {
            return null;
        }

        $supportRequest = $this->supportRequestForm->getData();

        if (!$supportRequest instanceof SupportRequestInterface) {
            throw Exception\UnexpectedValueException::invalidSupportRequestEntity($supportRequest);
        }

        $supportRequest->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SupportRequestEvent('supportRequestEdited', $supportRequest));

        return $supportRequest;
    }

    /**
     * Delete an existing supportRequest.
     *
     * @param  UserInterface                      $identity
     * @param  SupportRequestInterface            $supportRequest
     * @throws Exception\UnexpectedValueException
     * @return null|SupportRequestInterface
     */
    public function delete(UserInterface $identity, SupportRequestInterface $supportRequest)
    {
        if (!$supportRequest instanceof SupportRequestInterface) {
            throw Exception\UnexpectedValueException::invalidSupportRequestEntity($supportRequest);
        }

        $supportRequest->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SupportRequestEvent('supportRequestDeleted', $supportRequest));

        return $supportRequest;
    }

    /**
     * @return SupportRequestInterface
     */
    public function getSupportRequestPrototype()
    {
        if ($this->supportRequestPrototype === null) {
            $this->setSupportRequestPrototype(new SupportRequest());
        }

        return $this->supportRequestPrototype;
    }

    /**
     * @param  SupportRequestInterface $supportRequestPrototype
     * @return SupportRequestService
     */
    public function setSupportRequestPrototype(SupportRequestInterface $supportRequestPrototype)
    {
        $this->supportRequestPrototype = $supportRequestPrototype;

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
