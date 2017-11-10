<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProduct
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProduct
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service;

use RocketCms\Entity\SiteInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use LundProducts\Service\BrandsService;
use LundProducts\Service\ProductCategoryService;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\ProductLineAssetService;
use LundProducts\Service\PartService;
use LundProducts\Service\PromoService;
use LundProducts\Service\ParsePromoService;
use LundProducts\Service\PartAssetService;
use LundProducts\Service\VehCollectionService;
use LundProducts\Service\ProductReviewService;
use LundProducts\Repository\PartVehCollectionRepositoryInterface;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\BrandProductCategoryService;
use LundProducts\Service\ProductLineFeatureService;

/**
 * Service injecting all lund product services.
 */
class LundProductService implements EventManagerAwareInterface
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
     * @var BrandsService
     */
    protected $brandsService;

    /**
     * @var ProductCategoryService
     */
    protected $productCategoryService;

    /**
     * @var ProductLineService
     */
    protected $productLineService;

    /**
     * @var ProductLineAssetService
     */
    protected $productLineAssetService;

    /**
     * @var PartService
     */
    protected $partService;
    
    /**
     * @var PromoService
     */
    protected $promoService;
    
    /**
     * @var ParsePromoService
     */
    protected $parsePromoService;

    /**
     * @var PartAssetService
     */
    protected $partAssetService;

    /**
     * @var VehCollectionService
     */
    protected $vehCollectionService;

    /**
     * @var ProductReviewService
     */
    protected $productReviewService;

    /**
     * @var PartVehCollectionRepositoryInterface
     */
    protected $partVehCollectionRepository;

    /**
     * @var ChangesetsService
     */
    protected $changesetsService;

    /**
     * @var ChangesetDetailsService
     */
    protected $changesetDetailsService;

    /**
     * @var BrandProductCategoryService
     */
    protected $brandProductCategoryService;

    /**
     * @var ProductLineFeatureService
     */
    protected $productLineFeatureService;

    /**
     * @param ObjectManager                        $objectManager
     * @param NewsreleaseService                   $brandsServie
     * @param ProductCategoryService               $productCategoryService
     * @param ProductLineService                   $productLineService
     * @param ProductLineAssetService              $productLineAssetService
     * @param PartService                          $partService
     * @param PartAssetService                     $partAssetService
     * @param VehCollectionService                 $vehCollectionService
     * @param ProductReviewService                 $productReviewService
     * @param PartVehCollectionRepositoryInterface $partVehCollectionRepository
     * @param ChangesetsService                    $changesetsService
     * @param ChangesetDetailsService              $changesetDetailsService
     * @param BrandProductCategoryService          $brandProductCategoryService
     * @param ProductLineFeatureService            $productLineFeatureService
     * @param PromoService                         $promoService
     * @param ParsePromoService                    $parsePromoService
     */
    public function __construct(
        ObjectManager $objectManager,
        BrandsService $brandsService,
        ProductCategoryService $productCategoryService,
        ProductLineService $productLineService,
        ProductLineAssetService $productLineAssetService,
        PartService $partService,
        PartAssetService $partAssetService,
        VehCollectionService $vehCollectionService,
        ProductReviewService $productReviewService,
        PartVehCollectionRepositoryInterface $partVehCollectionRepository,
        ChangesetsService $changesetsService,
        ChangesetDetailsService $changesetDetailsService,
        BrandProductCategoryService $brandProductCategoryService,
        ProductLineFeatureService $productLineFeatureService,
        PromoService $promoService,
        ParsePromoService $parsePromoService
    ) {
        $this->objectManager = $objectManager;
        $this->brandsService = $brandsService;
        $this->productCategoryService = $productCategoryService;
        $this->productLineService = $productLineService;
        $this->productLineAssetService = $productLineAssetService;
        $this->partService = $partService;
        $this->partAssetService = $partAssetService;
        $this->vehCollectionService = $vehCollectionService;
        $this->productReviewService = $productReviewService;
        $this->partVehCollectionRepository = $partVehCollectionRepository;
        $this->changesetsService = $changesetsService;
        $this->changesetDetailsService = $changesetDetailsService;
        $this->brandProductCategoryService = $brandProductCategoryService;
        $this->productLineFeatureService = $productLineFeatureService;
        $this->promoService = $promoService;
        $this->parsePromoService = $parsePromoService;
    }

    /**
     * Return BrandsService
     *
     * @return BrandsService
     */
    public function getBrandsService()
    {
        return $this->brandsService;
    }

    /**
     * Return ProductCategoryService
     *
     * @return ProductCategoryService
     */
    public function getProductCategoryService()
    {
        return $this->productCategoryService;
    }

    /**
     * Return ProductLineService
     *
     * @return ProductLineService
     */
    public function getProductLineService()
    {
        return $this->productLineService;
    }

    /**
     * Returns ProductLineAssetService
     *
     * @return ProductLineAssetService
     */
    public function getProductLineAssetService()
    {
        return $this->productLineAssetService;
    }

    /**
     * Return PartService
     *
     * @return PartService
     */
    public function getPartService()
    {
        return $this->partService;
    }
    
    /**
     * Return PromoService
     *
     * @return PromoService
     */
    public function getPromoService()
    {
        return $this->promoService;
    }
    
    /**
     * Return ParsePromoService
     *
     * @return ParsePromoService
     */
    public function getParsePromoService()
    {
        return $this->parsePromoService;
    }

    /**
     * Return PartAssetService
     *
     * @return PartAssetService
     */
    public function getPartAssetService()
    {
        return $this->partAssetService;
    }

    /**
     * Return VehCollectionService
     *
     * @return VehCollectionService
     */
    public function getVehCollectionService()
    {
        return $this->vehCollectionService;
    }

    /**
     * Return ProductReviewService
     *
     * @return ProductReviewService
     */
    public function getProductReviewService()
    {
        return $this->productReviewService;
    }

    /**
     * Return ChangesetsService
     *
     * @return ChangesetsService
     */
    public function getChangesetsService()
    {
        return $this->changesetsService;
    }

    /**
     * Return ChangesetDetailsService
     *
     * @return ChangesetDetailsService
     */
    public function getChangesetDetailsService()
    {
        return $this->changesetDetailsService;
    }

    /**
     * Return BrandProductCategoryService
     *
     * @return BrandProductCategoryService
     */
    public function getBrandProductCategoryService()
    {
        return $this->brandProductCategoryService;
    }

    /**
     * Return ProductLineFeatureService
     *
     * @return ProductLineFeatureService
     */
    public function getProductLineFeatureService()
    {
        return $this->productLineFeatureService;
    }

    /**
     * Return part vehicle collection records by veh collection
     *
     * @param  array                                $vehCollections
     * @return PartVehCollectionRepositoryInterface
     */
    public function getPartVehicleCollectionsByVehColl($vehCollections = null)
    {
        if (is_array($vehCollections)) {
            $criteriaArray = array();

            foreach ($vehCollections as $vehCollection) {
                $criteriaArray[] = $vehCollection->getVehCollectionId();
            }
            //print_r($criteriaArray);exit;

            return $this->partVehCollectionRepository->findByVehArray($criteriaArray);
        } else {
            return false;
        }
    }

    /**
     * Return part vehicle colelction records by part
     *
     * @param  integer                              $partid
     * @return PartVehCollectionRepositoryInterface
     */
    public function getPartVehicleCollectionsByPart($partId = null)
    {
        return $this->partVehCollectionRepository->findBy(['part' => $partId]);
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
