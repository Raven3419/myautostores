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
use LundSite\Entity\Showroom;
use LundSite\Entity\ShowroomInterface;
use LundSite\Repository\ShowroomRepositoryInterface;
use RocketUser\Repository\UserRepositoryInterface;
use RocketCms\Repository\SiteRepositoryInterface;
use LundSite\Form\ShowroomForm;
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
 * Service managing the management of showrooms.
 */
class ShowroomService implements EventManagerAwareInterface
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
     * @var ShowroomRepositoryInterface
     */
    protected $showroomRepository;

    /**
     * @var ShowroomForm
     */
    protected $showroomForm;

    /**
     * @var ShowroomInterface
     */
    protected $showroomPrototype;

    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @param ObjectManager                        $objectManager
     * @param UserRepositoryInterface              $userRepository
     * @param SiteRepositoryInterface              $siteRepository
     * @param ShowroomRepositoryInterface $showroomRepository
     * @param FormInterface                        $showroomForm
     * @param AssetService                         $assetService
     */
    public function __construct(
        ObjectManager $objectManager,
        UserRepositoryInterface $userRepository,
        SiteRepositoryInterface $siteRepository,
        ShowroomRepositoryInterface $showroomRepository,
        FormInterface $showroomForm,
        AssetService $assetService
    ) {
        $this->objectManager    = $objectManager;
        $this->userRepository   = $userRepository;
        $this->siteRepository   = $siteRepository;
        $this->showroomRepository = $showroomRepository;
        $this->showroomForm       = $showroomForm;
        $this->assetService     = $assetService;
    }

    /**
     * Return a list of active showrooms
     *
     * @return ShowroomInterface
     */
    public function getActiveShowrooms()
    {
        return $this->showroomRepository->findBy(
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
     * Return a list of active showrooms by site
     *
     * @param  SiteInterface              $site
     * @return ShowroomInterface
     */
    public function getActiveShowroomsBySite(SiteInterface $site)
    {
        return $this->showroomRepository->findBy(
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
     * Return create showroom form
     *
     * @return ShowroomForm
     */
    public function getCreateShowroomForm()
    {
        $this->showroomForm->bind(clone $this->getShowroomPrototype());

        return $this->showroomForm;
    }

    /**
     * Return edit showroom form
     *
     * @param  string                $showroomId
     * @return ShowroomForm
     */
    public function getEditShowroomForm($showroomId)
    {
        $showroom = $this->showroomRepository->find($showroomId);

        $this->showroomForm->bind($showroom);

        return $this->showroomForm;
    }

    /**
     * Return showroom entity
     *
     * @param  string                     $showroomId
     * @return ShowroomInterface
     */
    public function getShowroom($showroomId)
    {
        $showroom = $this->showroomRepository->find($showroomId);

        return $showroom;
    }

    /**
     * Creates a new showroom.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @throws Exception\UnexpectedValueException
     * @return null|ShowroomInterface
     */
    public function create(UserInterface $identity, \Zend\Stdlib\Parameters $data)
    {
        $this->showroomForm->bind(clone $this->getShowroomPrototype());
        $this->showroomForm->setData($data);

        if (!$this->showroomForm->isValid()) {
            return null;
        }

        $showroom = $this->showroomForm->getData();

        if (!$showroom instanceof ShowroomInterface) {
            throw Exception\UnexpectedValueException::invalidShowroomEntity($showroom);
        }

        $showroom->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($showroom);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ShowroomEvent('showroomCreated', $showroom));

        return $showroom;
    }

    /**
     * Creates a new showroom.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param array                               $files
     * @param SiteInterface                       $site
     * @throws Exception\UnexpectedValueException
     * @return null|ShowroomInterface
     */
    public function createFront(UserInterface $identity, \Zend\Stdlib\Parameters $data, $files = array(), SiteInterface $site)
    {
        $showroom = clone $this->getShowroomPrototype();

        $filePath = dirname(__DIR__).'/../../../../public/assets/library/cms/showroom';
        $fileName = date('YmdHis').$files['imagefiles']['name'];
        $filter = new \Zend\Filter\File\Rename($filePath . '/' . $fileName);
        $adapter = new \Zend\File\Transfer\Adapter\Http();
        $adapter->addFilter($filter);
        $adapter->setDestination(dirname(__DIR__).'/../../../../public/assets/library/cms/showroom');
        $adapter->receive($files['imagefiles']['name']);

        $file = new SplFileInfo($filePath .'/' . $fileName);

        $path = $file->getPath();
        $fileName = $file->getFilename();
        $fullPath = $file->getPathname();
        $size = $file->getSize();
        $mtime = $file->getMTime();
        $ext = strtolower($file->getExtension());
        $finfo = finfo_open(FILEINFO_MIME);
        $mimeArr = explode(';', finfo_file($finfo, $fullPath));
        $mime = $mimeArr[0];
        finfo_close($finfo);
        $dimensions = getimagesize($fullPath);

        $stat = array(
            'size' => $size,
            'mime' => $mime,
            'ext'  => $ext,
            'filetype' => 'file',
            'width' => $dimensions[0],
            'height' => $dimensions[1]);

        $hashPath = 'library/cms/showroom/'.$fileName;
        $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
        $hash = rtrim($hash, '.');
        $hash = 'l1_'.$hash;

        $asset = $this->assetService->getAssetPrototype();;
        $asset = $this->assetService->saveFile('library/cms/showroom', $fileName, $stat, $hash);

        $showroom->setFirstName($data->get('firstname'));
        $showroom->setLastName($data->get('lastname'));
        $showroom->setEmailAddress($data->get('email'));
        $showroom->setComments($data->get('story'));
        if ($data->get('truck')) {
            $showroom->setHaveTruck(true);
        } else {
            $showroom->setHaveTruck(false);
        }
        if ($data->get('suv')) {
            $showroom->setHaveSuv(true);
        } else {
            $showroom->setHaveSuv(false);
        }
        if ($data->get('cuv')) {
            $showroom->setHaveCuv(true);
        } else {
            $showroom->setHaveCuv(false);
        }
        if ($data->get('van')) {
            $showroom->setHaveVan(true);
        } else {
            $showroom->setHaveVan(false);
        }
        if ($data->get('passengercar')) {
            $showroom->setHaveCar(true);
        } else {
            $showroom->setHaveCar(false);
        }
        $showroom->setDisabled(true);
        $showroom->setAsset($asset);
        $showroom->setOptin(true);
        $showroom->setSite($site);

        if (!$showroom instanceof ShowroomInterface) {
            throw Exception\UnexpectedValueException::invalidShowroomEntity($showroom);
        }

        $showroom->setCreatedAt(new DateTime('now'))
            ->setCreatedBy($identity->getUsername())
            ->setDeleted(false);

        $this->objectManager->persist($showroom);
        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ShowroomEvent('showroomCreated', $showroom));

        return $showroom;
    }

    /**
     * Edit an existing showroom.
     *
     * @param  UserInterface                      $identity
     * @param  \Zend\Stdlib\Parameters            $data
     * @param  ShowroomInterface         $showroom
     * @throws Exception\UnexpectedValueException
     * @return null|ShowroomInterface
     */
    public function edit(UserInterface $identity, \Zend\Stdlib\Parameters $data, ShowroomInterface $showroom)
    {
        $this->showroomForm->bind(clone $this->getShowroomPrototype());
        $this->showroomForm->setData($data);

        if (!$this->showroomForm->isValid()) {
            return null;
        }

        $showroom = $this->showroomForm->getData();

        if (!$showroom instanceof ShowroomInterface) {
            throw Exception\UnexpectedValueException::invalidShowroomEntity($showroom);
        }

        $showroom->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername());

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ShowroomEvent('showroomEdited', $showroom));

        return $showroom;
    }

    /**
     * Delete an existing showroom.
     *
     * @param  UserInterface                      $identity
     * @param  ShowroomInterface         $showroom
     * @throws Exception\UnexpectedValueException
     * @return null|ShowroomInterface
     */
    public function delete(UserInterface $identity, ShowroomInterface $showroom)
    {
        if (!$showroom instanceof ShowroomInterface) {
            throw Exception\UnexpectedValueException::invalidShowroomEntity($showroom);
        }

        $showroom->setModifiedAt(new DateTime('now'))
            ->setModifiedBy($identity->getUsername())
            ->setDeleted(true);

        $this->objectManager->flush();

        $this->getEventManager()->trigger(new ShowroomEvent('showroomDeleted', $showroom));

        return $showroom;
    }

    /**
     * @return ShowroomInterface
     */
    public function getShowroomPrototype()
    {
        if ($this->showroomPrototype === null) {
            $this->setShowroomPrototype(new Showroom());
        }

        return $this->showroomPrototype;
    }

    /**
     * @param  ShowroomInterface $showroomPrototype
     * @return ShowroomService
     */
    public function setShowroomPrototype(ShowroomInterface $showroomPrototype)
    {
        $this->showroomPrototype = $showroomPrototype;

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
