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
use LundSite\Entity\SpecialOffers;
use LundSite\Entity\SpecialOffersInterface;
use LundSite\Repository\SpecialOffersRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\SpecialOffersForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;

/**
 * Service managing the management of specialOffers.
 */
class SpecialOffersService implements EventManagerAwareInterface
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
     * @var SpecialOffersRepositoryInterface
     */
    protected $specialOffersRepository;

    /**
     * @var SpecialOffersForm
     */
    protected $specialOffersForm;

    /**
     * @var SpecialOffersInterface
     */
    protected $specialOffersPrototype;

    /**
     * @param ObjectManager                  	$objectManager
     * @param UserRepositoryInterface        	$userRepository
     * @param SiteRepositoryInterface        	$siteRepository
     * @param SpecialOffersRepositoryInterface 	$specialOffersRepository
     * @param FormInterface                  	$specialOffersForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        SpecialOffersRepositoryInterface $specialOffersRepository,
        FormInterface $specialOffersForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->specialOffersRepository = $specialOffersRepository;
        $this->specialOffersForm       = $specialOffersForm;
    }

    /**
     * Return a list of active specialOffers
     *
     * @return SpecialOffersInterface
     */
    public function getActiveSpecialOffers()
    {
        return $this->specialOffersRepository->findBy(
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
     * Return a list of active specialOffers by site
     *
     * @param  SiteInterface        $site
     * @return SpecialOffersInterface
     */
    public function getActiveSpecialOffersBySite(SiteInterface $site)
    {
        return $this->specialOffersRepository->findBy(
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
     * Return a list of active specialOffers by site
     *
     * @param  SiteInterface        $site
     * @return SpecialOffersInterface
     */
    public function getSpecialOffersByBrand(SiteInterface $site, $brand)
    {
        return $this->specialOffersRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            	'brand'    => $brand
            ),
            array(
                'createdAt'   => 'DESC',
            )
        );
    }

    /**
     * Return create specialOffers form
     *
     * @return SpecialOffersForm
     */
    public function getCreateSpecialOffersForm()
    {
        $this->specialOffersForm->bind(clone $this->getSpecialOffersPrototype());

        return $this->specialOffersForm;
    }

    /**
     * Return edit specialOffers form
     *
     * @param  string          $specialOffersId
     * @return SpecialOffersForm
     */
    public function getEditSpecialOffersForm($specialOffersId)
    {
        $specialOffers = $this->specialOffersRepository->find($specialOffersId);

        $this->specialOffersForm->bind($specialOffers);

        return $this->specialOffersForm;
    }

    /**
     * Return specialOffers entity
     *
     * @param  string               $specialOffersId
     * @return SpecialOffersInterface
     */
    public function getSpecialOffers($specialOffersId)
    {
        $specialOffers = $this->specialOffersRepository->find($specialOffersId);

        return $specialOffers;
    }

    /**
     * Creates a new specialOffers.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|SpecialOffersInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->specialOffersForm->bind(clone $this->getSpecialOffersPrototype());
        $this->specialOffersForm->setData($data);

        if (!$this->specialOffersForm->isValid()) {
            return null;
        }

        $specialOffers = $this->specialOffersForm->getData();

        if (!$specialOffers instanceof SpecialOffersInterface) {
            throw Exception\UnexpectedValueException::invalidSpecialOffersEntity($specialOffers);
        }

        $specialOffers->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($specialOffers);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SpecialOffersEvent('specialOffersCreated', $specialOffers));

        return $specialOffers;
    }

    /**
     * Edit an existing specialOffers.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  SpecialOffersInterface               $specialOffers
     * @throws Exception\UnexpectedValueException
     * @return null|SpecialOffersInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, SpecialOffersInterface $specialOffers)
    {
        $this->specialOffersForm->bind(clone $this->getSpecialOffersPrototype());
        $this->specialOffersForm->setData($data);

        if (!$this->specialOffersForm->isValid()) {
            return null;
        }

        $specialOffers = $this->specialOffersForm->getData();

        if (!$specialOffers instanceof SpecialOffersInterface) {
            throw Exception\UnexpectedValueException::invalidSpecialOffersEntity($specialOffers);
        }

        $specialOffers->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SpecialOffersEvent('specialOffersEdited', $specialOffers));

        return $specialOffers;
    }

    /**
     * Delete an existing specialOffers.
     *
     * @param  UserInterface                      $identity
     * @param  SpecialOffersInterface               $specialOffers
     * @throws Exception\UnexpectedValueException
     * @return null|SpecialOffersInterface
     */
    public function delete(UserInterface $identity, SpecialOffersInterface $specialOffers)
    {
        if (!$specialOffers instanceof SpecialOffersInterface) {
            throw Exception\UnexpectedValueException::invalidSpecialOffersEntity($specialOffers);
        }

        $specialOffers->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new SpecialOffersEvent('specialOffersDeleted', $specialOffers));

        return $specialOffers;
    }

    /**
     * @return SpecialOffersInterface
     */
    public function getSpecialOffersPrototype()
    {
        if ($this->specialOffersPrototype === null) {
            $this->setSpecialOffersPrototype(new SpecialOffers());
        }

        return $this->specialOffersPrototype;
    }

    /**
     * @param  SpecialOffersInterface $specialOffersPrototype
     * @return SpecialOffersService
     */
    public function setSpecialOffersPrototype(SpecialOffersInterface $specialOffersPrototype)
    {
        $this->specialOffersPrototype = $specialOffersPrototype;

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
