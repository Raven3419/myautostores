<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\Entity;

/**
 * PostalCode
 *
 * @see PostalCodeInterface
 */

class PostalCode implements PostalCodeInterface
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $statePrefix;

    /**
     * @var float
     */
    protected $lat;

    /**
     * @var float
     */
    protected $lon;

    /**
     * @var integer
     */
    protected $postalCodeId;

    /**
     * Get postalCodeId
     *
     * @return integer
     */
    public function getPostalCodeId()
    {
        return $this->postalCodeId;
    }

    /**
     * Set code
     *
     * @param  string     $code
     * @return PostalCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set city
     *
     * @param  string     $city
     * @return PostalCode
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set statePrefix
     *
     * @param  string     $statePrefix
     * @return PostalCode
     */
    public function setStatePrefix($statePrefix)
    {
        $this->statePrefix = $statePrefix;

        return $this;
    }

    /**
     * Get statePrefix
     *
     * @return string
     */
    public function getStatePrefix()
    {
        return $this->statePrefix;
    }

    /**
     * Set lat
     *
     * @param  float      $lat
     * @return PostalCode
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lon
     *
     * @param  float      $lon
     * @return PostalCode
     */
    public function setLon($lon)
    {
        $this->lon = $lon;

        return $this;
    }

    /**
     * Get lon
     *
     * @return float
     */
    public function getLon()
    {
        return $this->lon;
    }
}
