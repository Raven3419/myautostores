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
 * VehModel
 *
 * @see VehModelInterface
 */
class VehModel implements VehModelInterface
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
    protected $vehModelId;

    /**
     * @var \LundProducts\Entity\VehMake
     */
    protected $vehMake;

    /**
     * @var \LundProducts\Entity\VehClass
     */
    protected $vehClass;

    /**
     * Set name
     *
     * @param  string   $name
     * @return VehModel
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
     * @param  string   $shortCode
     * @return VehModel
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
     * Get vehModelId
     *
     * @return integer
     */
    public function getVehModelId()
    {
        return $this->vehModelId;
    }

    /**
     * Set vehMake
     *
     * @param  \LundProducts\Entity\VehMake $vehMake
     * @return VehModel
     */
    public function setVehMake(\LundProducts\Entity\VehMake $vehMake = null)
    {
        $this->vehMake = $vehMake;

        return $this;
    }

    /**
     * Get vehMake
     *
     * @return \LundProducts\Entity\VehMake
     */
    public function getVehMake()
    {
        return $this->vehMake;
    }

    /**
     * Set vehClass
     *
     * @param  \LundProducts\Entity\VehClass $vehClass
     * @return VehModel
     */
    public function setVehClass(\LundProducts\Entity\VehClass $vehClass = null)
    {
        $this->vehClass = $vehClass;

        return $this;
    }

    /**
     * Get vehClass
     *
     * @return \LundProducts\Entity\VehClass
     */
    public function getVehClass()
    {
        return $this->vehClass;
    }
}
