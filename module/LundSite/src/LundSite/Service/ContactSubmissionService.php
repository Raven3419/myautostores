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
use LundSite\Entity\ContactSubmission;
use LundSite\Entity\ContactSubmissionInterface;
use LundSite\Repository\ContactSubmissionRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\ContactSubmissionForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of contactSubmissions.
 */
class ContactSubmissionService implements EventManagerAwareInterface
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
     * @var ContactSubmissionRepositoryInterface
     */
    protected $contactSubmissionRepository;

    /**
     * @var ContactSubmissionForm
     */
    protected $contactSubmissionForm;

    /**
     * @var ContactSubmissionInterface
     */
    protected $contactSubmissionPrototype;

    /**
     * @param ObjectManager                        $objectManager
     * @param UserRepositoryInterface              $userRepository
     * @param SiteRepositoryInterface              $siteRepository
     * @param ContactSubmissionRepositoryInterface $contactSubmissionRepository
     * @param FormInterface                        $contactSubmissionForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        ContactSubmissionRepositoryInterface $contactSubmissionRepository,
        FormInterface $contactSubmissionForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->contactSubmissionRepository = $contactSubmissionRepository;
        $this->contactSubmissionForm       = $contactSubmissionForm;
    }

    /**
     * Return a list of active contactSubmissions
     *
     * @return ContactSubmissionInterface
     */
    public function getActiveContactSubmissions()
    {
        return $this->contactSubmissionRepository->findBy(
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
     * Return a list of active contactSubmissions by site
     *
     * @param  SiteInterface              $site
     * @return ContactSubmissionInterface
     */
    public function getActiveContactSubmissionsBySite(SiteInterface $site)
    {
        return $this->contactSubmissionRepository->findBy(
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
     * Return create contactSubmission form
     *
     * @return ContactSubmissionForm
     */
    public function getCreateContactSubmissionForm()
    {
        $this->contactSubmissionForm->bind(clone $this->getContactSubmissionPrototype());

        return $this->contactSubmissionForm;
    }

    /**
     * Return edit contactSubmission form
     *
     * @param  string                $contactSubmissionId
     * @return ContactSubmissionForm
     */
    public function getEditContactSubmissionForm($contactSubmissionId)
    {
        $contactSubmission = $this->contactSubmissionRepository->find($contactSubmissionId);

        $this->contactSubmissionForm->bind($contactSubmission);

        return $this->contactSubmissionForm;
    }

    /**
     * Return contactSubmission entity
     *
     * @param  string                     $contactSubmissionId
     * @return ContactSubmissionInterface
     */
    public function getContactSubmission($contactSubmissionId)
    {
        $contactSubmission = $this->contactSubmissionRepository->find($contactSubmissionId);

        return $contactSubmission;
    }

    /**
     * Creates a new contactSubmission.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ContactSubmissionInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->contactSubmissionForm->bind(clone $this->getContactSubmissionPrototype());
        $this->contactSubmissionForm->setData($data);

        if (!$this->contactSubmissionForm->isValid()) {
            //echo "error";
            //print_r($this->contactSubmissionForm->getMessages());exit;
            return null;
        }

        $contactSubmission = $this->contactSubmissionForm->getData();

        if (!$contactSubmission instanceof ContactSubmissionInterface) {
            throw Exception\UnexpectedValueException::invalidContactSubmissionEntity($contactSubmission);
        }

        $contactSubmission->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($contactSubmission);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ContactSubmissionEvent('contactSubmissionCreated', $contactSubmission));

        return $contactSubmission;
    }

    /**
     * Edit an existing contactSubmission.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  ContactSubmissionInterface         $contactSubmission
     * @throws Exception\UnexpectedValueException
     * @return null|ContactSubmissionInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, ContactSubmissionInterface $contactSubmission)
    {
        $this->contactSubmissionForm->bind(clone $this->getContactSubmissionPrototype());
        $this->contactSubmissionForm->setData($data);

        if (!$this->contactSubmissionForm->isValid()) {
            return null;
        }

        $contactSubmission = $this->contactSubmissionForm->getData();

        if (!$contactSubmission instanceof ContactSubmissionInterface) {
            throw Exception\UnexpectedValueException::invalidContactSubmissionEntity($contactSubmission);
        }

        $contactSubmission->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ContactSubmissionEvent('contactSubmissionEdited', $contactSubmission));

        return $contactSubmission;
    }

    /**
     * Delete an existing contactSubmission.
     *
     * @param  UserInterface                      $identity
     * @param  ContactSubmissionInterface         $contactSubmission
     * @throws Exception\UnexpectedValueException
     * @return null|ContactSubmissionInterface
     */
    public function delete(UserInterface $identity, ContactSubmissionInterface $contactSubmission)
    {
        if (!$contactSubmission instanceof ContactSubmissionInterface) {
            throw Exception\UnexpectedValueException::invalidContactSubmissionEntity($contactSubmission);
        }

        $contactSubmission->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ContactSubmissionEvent('contactSubmissionDeleted', $contactSubmission));

        return $contactSubmission;
    }

    /**
     * @return ContactSubmissionInterface
     */
    public function getContactSubmissionPrototype()
    {
        if ($this->contactSubmissionPrototype === null) {
            $this->setContactSubmissionPrototype(new ContactSubmission());
        }

        return $this->contactSubmissionPrototype;
    }

    /**
     * @param  ContactSubmissionInterface $contactSubmissionPrototype
     * @return ContactSubmissionService
     */
    public function setContactSubmissionPrototype(ContactSubmissionInterface $contactSubmissionPrototype)
    {
        $this->contactSubmissionPrototype = $contactSubmissionPrototype;

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
