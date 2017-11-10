<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Entity;

/**
 * ComparisonChart interface
 */
interface ComparisonChartInterface
{
    /**
     * @param  \DateTime    $createdAt
     * @return ComparisonChart
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string       $createdBy
     * @return ComparisonChart
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime    $modifiedAt
     * @return ComparisonChart
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string       $modifiedBy
     * @return ComparisonChart
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean      $deleted
     * @return ComparisonChart
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean      $disabled
     * @return ComparisonChart
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string       $name
     * @return ComparisonChart
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  string       $profile
     * @return ComparisonChart
     */
    public function setProfile($profile);

    /**
     * @return string
     */
    public function getProfile();

    /**
     * @param  string       $vehicleType
     * @return ComparisonChart
     */
   	public function setVehicleType($vehicleType);

    /**
     * @return string
     */
    public function getVehicleType();

    /**
     * @param  string $areaOfProtection
     * @return ComparisonChart
     */
    public function setAreaOfProtection($areaOfProtection);

    /**
     * @return string
     */
    public function getAreaOfProtection();

    /**
     * @param  string       $material
     * @return ComparisonChart
     */
    public function setMaterial($material);

    /**
     * @return string
     */
    public function getMaterial();

    /**
     * @param  string       $availableColors
     * @return ComparisonChart
     */
    public function setAvailableColors($availableColors);

    /**
     * @return string
     */
    public function getAvailableColors();

    /**
     * @param  integer      $drilling
     * @return ComparisonChart
     */
    public function setDrilling($drilling);

    /**
     * @return integer
     */
    public function getDrilling();

    /**
     * @param  integer      $safe
     * @return ComparisonChart
     */
    public function setSafe($safe);

    /**
     * @return integer
     */
    public function getSafe();

    /**
     * @param  integer      $usa
     * @return ComparisonChart
     */
    public function setUsa($usa);

    /**
     * @return integer
     */
    public function getUsa();

    /**
     * @param  string       $warranty
     * @return ComparisonChart
     */
    public function setWarranty($warranty);

    /**
     * @return string
     */
    public function getWarranty();

    /**
     * @return integer
     */
    public function getComparisonChartId();

    /**
     * @param  RocketDam\Entity\Asset $asset
     * @return ComparisonChart
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();
}
