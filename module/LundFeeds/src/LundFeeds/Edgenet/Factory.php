<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage Edgenet
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\Edgenet;

use LundProducts\Service\PartService;
use LundProducts\Service\ProductLineFeatureService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\EdgenetService;
use Exception;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;

class EdgenetFactory
{
    /**
     * @param string                          $version
     * @param PartService                     $partService
     * @param EdgenetService                  $edgenetService
     * @param ProductLineFeatureService   	  $productLineFeatureService
     * @param BrandsRepository                $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetailsVehiclesService
     * @param string                          $brand
     *
     * @return EdgenetInterface $edgenet
     */
    public static function getEdgenet(
        $version = null,
        PartService      				$partService = null,
        EdgenetService      			$edgenetService = null,
        ProductLineFeatureService   	$productLineFeatureService = null,
        BrandsRepository 				$brandsRepository = null,
        ChangesetsService 				$changesetsService = null,
        ChangesetDetailsService 		$changesetDetailsService = null,
        ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
        $brand    = null,
        $generate = null,
        $changeset_id = null)
    {

        // strip out .'s to map to a filename
        $version = 'LundFeeds\Edgenet\Edgenet';

        return new $version($partService, $edgenetService, $productLineFeatureService, $brandsRepository, $changesetsService, $changesetDetailsService, $changesetDetailsVehiclesService, $brand, $generate, $changeset_id);
    }

}
