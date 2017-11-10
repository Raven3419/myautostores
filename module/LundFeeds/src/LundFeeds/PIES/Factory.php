<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage PIES
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\PIES;

use LundProducts\Service\PartService;
use LundProducts\Repository\BrandsRepository;
use LundFeeds\Service\PiesService;
use Exception;

class PiesFactory
{
    public static $piesVersions = ['6.5','csv'];

    /**
     * @param string           $version
     * @param PartService      $partService
     * @param PiesService      $piesService
     * @param BrandsRepository $brandsRepository
     * @param string           $brand
     * @param []               $config
     *
     * @return PiesInterface $aces
     */
    public static function getPies(
        $version = null,
        PartService      $partService = null,
        PiesService      $piesService = null,
        BrandsRepository $brandsRepository = null,
        $brand    = null,
        $generate = null,
        $changeset_id = null,
        $config = null)
    {
        if (!self::isValidPiesVersion($version)) {
            throw new Exception('A valid PIES version must be given to generate a PIES document. (given \'' . $version . '\')');
        }

        // strip out .'s to map to a filename
        $version = 'LundFeeds\PIES\PIES' . str_replace('.', '', $version);

        return new $version($partService, $piesService, $brandsRepository, $brand, $generate, $changeset_id, $config);
    }

    /*
     * @return boolean
     */
    public static function isValidPiesVersion($version = null)
    {
        $return = false;

        if (null == $version) {
            return $return;
        }

        if (!in_array($version, self::$piesVersions)) {
            return $return;
        }

        $return = true;

        return $return;
    }
}
