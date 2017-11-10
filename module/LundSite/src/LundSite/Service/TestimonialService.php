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
use LundSite\Entity\Testimonial;
use LundSite\Entity\TestimonialInterface;
use LundSite\Repository\TestimonialRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\TestimonialForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use SPLFileInfo,
    SPLFileObject;

/**
 * Service managing the management of testimonials.
 */
class TestimonialService implements EventManagerAwareInterface
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
     * @var TestimonialRepositoryInterface
     */
    protected $testimonialRepository;

    /**
     * @var TestimonialForm
     */
    protected $testimonialForm;

    /**
     * @var TestimonialInterface
     */
    protected $testimonialPrototype;

    /**
     * @param ObjectManager                        $objectManager
     * @param UserRepositoryInterface              $userRepository
     * @param SiteRepositoryInterface              $siteRepository
     * @param TestimonialRepositoryInterface $testimonialRepository
     * @param FormInterface                        $testimonialForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        TestimonialRepositoryInterface $testimonialRepository,
        FormInterface $testimonialForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->testimonialRepository = $testimonialRepository;
        $this->testimonialForm       = $testimonialForm;
    }

    /**
     * Return a list of active testimonials
     *
     * @return TestimonialInterface
     */
    public function getActiveTestimonials()
    {
        return $this->testimonialRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return a list of testimonials
     *
     * @return TestimonialInterface
     */
    public function getAllTestimonials()
    {
        return $this->testimonialRepository->findBy(
            array(),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return testimonial by position
     *
     * @param integer $position
     * @return TestimonialInterface
     */
    public function getTestimonialByPosition($position = null)
    {
        return $this->testimonialRepository->findOneBy(
            array(
                'position' => $position,
            )
        );
    }

    /**
     * Return max position
     *
     * @return TestimonialInterface
     */
    public function getMaxPosition()
    {
        $dql = 'SELECT MAX(r.position) FROM LundSite\Entity\Testimonial r';
        $q = $this->objectManager->createQuery($dql);

        return $q->getSingleScalarResult();
    }

    /**
     * Return a list of active testimonials by site
     *
     * @param  SiteInterface              $site
     * @return TestimonialInterface
     */
    public function getActiveTestimonialsBySite(SiteInterface $site)
    {
        return $this->testimonialRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return create testimonial form
     *
     * @return TestimonialForm
     */
    public function getCreateTestimonialForm()
    {
        $this->testimonialForm->bind(clone $this->getTestimonialPrototype());

        return $this->testimonialForm;
    }

    /**
     * Return edit testimonial form
     *
     * @param  string                $testimonialId
     * @return TestimonialForm
     */
    public function getEditTestimonialForm($testimonialId)
    {
        $testimonial = $this->testimonialRepository->find($testimonialId);

        $this->testimonialForm->bind($testimonial);

        return $this->testimonialForm;
    }

    /**
     * Return testimonial entity
     *
     * @param  string                     $testimonialId
     * @return TestimonialInterface
     */
    public function getTestimonial($testimonialId)
    {
        $testimonial = $this->testimonialRepository->find($testimonialId);

        return $testimonial;
    }

    /**
     * Creates a new testimonial.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|TestimonialInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->testimonialForm->bind(clone $this->getTestimonialPrototype());
        $this->testimonialForm->setData($data);

        if (!$this->testimonialForm->isValid()) {
            return null;
        }

        $testimonial = $this->testimonialForm->getData();

        if (!$testimonial instanceof TestimonialInterface) {
            throw Exception\UnexpectedValueException::invalidTestimonialEntity($testimonial);
        }

        $replacedTestimonial = $this->getTestimonialByPosition($testimonial->getPosition());

        if (null != $replacedTestimonial) {
            $this->rankDownTestimonial($identity, $replacedTestimonial);
        }

        $testimonial->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($testimonial);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new TestimonialEvent('testimonialCreated', $testimonial));

        return $testimonial;
    }

    /**
     * Edit an existing testimonial.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  TestimonialInterface         $testimonial
     * @throws Exception\UnexpectedValueException
     * @return null|TestimonialInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, TestimonialInterface $testimonial)
    {
        $this->testimonialForm->bind(clone $this->getTestimonialPrototype());
        $this->testimonialForm->setData($data);

        if (!$this->testimonialForm->isValid()) {
            return null;
        }

        $testimonial = $this->testimonialForm->getData();

        if (!$testimonial instanceof TestimonialInterface) {
            throw Exception\UnexpectedValueException::invalidTestimonialEntity($testimonial);
        }

        $replacedTestimonial = $this->getTestimonialByPosition($testimonial->getPosition());

        if (null != $replacedTestimonial) {
            if ($replacedTestimonial->getTestimonialId() != $testimonial->getTestimonialId()) {
                $this->rankDownTestimonial($identity, $replacedTestimonial);
            }
        }

        $testimonial->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new TestimonialEvent('testimonialEdited', $testimonial));

        return $testimonial;
    }

    /**
     * Rank up an existing testimonial
     *
     * @param UserInterface   $identity
     * @param TestimonialInterface $testimonial
     * @throws Exception\UnexpectedValueException
     * @returns null|TestimonialInterface
     */
    public function rankUpTestimonial(UserInterface $identity, TestimonialInterface $testimonial)
    {
        $currentRank = $testimonial->getPosition();
        $newRank     = $testimonial->getPosition()-1;

        $otherTestimonials = $this->getAllTestimonials();

        foreach ($otherTestimonials as $otherTestimonial) {
            if ($otherTestimonial->getTestimonialId() != $testimonial->getTestimonialId()) {
                if ($otherTestimonial->getPosition() == $newRank) {
                    $newOtherRank = $otherTestimonial->getPosition()+1;
                    $otherTestimonial->setPosition($newOtherRank)
                        ->setModifiedAt(new DateTime('now'))
                        ->setModifiedBy($identity->getUsername());
                    $this->objectManager->flush();
                    $this->getEventManager()->trigger(new TestimonialEvent('testimonialEdited', $otherTestimonial));
                }
            } else {
                $testimonial->setPosition($newRank)
                    ->setModifiedAt(new DateTime('now'))
                    ->setModifiedBy($identity->getUsername());
                $this->objectManager->flush();
                $this->getEventManager()->trigger(new TestimonialEvent('testimonialEdited', $testimonial));
            }
        }

        return true;
    }

    /**
     * Rank down an existing testimonial
     *
     * @param UserInterface   $identity
     * @param TestimonialInterface $testimonial
     * @throws Exception\UnexpectedValueException
     * @returns null|TestimonialInterface
     */
    public function rankDownTestimonial(UserInterface $identity, TestimonialInterface $testimonial)
    {
        $currentRank = $testimonial->getPosition();
        $newRank     = $testimonial->getPosition()+1;

        $otherTestimonials = $this->getAllTestimonials();

        foreach ($otherTestimonials as $otherTestimonial) {
            if ($otherTestimonial->getTestimonialId() != $testimonial->getTestimonialId()) {
                if ($otherTestimonial->getPosition() == $newRank) {
                    $newOtherRank = $otherTestimonial->getPosition()-1;
                    $otherTestimonial->setPosition($newOtherRank)
                        ->setModifiedAt(new DateTime('now'))
                        ->setModifiedBy($identity->getUsername());
                    $this->objectManager->flush();
                    $this->getEventManager()->trigger(new TestimonialEvent('testimonialEdited', $otherTestimonial));
                }
            } else {
                $testimonial->setPosition($newRank)
                    ->setModifiedAt(new DateTime('now'))
                    ->setModifiedBy($identity->getUsername());
                $this->objectManager->flush();
                $this->getEventManager()->trigger(new TestimonialEvent('testimonialEdited', $testimonial));
            }
        }

        return true;
    }

    /**
     * Delete an existing testimonial.
     *
     * @param  UserInterface                      $identity
     * @param  TestimonialInterface         $testimonial
     * @throws Exception\UnexpectedValueException
     * @return null|TestimonialInterface
     */
    public function delete(UserInterface $identity, TestimonialInterface $testimonial)
    {
        if (!$testimonial instanceof TestimonialInterface) {
            throw Exception\UnexpectedValueException::invalidTestimonialEntity($testimonial);
        }

        $testimonial->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new TestimonialEvent('testimonialDeleted', $testimonial));

        return $testimonial;
    }

    /**
     * @return TestimonialInterface
     */
    public function getTestimonialPrototype()
    {
        if ($this->testimonialPrototype === null) {
            $this->setTestimonialPrototype(new Testimonial());
        }

        return $this->testimonialPrototype;
    }

    /**
     * @param  TestimonialInterface $testimonialPrototype
     * @return TestimonialService
     */
    public function setTestimonialPrototype(TestimonialInterface $testimonialPrototype)
    {
        $this->testimonialPrototype = $testimonialPrototype;

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
