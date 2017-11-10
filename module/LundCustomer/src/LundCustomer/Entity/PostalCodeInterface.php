<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Entity;

/**
 * PostalCode Interface
 */

interface PostalCodeInterface
{
    /**
     * @return integer
     */
    public function getPostalCodeId();

    /**
     * @param  string     $code
     * @return PostalCode
     */
    public function setCode($code);

    /**
     * @return string
     */
    public function getCode();

    /**
     * @param  string     $city
     * @return PostalCode
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param  string     $statePrefix
     * @return PostalCode
     */
    public function setStatePrefix($statePrefix);

    /**
     * @return string
     */
    public function getStatePrefix();

    /**
     * @param  float      $lat
     * @return PostalCode
     */
    public function setLat($lat);

    /**
     * @return float
     */
    public function getLat();

    /**
     * @param  float      $lon
     * @return PostalCode
     */
    public function setLon($lon);

    /**
     * @return float
     */
    public function getLon();
}
