<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage ACES
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\ACES;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\AcesService;
use Exception;
use LundProducts\Service\ChangesetsService;
use LundProducts\Service\ChangesetDetailsService;
use LundProducts\Service\ChangesetDetailsVehiclesService;

class AcesFactory
{
    public static $acesVersions = ['3.0.1', '3.1'];

    /**
     * @param string                          $version
     * @param PartService                     $partService
     * @param AcesService                     $acesService
     * @param BrandsRepository                $brandsRepository
     * @param ChangesetsService               $changesetsService
     * @param ChangesetDetailsService         $changesetDetailsService
     * @param ChangesetDetailsVehiclesService $changesetDetailsVehiclesService
     * @param string                          $brand
     *
     * @return AcesInterface $aces
     */
    public static function getAces(
        $version = null,
        PartService      $partService = null,
        AcesService      $acesService = null,
        BrandsRepository $brandsRepository = null,
        ChangesetsService $changesetsService = null,
        ChangesetDetailsService $changesetDetailsService = null,
        ChangesetDetailsVehiclesService $changesetDetailsVehiclesService = null,
        $brand    = null,
        $generate = null,
        $changeset_id = null)
    {
        if (!self::isValidAcesVersion($version)) {
            throw new Exception('A valid ACES version must be given to generate an ACES document. (given \'' . $version . '\')');
        }

        // strip out .'s to map to a filename
        $version = 'LundFeeds\ACES\ACES' . str_replace('.', '', $version);

        return new $version($partService, $acesService, $brandsRepository, $changesetsService, $changesetDetailsService, $changesetDetailsVehiclesService, $brand, $generate, $changeset_id);
    }

    /*
     * @return boolean
     */
    public static function isValidAcesVersion($version = null)
    {
        $return = false;

        if (null == $version) {
            return $return;
        }

        if (!in_array($version, self::$acesVersions)) {
            return $return;
        }

        $return = true;

        return $return;
    }
}
