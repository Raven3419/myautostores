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
use LundSite\Entity\FaqHeaders;
use LundSite\Entity\FaqHeadersInterface;
use LundSite\Repository\FaqHeadersRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\FaqHeadersForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of faqHeaders.
 */
class FaqHeadersService implements EventManagerAwareInterface
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
     * @var FaqHeadersRepositoryInterface
     */
    protected $faqHeadersRepository;

    /**
     * @var FaqHeadersForm
     */
    protected $faqHeadersForm;

    /**
     * @var FaqHeadersInterface
     */
    protected $faqHeadersPrototype;

    /**
     * @param ObjectManager                  $objectManager
     * @param UserRepositoryInterface        $userRepository
     * @param SiteRepositoryInterface        $siteRepository
     * @param FaqHeadersRepositoryInterface 		 $faqHeadersRepository
     * @param FormInterface                  $faqHeadersForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        FaqHeadersRepositoryInterface $faqHeadersRepository
        //FormInterface $faqHeadersForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->faqHeadersRepository = $faqHeadersRepository;
        //$this->faqHeadersForm       = $faqHeadersForm;
    }

    /**
     * Return a list of active faqHeaders
     *
     * @return FaqHeadersInterface
     */
    public function getActiveFaqHeaders()
    {
        return $this->faqHeadersRepository->findBy(
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
     * Return a list of active faqHeaders by site
     *
     * @param  SiteInterface        $site
     * @return FaqHeadersInterface
     */
    public function getActiveFaqHeadersBySite(SiteInterface $site)
    {
        return $this->faqHeadersRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            )
        );
    }

    /**
     * Return a list of active faqHeaders by site and brand
     *
     * @param  SiteInterface        $site
     * @return FaqHeadersInterface
     */
    public function getActiveFaqHeadersBySiteBrand(SiteInterface $site, $brand)
    {
        return $this->faqHeadersRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
                'brand'    => $brand,
            )
        );
    }

    /**
     * Return a list of active faqHeaders by site
     *
     * @param  SiteInterface        $site
     * @return faqHeadersInterface
     */
    public function getActiveFaqHeadersBySiteAndBrand(SiteInterface $site, BrandsInterface $brand)
    {
        return $this->faqHeadersRepository->findBy(
            array(
                'deleted'  	=> false,
                'disabled' 	=> false,
                'site'     	=> $site->getSiteId(),
                'brand'     => $brand->getBrandId(),
            )
        );
    }

    /**
     * Return create faqHeaders form
     *
     * @return FaqHeadersForm
     */
    public function getCreateFaqHeadersForm()
    {
        $this->faqHeadersForm->bind(clone $this->getFaqHeadersPrototype());

        return $this->faqHeadersForm;
    }

    /**
     * Return edit FaqHeaders form
     *
     * @param  string          $faqHeadersId
     * @return FaqHeadersForm
     */
    public function getEditFaqHeadersForm($faqHeadersId)
    {
        $faqHeaders = $this->faqHeadersRepository->find($faqHeadersId);

        $this->faqHeadersForm->bind($faqHeaders);

        return $this->faqHeadersForm;
    }

    /**
     * Return faqHeaders entity
     *
     * @param  string               $faqHeadersId
     * @return FaqHeadersInterface
     */
    public function getFaqHeaders($faqHeadersId)
    {
        $faqHeaders = $this->faqHeadersRepository->find($faqHeadersId);

        return $faqHeaders;
    }

    /**
     * Creates a new faqHeaders.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|FaqHeadersInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->faqHeadersForm->bind(clone $this->getFaqHeadersPrototype());
        $this->faqHeadersForm->setData($data);

        if (!$this->faqHeadersForm->isValid()) {
            return null;
        }

        $faqHeaders = $this->faqHeadersForm->getData();

        if (!$faqHeaders instanceof FaqHeadersInterface) {
            throw Exception\UnexpectedValueException::invalidFaqHeadersEntity($faqHeaders);
        }

        $faqHeaders->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($faqHeaders);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new FaqHeadersEvent('faqHeadersCreated', $faqHeaders));

        return $faqHeaders;
    }

    /**
     * Edit an existing faqHeaders.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  FaqHeadersInterface               		  $faqHeaders
     * @throws Exception\UnexpectedValueException
     * @return null|FaqHeadersInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, FaqHeadersInterface $faqHeaders)
    {
        $this->faqHeadersForm->bind(clone $this->getFaqHeadersPrototype());
        $this->faqHeadersForm->setData($data);

        if (!$this->faqHeadersForm->isValid()) {
            return null;
        }

        $faqHeaders = $this->faqHeadersForm->getData();

        if (!$faqHeaders instanceof FaqHeadersInterface) {
            throw Exception\UnexpectedValueException::invalidFaqHeadersEntity($faqHeaders);
        }

        $faqHeaders->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new FaqHeadersEvent('faqHeadersEdited', $faqHeaders));

        return $faqHeaders;
    }

    /**
     * Delete an existing faqHeaders.
     *
     * @param  UserInterface                      $identity
     * @param  FaqHeadersInterface               		  $faqHeaders
     * @throws Exception\UnexpectedValueException
     * @return null|FaqHeadersInterface
     */
    public function delete(UserInterface $identity, FaqHeadersInterface $faqHeaders)
    {
        if (!$faqHeaders instanceof FaqHeadersInterface) {
            throw Exception\UnexpectedValueException::invalidFaqHeadersEntity($faqHeaders);
        }

        $faqHeaders->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new FaqHeadersEvent('faqHeadersDeleted', $faqHeaders));

        return $faqHeaders;
    }

    /**
     * @return FaqHeadersInterface
     */
    public function getFaqHeadersPrototype()
    {
        if ($this->faqHeadersPrototype === null) {
            $this->setFaqHeadersPrototype(new FaqHeaders());
        }

        return $this->faqHeadersPrototype;
    }

    /**
     * @param  FaqHeadersInterface $faqHeadersPrototype
     * @return FaqHeadersService
     */
    public function setFaqHeadersPrototype(FaqHeadersInterface $faqHeadersPrototype)
    {
        $this->faqHeadersPrototype = $faqHeadersPrototype;

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
