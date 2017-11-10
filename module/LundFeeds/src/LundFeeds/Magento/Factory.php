<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage MAGENTO
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\Magento;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\MagentoService;
use Exception;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;
use LundProducts\Service\ProductLineService;
use LundProducts\Service\ProductLineFeatureService;
use LundProducts\Service\BrandProductCategoryService;

class MagentoFactory
{
    public static $magentoVersions = ['csv'];

    /**
     * @param string           $version
     * @param PartService      $partService
     * @param PiesService      $piesService
     * @param BrandsRepository $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetailsVehiclesService
     * @param ProductLineService 	  		  $productLineService
     * @param ProductLineFeatureService 	  $productLineFeatureService
     * @param BrandProductCategoryService 	  $brandProductCategoryService
     * @param string           $brand
     * @param []               $config
     *
     * @return PiesInterface $aces
     */
    public static function getMagento(
        $version = null,
        PartService      $partService = null,
        MagentoService      $magentoService = null,
        BrandsRepository $brandsRepository = null,
        ChangesetsService $changesetsService = null,
        ChangesetDetailsService $changesetDetailsService = null,
        ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
        ProductLineService $productLineService = null,
        ProductLineFeatureService $productLineFeatureService = null,
        BrandProductCategoryService $brandProductCategoryService = null,
        $brand    = null,
        $generate = null,
        $changeset_id = null,
        $config = null)
    {
        if (!self::isValidMagentoVersion($version)) {
            throw new Exception('A valid Magento version must be given to generate a Magento document. (given \'' . $version . '\')');
        }

        // strip out .'s to map to a filename
        $version = 'LundFeeds\Magento\Magento' . str_replace('.', '', $version);

        return new $version($partService, $magentoService, $brandsRepository, $changesetsService, $changesetDetailsService, $changesetDetailsVehiclesService,  $productLineService,  $productLineFeatureService,  $brandProductCategoryService, $brand, $generate, $changeset_id, $config);
    }

    /*
     * @return boolean
     */
    public static function isValidMagentoVersion($version = null)
    {
        $return = false;

        if (null == $version) {
            return $return;
        }

        if (!in_array($version, self::$magentoVersions)) {
            return $return;
        }

        $return = true;

        return $return;
    }
}
