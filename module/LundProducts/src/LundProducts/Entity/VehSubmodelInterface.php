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
 * VehSubmodel interface
 */
interface VehSubmodelInterface
{
    /**
     * @param  string      $name
     * @return VehSubmodel
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  string      $shortCode
     * @return VehSubmodel
     */
    public function setShortCode($shortCode);

    /**
     * @return string
     */
    public function getShortCode();

    /**
     * @return integer
     */
    public function getVehSubmodelId();

    /**
     * @param  \LundProducts\Entity\VehModel $vehModel
     * @return VehSubmodel
     */
    public function setVehModel(\LundProducts\Entity\VehModel $vehModel = null);

    /**
     * @return \LundProducts\Entity\VehModel
     */
    public function getVehModel();
}
