<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * VehMake
 *
 * @see VehMakeInterface
 */
class VehMake implements VehMakeInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $shortCode;

    /**
     * @var integer
     */
    protected $vehMakeId;

    /**
     * Set name
     *
     * @param  string  $name
     * @return VehMake
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set shortCode
     *
     * @param  string  $shortCode
     * @return VehMake
     */
    public function setShortCode($shortCode)
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    /**
     * Get shortCode
     *
     * @return string
     */
    public function getShortCode()
    {
        return $this->shortCode;
    }

    /**
     * Get vehMakeId
     *
     * @return integer
     */
    public function getVehMakeId()
    {
        return $this->vehMakeId;
    }
}
