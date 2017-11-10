<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use Zend\EventManager\Eventmanager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LundProducts\Entity\Promo;
use LundProducts\Entity\PromoInterface;
use LundProducts\Repository\PromoRepositoryInterface;
use LundProducts\Repository\PartVehCollectionRepositoryInterface;
use LundProducts\Repository\PartsRepositoryInterface;
use LundProducts\Service\ParseMasterService;
use LundProducts\Repository\VehCollectionRepositoryInterface;
use LundProducts\Service\ParseSupplementService;
use LundProducts\Service\BrandsService;
use RocketAdmin\Service\AuditService;
use Doctrine\ORM\EntityManager;
use RocketUser\Entity\User;
use DateTime;
use LundProducts\Service\ProductLineService;
use LundProducts\Repository\BrandsRepository;

/*
 * Service managing the CRUD of promo.
 */
class PromoService implements EventManagerAwareInterface
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
     * @var PromoRepositoryInterface ObjectRepository
     */
    protected $repository;

    /**
     * @var PartsRepositoryInterface ObjectRepository
     */
    protected $partsRepository;

    /**
     * @var ParseMasterService
     */
    protected $masterService;

    /**
     * @var ParseSupplementService
     */
    protected $supplementService;

    /**
     * @var PromoService
     */
    protected $promoService;

    /**
     * @var PartVehCollectionRepositoryInterface
     */
    protected $partVehCollectionRepository;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var VehCollectionRepositoryInterface
     */
    protected $vehCollectionRepository;

    /**
     * @var AuditService
     */
    protected $auditService;

    /**
     * @var ProductLineService
     */
    protected $productLineService;

    /**
     * @var BrandService
     */
    protected $brandsService;

    /**
     * @param ObjectManager                        $objectManager
     * @param PromoRepositoryInterface        $repository
     * @param PartsRepositoryInterface             $partsRepository
     * @param ParseMasterService                   $masterService
     * @param ParseSupplementService               $supplementService
     * @param PromoService                         $promoService
     * @param PartVehCollectionRepositoryInterface $partVehCollectionRepository
     * @param VehCollectionRepositoryInterface     $vehCollectionRepository
     * @param AuditService                         $auditService
     * @param BrandsRepository                     $brandsRepository
     * @param ProductLineService                   $productLineService
     */
    public function __construct(ObjectManager                        $objectManager,
                                PromoRepositoryInterface             $repository,
                                PartsRepositoryInterface             $partsRepository,
                                ParseMasterService                   $masterService,
                                ParseSupplementService               $supplementService,
                                PartVehCollectionRepositoryInterface $partVehCollectionRepository,
                                EntityManager                        $entityManager,
                                VehCollectionRepositoryInterface     $vehCollectionRepository,
                                AuditService                         $auditService,
                                BrandsRepository                  	 $brandsRepository,
                                ProductLineService                   $productLineService)
    {
        $this->objectManager                   = $objectManager;
        $this->repository                      = $repository;
        $this->partsRepository                 = $partsRepository;
        $this->masterService                   = $masterService;
        $this->supplementService               = $supplementService;
        $this->partVehCollectionRepository     = $partVehCollectionRepository;
        $this->entityManager                   = $entityManager;
        $this->vehCollectionRepository         = $vehCollectionRepository;
        $this->auditService                    = $auditService;
        $this->brandsRepository                = $brandsRepository;
        $this->productLineService              = $productLineService;
    }

    /**
     * @return mixed
     */
    public function getActivePromo($promoNumber=null, $promoLine=null)
    {
        return $this->repository->findBy(
            array('deleted'     => false,
                  'disabled'    => false,
                  'promoNumber' => $promoNumber,
                  'promoLine'   => $promoLine,
                 ),
            array('promoId' => 'ASC')
        );
    }

    /**
     * @param integer $recordId
     *
     * @return PromoInterface
     */
    public function getPromo($recordId)
    {
        return $this->repository->find($recordId);
    }

    /**
     * @param \LundProducts\Entity\Promo $recordEntity
     * @param \RocketUser\Entity\User         $usersEntity
     *
     * @return \LundProducts\Entity\Promo $recordEntity
     */
    public function createPromo(Promo $recordEntity, User $usersEntity)
    {
        $recordEntity->setCreatedAt(new DateTime('now'))
                     ->setCreatedBy($usersEntity->getUsername())
                     ->setDeleted(false)
                     ->setDisabled(false);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\Promo $recordEntity
     * @param \RocketUser\Entity\User         $usersEntity
     *
     * @return \LundProducts\Entity\Promo $recordEntity
     */
    public function editPromo(Promo $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
                     ->setModifiedBy($usersEntity->getUsername());
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @param \LundProducts\Entity\Promo $recordEntity
     * @param \RocketUser\Entity\User         $usersEntity
     *
     * @return \LundProducts\Entity\Promo $recordEntity
     */
    public function deletePromo(Promo $recordEntity, User $usersEntity)
    {
        $recordEntity->setModifiedAt(new DateTime('now'))
                     ->setModifiedBy($usersEntity->getUsername())
                     ->setDeleted(true)
                     ->setDisabled(true);
        $this->objectManager->persist($recordEntity);
        $this->objectManager->flush($recordEntity);
        $this->flushCache();

        return $recordEntity;
    }

    /**
     * @return void
     */
    public function flushCache()
    {
        $cacheDriver = $this->objectManager->getConfiguration()->getResultCacheImpl();
        $cacheDriver->delete('promo_find_active');
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
