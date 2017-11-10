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
 * ChangesetDetailsVehicles interface
 */
interface ChangesetDetailsVehiclesInterface
{
    /**
     * @param  string                   $vehMakeLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehMakeLabel($vehMakeLabel);

    /**
     * @return string
     */
    public function getVehMakeLabel();

    /**
     * @param  string                   $vehModelLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehModelLabel($vehModelLabel);

    /**
     * @return string
     */
    public function getVehModelLabel();

    /**
     * @param  string                   $vehSubmodelLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehSubmodelLabel($vehSubmodelLabel);

    /**
     * @return string
     */
    public function getVehSubmodelLabel();

    /**
     * @param  string                   $vehYearLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehYearLabel($vehYearLabel);

    /**
     * @return string
     */
    public function getVehYearLabel();

    /**
     * @param  string                   $vehClassLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehClassLabel($vehClassLabel);

    /**
     * @return string
     */
    public function getVehClassLabel();

    /**
     * @return integer
     */
    public function getChangesetDetailVehicleId();

    /**
     * @param  \LundProducts\Entity\VehCollection $vehCollection
     * @return ChangesetDetailsVehicles
     */
    public function setVehCollection(\LundProducts\Entity\VehCollection $vehCollection = null);

    /**
     * @return \LundProducts\Entity\VehCollection
     */
    public function getVehCollection();

    /**
     * @param  \LundProducts\Entity\VehMake $vehMake
     * @return ChangesetDetailsVehicles
     */
    public function setVehMake(\LundProducts\Entity\VehMake $vehMake = null);

    /**
     * @return \LundProducts\Entity\VehMake
     */
    public function getVehMake();

    /**
     * @param  \LundProducts\Entity\VehModel $vehModel
     * @return ChangesetDetailsVehicles
     */
    public function setVehModel(\LundProducts\Entity\VehModel $vehModel = null);

    /**
     * @return \LundProducts\Entity\VehModel
     */
    public function getVehModel();

    /**
     * @param  \LundProducts\Entity\VehSubmodel $vehSubmodel
     * @return ChangesetDetailsVehicles
     */
    public function setVehSubmodel(\LundProducts\Entity\VehSubmodel $vehSubmodel = null);

    /**
     * @return \LundProducts\Entity\VehSubmodel
     */
    public function getVehSubmodel();

    /**
     * @param  \LundProducts\Entity\VehYear $vehYear
     * @return ChangesetDetailsVehicles
     */
    public function setVehYear(\LundProducts\Entity\VehYear $vehYear = null);

    /**
     * @return \LundProducts\Entity\VehYear
     */
    public function getVehYear();

    /**
     * @param  \LundProducts\Entity\VehClass $vehClass
     * @return ChangesetDetailsVehicles
     */
    public function setVehClass(\LundProducts\Entity\VehClass $vehClass = null);

    /**
     * @return \LundProducts\Entity\VehClass
     */
    public function getVehClass();

    /**
     * @param  \LundProducts\Entity\ChangesetDetails $changesetDetails
     * @return ChangesetDetailsVehicles
     */
    public function setChangesetDetails(\LundProducts\Entity\ChangesetDetails $changesetDetails = null);

    /**
     * @return \LundProducts\Entity\ChangesetDetails
     */
    public function getChangesetDetails();
}
