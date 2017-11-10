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
use LundSite\Entity\Faq;
use LundSite\Entity\FaqInterface;
use LundSite\Repository\FaqRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\FaqForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of faq.
 */
class FaqService implements EventManagerAwareInterface
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
     * @var FaqRepositoryInterface
     */
    protected $faqRepository;

    /**
     * @var FaqForm
     */
    protected $faqForm;

    /**
     * @var FaqInterface
     */
    protected $faqPrototype;

    /**
     * @param ObjectManager                  $objectManager
     * @param UserRepositoryInterface        $userRepository
     * @param SiteRepositoryInterface        $siteRepository
     * @param FaqRepositoryInterface 		 $faqRepository
     * @param FormInterface                  $faqForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        FaqRepositoryInterface $faqRepository,
        FormInterface $faqForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->faqRepository = $faqRepository;
        $this->faqForm       = $faqForm;
    }

    /**
     * Return a list of active faq
     *
     * @return FaqInterface
     */
    public function getActiveFaq()
    {
        return $this->faqRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            )
        );
    }

    /**
     * Return a list of active faq by site
     *
     * @param  SiteInterface        $site
     * @return FaqInterface
     */
    public function getActiveFaqBySite(SiteInterface $site)
    {
        return $this->faqRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
                'brand'    => null,
            )
        );
    }

    /**
     * Return a list of active faq by site and brand
     *
     * @param  SiteInterface        $site
     * @return FaqInterface
     */
    public function getActiveFaqBySiteBrand(SiteInterface $site, $brand)
    {
        return $this->faqRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
                'brand'    => $brand,
            )
        );
    }

    /**
     * Return a list of active faq by site
     *
     * @param  SiteInterface        $site
     * @return faqInterface
     */
    public function getActiveFaqBySiteAndBrand(SiteInterface $site, BrandsInterface $brand)
    {
        return $this->faqRepository->findBy(
            array(
                'deleted'  	=> false,
                'disabled' 	=> false,
                'site'     	=> $site->getSiteId(),
                'brand'     => $brand->getBrandId(),
            )
        );
    }

    /**
     * Return create faq form
     *
     * @return FaqForm
     */
    public function getCreateFaqForm()
    {
        $this->faqForm->bind(clone $this->getFaqPrototype());

        return $this->faqForm;
    }

    /**
     * Return edit Faq form
     *
     * @param  string          $faqId
     * @return FaqForm
     */
    public function getEditFaqForm($faqId)
    {
        $faq = $this->faqRepository->find($faqId);

        $this->faqForm->bind($faq);

        return $this->faqForm;
    }

    /**
     * Return faq entity
     *
     * @param  string               $faqId
     * @return FaqInterface
     */
    public function getFaq($faqId)
    {
        $faq = $this->faqRepository->find($faqId);

        return $faq;
    }

    /**
     * Creates a new faq.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|FaqInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->faqForm->bind(clone $this->getFaqPrototype());
        $this->faqForm->setData($data);

        if (!$this->faqForm->isValid()) {
            return null;
        }

        $faq = $this->faqForm->getData();

        if (!$faq instanceof FaqInterface) {
            throw Exception\UnexpectedValueException::invalidFaqEntity($faq);
        }

        $faq->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($faq);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new FaqEvent('faqCreated', $faq));

        return $faq;
    }

    /**
     * Edit an existing faq.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  FaqInterface               		  $faq
     * @throws Exception\UnexpectedValueException
     * @return null|FaqInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, FaqInterface $faq)
    {
        $this->faqForm->bind(clone $this->getFaqPrototype());
        $this->faqForm->setData($data);

        if (!$this->faqForm->isValid()) {
            return null;
        }

        $faq = $this->faqForm->getData();

        if (!$faq instanceof FaqInterface) {
            throw Exception\UnexpectedValueException::invalidFaqEntity($faq);
        }

        $faq->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new FaqEvent('faqEdited', $faq));

        return $faq;
    }

    /**
     * Delete an existing faq.
     *
     * @param  UserInterface                      $identity
     * @param  FaqInterface               		  $faq
     * @throws Exception\UnexpectedValueException
     * @return null|FaqInterface
     */
    public function delete(UserInterface $identity, FaqInterface $faq)
    {
        if (!$faq instanceof FaqInterface) {
            throw Exception\UnexpectedValueException::invalidFaqEntity($faq);
        }

        $faq->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new FaqEvent('faqDeleted', $faq));

        return $faq;
    }

    /**
     * @return FaqInterface
     */
    public function getFaqPrototype()
    {
        if ($this->faqPrototype === null) {
            $this->setFaqPrototype(new Faq());
        }

        return $this->faqPrototype;
    }

    /**
     * @param  FaqInterface $faqPrototype
     * @return FaqService
     */
    public function setFaqPrototype(FaqInterface $faqPrototype)
    {
        $this->faqPrototype = $faqPrototype;

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
