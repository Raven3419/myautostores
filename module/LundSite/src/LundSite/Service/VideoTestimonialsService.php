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
use LundSite\Entity\VideoTestimonials;
use LundSite\Entity\VideoTestimonialsInterface;
use LundSite\Repository\VideoTestimonialsRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\VideoTestimonialsForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of videoTestimonials.
 */
class VideoTestimonialsService implements EventManagerAwareInterface
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
     * @var VideoTestimonialsRepositoryInterface
     */
    protected $videoTestimonialsRepository;

    /**
     * @var VideoTestimonialsForm
     */
    protected $videoTestimonialsForm;

    /**
     * @var VideoTestimonialsInterface
     */
    protected $videoTestimonialsPrototype;

    /**
     * @param ObjectManager                  $objectManager
     * @param UserRepositoryInterface        $userRepository
     * @param SiteRepositoryInterface        $siteRepository
     * @param VideoTestimonialsRepositoryInterface 	 $videoTestimonialsRepository
     * @param FormInterface                  $videoTestimonialsForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        VideoTestimonialsRepositoryInterface $videoTestimonialsRepository,
        FormInterface $videoTestimonialsForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->videoTestimonialsRepository = $videoTestimonialsRepository;
        $this->videoTestimonialsForm       = $videoTestimonialsForm;
    }

    /**
     * Return a list of active videoTestimonials
     *
     * @return VideoTestimonialsInterface
     */
    public function getActiveVideoTestimonials()
    {
        return $this->videoTestimonialsRepository->findBy(
            array(
                'deleted'  => false,
            )
        );
    }

    /**
     * Return a list of active videoTestimonials
     *
     * @return VideoTestimonialsInterface
     */
    public function getVideoTestimonialsByProduct($id = null)
    {
        return $this->videoTestimonialsRepository->findBy(
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
     * Return create videoTestimonials form
     *
     * @return VideoTestimonialsForm
     */
    public function getCreateVideoTestimonialsForm()
    {
        $this->videoTestimonialsForm->bind(clone $this->getVideoTestimonialsPrototype());

        return $this->videoTestimonialsForm;
    }

    /**
     * Return edit videoTestimonials form
     *
     * @param  string          $videoTestimonialsId
     * @return VideoTestimonialsForm
     */
    public function getEditVideoTestimonialsForm($videoTestimonialsId)
    {
        $videoTestimonials = $this->videoTestimonialsRepository->find($videoTestimonialsId);

        $this->videoTestimonialsForm->bind($videoTestimonials);

        return $this->videoTestimonialsForm;
    }

    /**
     * Return videoTestimonials entity
     *
     * @param  string               $videoTestimonialsId
     * @return VideoTestimonialsInterface
     */
    public function getVideoTestimonials($videoTestimonialsId)
    {
        $videoTestimonials = $this->videoTestimonialsRepository->find($videoTestimonialsId);

        return $videoTestimonials;
    }

    /**
     * Creates a new videoTestimonials.
     *
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|VideoTestimonialsInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->videoTestimonialsForm->bind(clone $this->getVideoTestimonialsPrototype());
        $this->videoTestimonialsForm->setData($data);

        if (!$this->videoTestimonialsForm->isValid()) {

        	//print_r($this->videoTestimonialsForm->getMessages()); //error messages
        	//exit;
            return null;
        }

        $videoTestimonials = $this->videoTestimonialsForm->getData();

        if (!$videoTestimonials instanceof VideoTestimonialsInterface) {
            throw Exception\UnexpectedValueException::invalidVideoTestimonialsEntity($videoTestimonials);
        }

        $videoTestimonials->setCreatedAt(new DateTime('now'))
            	  ->setCreatedBy($identity->getUsername())
            	  ->setDeleted(false);;

        $this->objectManager->persist($videoTestimonials);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new VideoTestimonialsEvent('videoTestimonialsCreated', $videoTestimonials));

        return $videoTestimonials;
    }

    /**
     * Edit an existing videoTestimonials.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  VideoTestimonialsInterface               		  $videoTestimonials
     * @throws Exception\UnexpectedValueException
     * @return null|VideoTestimonialsInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, VideoTestimonialsInterface $videoTestimonials)
    {
        $this->videoTestimonialsForm->bind(clone $this->getVideoTestimonialsPrototype());
        $this->videoTestimonialsForm->setData($data);

        if (!$this->videoTestimonialsForm->isValid()) {
            return null;
        }

        $videoTestimonials = $this->videoTestimonialsForm->getData();

        if (!$videoTestimonials instanceof VideoTestimonialsInterface) {
            throw Exception\UnexpectedValueException::invalidVideoTestimonialsEntity($videoTestimonials);
        }

        $videoTestimonials->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new VideoTestimonialsEvent('videoTestimonialsEdited', $videoTestimonials));

        return $videoTestimonials;
    }

    /**
     * Delete an existing videoTestimonials.
     *
     * @param  UserInterface                      $identity
     * @param  VideoTestimonialsInterface               		  $videoTestimonials
     * @throws Exception\UnexpectedValueException
     * @return null|VideoTestimonialsInterface
     */
    public function delete(UserInterface $identity, VideoTestimonialsInterface $videoTestimonials)
    {
        if (!$videoTestimonials instanceof VideoTestimonialsInterface) {
            throw Exception\UnexpectedValueException::invalidVideoTestimonialsEntity($videoTestimonials);
        }

        $videoTestimonials->setModifiedAt(new DateTime('now'))
            	  ->setModifiedBy($identity->getUsername())
            	  ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new VideoTestimonialsEvent('videoTestimonialsDeleted', $videoTestimonials));

        return $videoTestimonials;
    }

    /**
     * @return VideoTestimonialsInterface
     */
    public function getVideoTestimonialsPrototype()
    {
        if ($this->videoTestimonialsPrototype === null) {
            $this->setVideoTestimonialsPrototype(new VideoTestimonials());
        }

        return $this->videoTestimonialsPrototype;
    }

    /**
     * @param  VideoTestimonialsInterface $videoTestimonialsPrototype
     * @return VideoTestimonialsService
     */
    public function setVideoTestimonialsPrototype(VideoTestimonialsInterface $videoTestimonialsPrototype)
    {
        $this->videoTestimonialsPrototype = $videoTestimonialsPrototype;

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
