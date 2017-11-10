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
use LundSite\Entity\NewsRelease;
use LundSite\Entity\NewsReleaseInterface;
use LundSite\Repository\NewsReleaseRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\NewsReleaseForm;
use LundSite\Exception;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Form\FormInterface;
use DateTime;
use LundProducts\Entity\BrandsInterface;

/**
 * Service managing the management of newsReleases.
 */
class NewsReleaseService implements EventManagerAwareInterface
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
     * @var NewsReleaseRepositoryInterface
     */
    protected $newsReleaseRepository;

    /**
     * @var NewsReleaseForm
     */
    protected $newsReleaseForm;

    /**
     * @var NewsReleaseInterface
     */
    protected $newsReleasePrototype;

    /**
     * @param ObjectManager                  $objectManager
     * @param UserRepositoryInterface        $userRepository
     * @param SiteRepositoryInterface        $siteRepository
     * @param NewsReleaseRepositoryInterface $newsReleaseRepository
     * @param FormInterface                  $newsReleaseForm
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        NewsReleaseRepositoryInterface $newsReleaseRepository,
        FormInterface $newsReleaseForm
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->newsReleaseRepository = $newsReleaseRepository;
        $this->newsReleaseForm       = $newsReleaseForm;
    }

    /**
     * Return a list of active newsReleases
     *
     * @return NewsReleaseInterface
     */
    public function getActiveNewsReleases()
    {
        return $this->newsReleaseRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
            ),
            array(
                'displayDate'   => 'ASC',
            )
        );
    }

    /**
     * Return a list of active newsReleases by site
     *
     * @param  SiteInterface        $site
     * @return NewsReleaseInterface
     */
    public function getActiveNewsReleasesBySite(SiteInterface $site)
    {
        return $this->newsReleaseRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            ),
            array(
                'displayDate'   => 'DESC',
            )
        );
    }

    /**
     * Return a list of active newsReleases by site
     *
     * @param  SiteInterface        $site
     * @return NewsReleaseInterface
     */
    public function getActiveNewsReleasesBySiteBrand(SiteInterface $site, $brand)
    {
        return $this->newsReleaseRepository->findBy(
            array(
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            	'brand'  	=> $brand
            ),
            array(
                'displayDate'   => 'DESC',
            )
        );
    }

    /**
     * Return a list of active newsReleases by site
     *
     * @param  SiteInterface        $site
     * @return NewsReleaseInterface
     */
    public function getActiveNewsReleasesBySiteAndBrand(SiteInterface $site, BrandsInterface $brand)
    {
        return $this->newsReleaseRepository->findBy(
            array(
                'deleted'  	=> false,
                'disabled' 	=> false,
                'site'     	=> $site->getSiteId(),
                'brand'     => $brand->getBrandId(),
            ),
            array(
                'displayDate'   => 'DESC',
            )
        );
    }

    /**
     * Return specific news release based on url
     *
     * @param SiteInterface $site
     * @param string $url
     * @return NewsReleaseInterface|null
     */
    public function getNewsReleaseByUrl(SiteInterface $site, $url = null)
    {
        return $this->newsReleaseRepository->findOneBy(
            array(
                'url'      => $url,
                'deleted'  => false,
                'disabled' => false,
                'site'     => $site->getSiteId(),
            )
        );
    }

    /**
     * Return create newsRelease form
     *
     * @return NewsReleaseForm
     */
    public function getCreateNewsReleaseForm()
    {
        $this->newsReleaseForm->bind(clone $this->getNewsReleasePrototype());

        return $this->newsReleaseForm;
    }

    /**
     * Return edit newsRelease form
     *
     * @param  string          $newsReleaseId
     * @return NewsReleaseForm
     */
    public function getEditNewsReleaseForm($newsReleaseId)
    {
        $newsRelease = $this->newsReleaseRepository->find($newsReleaseId);

        $this->newsReleaseForm->bind($newsRelease);

        return $this->newsReleaseForm;
    }

    /**
     * Return newsRelease entity
     *
     * @param  string               $newsReleaseId
     * @return NewsReleaseInterface
     */
    public function getNewsRelease($newsReleaseId)
    {
        $newsRelease = $this->newsReleaseRepository->find($newsReleaseId);

        return $newsRelease;
    }

    /**
     * Creates a new newsRelease.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|NewsReleaseInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->newsReleaseForm->bind(clone $this->getNewsReleasePrototype());
        $this->newsReleaseForm->setData($data);

        if (!$this->newsReleaseForm->isValid()) {
            return null;
        }

        $newsRelease = $this->newsReleaseForm->getData();

        if (!$newsRelease instanceof NewsReleaseInterface) {
            throw Exception\UnexpectedValueException::invalidNewsReleaseEntity($newsRelease);
        }

        $newsRelease->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($newsRelease);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new NewsReleaseEvent('newsReleaseCreated', $newsRelease));

        return $newsRelease;
    }

    /**
     * Edit an existing newsRelease.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  NewsReleaseInterface               $newsRelease
     * @throws Exception\UnexpectedValueException
     * @return null|NewsReleaseInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, NewsReleaseInterface $newsRelease)
    {
        $this->newsReleaseForm->bind(clone $this->getNewsReleasePrototype());
        $this->newsReleaseForm->setData($data);

        if (!$this->newsReleaseForm->isValid()) {
            return null;
        }

        $newsRelease = $this->newsReleaseForm->getData();

        if (!$newsRelease instanceof NewsReleaseInterface) {
            throw Exception\UnexpectedValueException::invalidNewsReleaseEntity($newsRelease);
        }

        $newsRelease->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new NewsReleaseEvent('newsReleaseEdited', $newsRelease));

        return $newsRelease;
    }

    /**
     * Delete an existing newsRelease.
     *
     * @param  UserInterface                      $identity
     * @param  NewsReleaseInterface               $newsRelease
     * @throws Exception\UnexpectedValueException
     * @return null|NewsReleaseInterface
     */
    public function delete(UserInterface $identity, NewsReleaseInterface $newsRelease)
    {
        if (!$newsRelease instanceof NewsReleaseInterface) {
            throw Exception\UnexpectedValueException::invalidNewsReleaseEntity($newsRelease);
        }

        $newsRelease->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new NewsReleaseEvent('newsReleaseDeleted', $newsRelease));

        return $newsRelease;
    }

    /**
     * @return NewsReleaseInterface
     */
    public function getNewsReleasePrototype()
    {
        if ($this->newsReleasePrototype === null) {
            $this->setNewsReleasePrototype(new NewsRelease());
        }

        return $this->newsReleasePrototype;
    }

    /**
     * @param  NewsReleaseInterface $newsReleasePrototype
     * @return NewsReleaseService
     */
    public function setNewsReleasePrototype(NewsReleaseInterface $newsReleasePrototype)
    {
        $this->newsReleasePrototype = $newsReleasePrototype;

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
