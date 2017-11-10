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
use LundSite\Entity\Slider;
use LundSite\Entity\SliderInterface;
use LundSite\Repository\SliderRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\SliderForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use SPLFileInfo,
    SPLFileObject;
use RocketDam\Service\AssetService;

/**
 * Service managing the management of sliders.
 */
class SliderService implements EventManagerAwareInterface
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
     * @var SliderRepositoryInterface
     */
    protected $sliderRepository;

    /**
     * @var SliderForm
     */
    protected $sliderForm;

    /**
     * @var SliderInterface
     */
    protected $sliderPrototype;

    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @param ObjectManager                        $objectManager
     * @param UserRepositoryInterface              $userRepository
     * @param SiteRepositoryInterface              $siteRepository
     * @param SliderRepositoryInterface $sliderRepository
     * @param FormInterface                        $sliderForm
     * @param AssetService                         $assetService
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        SliderRepositoryInterface $sliderRepository,
        FormInterface $sliderForm,
        AssetService $assetService
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->sliderRepository = $sliderRepository;
        $this->sliderForm       = $sliderForm;
        $this->assetService     = $assetService;
    }

    /**
     * Return a list of active sliders
     *
     * @return SliderInterface
     */
    public function getActiveSliders()
    {
        return $this->sliderRepository->findBy(
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
     * Return a list of sliders
     *
     * @return SliderInterface
     */
    public function getAllSliders()
    {
        return $this->sliderRepository->findBy(
            array('disabled' => false,),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return slider by position
     *
     * @param integer $position
     * @return SliderInterface
     */
    public function getSliderByPosition($position = null)
    {
        return $this->sliderRepository->findOneBy(
            array(
                'position' => $position,
            )
        );
    }

    /**
     * Return max position
     *
     * @return SliderInterface
     */
    public function getMaxPosition()
    {
        $dql = 'SELECT MAX(r.position) FROM LundSite\Entity\Slider r';
        $q = $this->objectManager->createQuery($dql);

        return $q->getSingleScalarResult();
    }

    /**
     * Return a list of active sliders by site
     *
     * @param  SiteInterface              $site
     * @return SliderInterface
     */
    public function getActiveSlidersBySite(SiteInterface $site)
    {
        return $this->sliderRepository->findBy(
            array(
                'deleted'  	=> false,
                'disabled' 	=> false,
                'site'     	=> $site->getSiteId(),
            	'brand'  	=> NULL
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return a list of active sliders by site
     *
     * @param  SiteInterface              $site
     * @return SliderInterface
     */
    public function getActiveSlidersBySiteBrand(SiteInterface $site, $brand)
    {
        return $this->sliderRepository->findBy(
            array(
                'deleted'  	=> false,
                'disabled' 	=> false,
                'site'    	 => $site->getSiteId(),
            	'brand'  	=> $brand
            ),
            array(
                'position' => 'ASC',
            )
        );
    }

    /**
     * Return create slider form
     *
     * @return SliderForm
     */
    public function getCreateSliderForm()
    {
        $this->sliderForm->bind(clone $this->getSliderPrototype());

        return $this->sliderForm;
    }

    /**
     * Return edit slider form
     *
     * @param  string                $sliderId
     * @return SliderForm
     */
    public function getEditSliderForm($sliderId)
    {
        $slider = $this->sliderRepository->find($sliderId);

        $this->sliderForm->bind($slider);

        return $this->sliderForm;
    }

    /**
     * Return slider entity
     *
     * @param  string                     $sliderId
     * @return SliderInterface
     */
    public function getSlider($sliderId)
    {
        $slider = $this->sliderRepository->find($sliderId);

        return $slider;
    }

    /**
     * Creates a new slider.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|SliderInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->sliderForm->bind(clone $this->getSliderPrototype());
        $this->sliderForm->setData($data);

        if (!$this->sliderForm->isValid()) {
            return null;
        }

        $slider = $this->sliderForm->getData();

        if (!$slider instanceof SliderInterface) {
            throw Exception\UnexpectedValueException::invalidSliderEntity($slider);
        }

        $replacedSlider = $this->getSliderByPosition($slider->getPosition());

        if (null != $replacedSlider) {
            $this->rankDownSlider($identity, $replacedSlider);
        }

        $slider->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($slider);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SliderEvent('sliderCreated', $slider));

        return $slider;
    }

    /**
     * Edit an existing slider.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  SliderInterface         $slider
     * @throws Exception\UnexpectedValueException
     * @return null|SliderInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, SliderInterface $slider)
    {
        $this->sliderForm->bind(clone $this->getSliderPrototype());
        $this->sliderForm->setData($data);

        if (!$this->sliderForm->isValid()) {
            return null;
        }

        $slider = $this->sliderForm->getData();

        if (!$slider instanceof SliderInterface) {
            throw Exception\UnexpectedValueException::invalidSliderEntity($slider);
        }

        $replacedSlider = $this->getSliderByPosition($slider->getPosition());

        if (null != $replacedSlider) {
            if ($replacedSlider->getSliderId() != $slider->getSliderId()) {
                $this->rankDownSlider($identity, $replacedSlider);
            }
        }

        $slider->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SliderEvent('sliderEdited', $slider));

        return $slider;
    }

    /**
     * Rank up an existing slider
     *
     * @param UserInterface   $identity
     * @param SliderInterface $slider
     * @throws Exception\UnexpectedValueException
     * @returns null|SliderInterface
     */
    public function rankUpSlider(UserInterface $identity, SliderInterface $slider)
    {
        $currentRank = $slider->getPosition();
        $newRank     = $slider->getPosition()-1;

        $otherSliders = $this->getAllSliders();

        foreach ($otherSliders as $otherSlider) {
            if ($otherSlider->getSliderId() != $slider->getSliderId()) {
                if ($otherSlider->getPosition() == $newRank) {
                    $newOtherRank = $otherSlider->getPosition()+1;
                    $otherSlider->setPosition($newOtherRank)
                        ->setModifiedAt(new DateTime('now'))
                        ->setModifiedBy($identity->getUsername());
                    $this->objectManager->flush();
                    $this->getEventManager()->trigger(new SliderEvent('sliderEdited', $otherSlider));
                }
            } else {
                $slider->setPosition($newRank)
                    ->setModifiedAt(new DateTime('now'))
                    ->setModifiedBy($identity->getUsername());
                $this->objectManager->flush();
                $this->getEventManager()->trigger(new SliderEvent('sliderEdited', $slider));
            }
        }

        return true;
    }

    /**
     * Rank down an existing slider
     *
     * @param UserInterface   $identity
     * @param SliderInterface $slider
     * @throws Exception\UnexpectedValueException
     * @returns null|SliderInterface
     */
    public function rankDownSlider(UserInterface $identity, SliderInterface $slider)
    {
        $currentRank = $slider->getPosition();
        $newRank     = $slider->getPosition()+1;

        $otherSliders = $this->getAllSliders();

        foreach ($otherSliders as $otherSlider) {
            if ($otherSlider->getSliderId() != $slider->getSliderId()) {
                if ($otherSlider->getPosition() == $newRank) {
                    $newOtherRank = $otherSlider->getPosition()-1;
                    $otherSlider->setPosition($newOtherRank)
                        ->setModifiedAt(new DateTime('now'))
                        ->setModifiedBy($identity->getUsername());
                    $this->objectManager->flush();
                    $this->getEventManager()->trigger(new SliderEvent('sliderEdited', $otherSlider));
                }
            } else {
                $slider->setPosition($newRank)
                    ->setModifiedAt(new DateTime('now'))
                    ->setModifiedBy($identity->getUsername());
                $this->objectManager->flush();
                $this->getEventManager()->trigger(new SliderEvent('sliderEdited', $slider));
            }
        }

        return true;
    }

    /**
     * Delete an existing slider.
     *
     * @param  UserInterface                      $identity
     * @param  SliderInterface         $slider
     * @throws Exception\UnexpectedValueException
     * @return null|SliderInterface
     */
    public function delete(UserInterface $identity, SliderInterface $slider)
    {
        if (!$slider instanceof SliderInterface) {
            throw Exception\UnexpectedValueException::invalidSliderEntity($slider);
        }

        $slider->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SliderEvent('sliderDeleted', $slider));

        return $slider;
    }

    /**
     * @return SliderInterface
     */
    public function getSliderPrototype()
    {
        if ($this->sliderPrototype === null) {
            $this->setSliderPrototype(new Slider());
        }

        return $this->sliderPrototype;
    }

    /**
     * @param  SliderInterface $sliderPrototype
     * @return SliderService
     */
    public function setSliderPrototype(SliderInterface $sliderPrototype)
    {
        $this->sliderPrototype = $sliderPrototype;

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
