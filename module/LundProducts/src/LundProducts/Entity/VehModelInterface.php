<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * VehModel interface
 */
interface VehModelInterface
{
    /**
     * @param  string   $name
     * @return VehModel
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  string   $shortCode
     * @return VehModel
     */
    public function setShortCode($shortCode);

    /**
     * @return string
     */
    public function getShortCode();

    /**
     * @return integer
     */
    public function getVehModelId();

    /**
     * @param  \LundProducts\Entity\VehMake $vehMake
     * @return VehModel
     */
    public function setVehMake(\LundProducts\Entity\VehMake $vehMake = null);

    /**
     * @return \LundProducts\Entity\VehMake
     */
    public function getVehMake();

    /**
     * @param  \LundProducts\Entity\VehClass $vehClass
     * @return VehModel
     */
    public function setVehClass(\LundProducts\Entity\VehClass $vehClass = null);

    /**
     * @return \LundProducts\Entity\VehClass
     */
    public function getVehClass();
}
