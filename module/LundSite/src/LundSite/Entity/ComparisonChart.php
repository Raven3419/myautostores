<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Entity;

/**
 * ComparisonChart
 *
 * @see ComparisonChartInterface
 */
class ComparisonChart implements ComparisonChartInterface
{
    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var \DateTime
     */
    protected $modifiedAt;

    /**
     * @var string
     */
    protected $modifiedBy;

    /**
     * @var boolean
     */
    protected $deleted;

    /**
     * @var boolean
     */
    protected $disabled;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $profile;

    /**
     * @var string
     */
    protected $vehicleType;

    /**
     * @var string
     */
    protected $areaOfProtection;

    /**
     * @var string
     */
    protected $material;

    /**
     * @var string
     */
    protected $availableColors;

    /**
     * @var integer
     */
    protected $drilling;

    /**
     * @var integer
     */
    protected $safe;

    /**
     * @var integer
     */
    protected $usa;

    /**
     * @var string
     */
    protected $warranty;

    /**
     * @var integer
     */
    protected $comparisonChartId;

    /**
     * @var RocketDam\Entity\Asset
     */
    protected $asset;

    /**
     * Set createdAt
     *
     * @param  \DateTime    $createdAt
     * @return ComparisonChart
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param  string       $createdBy
     * @return ComparisonChart
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedAt
     *
     * @param  \DateTime    $modifiedAt
     * @return ComparisonChart
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedBy
     *
     * @param  string       $modifiedBy
     * @return ComparisonChart
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set deleted
     *
     * @param  boolean      $deleted
     * @return ComparisonChart
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set disabled
     *
     * @param  boolean      $disabled
     * @return ComparisonChart
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set name
     *
     * @param  string       $name
     * @return ComparisonChart
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
     * Set profile
     *
     * @param  string       $profile
     * @return ComparisonChart
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set vehicleType
     *
     * @param  string       $vehicleType
     * @return ComparisonChart
     */
    public function setVehicleType($vehicleType)
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    /**
     * Get vehicleType
     *
     * @return string
     */
    public function getVehicleType()
    {
        return $this->vehicleType;
    }

    /**
     * Set areaOfProtection
     *
     * @param  string $areaOfProtection
     * @return ComparisonChart
     */
    public function setAreaOfProtection($areaOfProtection)
    {
        $this->areaOfProtection = $areaOfProtection;

        return $this;
    }

    /**
     * Get areaOfProtection
     *
     * @return string
     */
    public function getAreaOfProtection()
    {
        return $this->areaOfProtection;
    }

    /**
     * Set material
     *
     * @param  string       $material
     * @return ComparisonChart
     */
    public function setMaterial($material)
    {
        $this->material = $material;

        return $this;
    }

    /**
     * Get material
     *
     * @return string
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set availableColors
     *
     * @param  string       $availableColors
     * @return ComparisonChart
     */
    public function setAvailableColors($availableColors)
    {
        $this->availableColors = $availableColors;

        return $this;
    }

    /**
     * Get availableColors
     *
     * @return string
     */
    public function getAvailableColors()
    {
        return $this->availableColors;
    }

    /**
     * Set drilling
     *
     * @param  integer      $drilling
     * @return ComparisonChart
     */
    public function setDrilling($drilling)
    {
        $this->drilling = $drilling;

        return $this;
    }

    /**
     * Get drilling
     *
     * @return integer
     */
    public function getDrilling()
    {
        return $this->drilling;
    }

    /**
     * Set safe
     *
     * @param  integer      $safe
     * @return ComparisonChart
     */
    public function setSafe($safe)
    {
        $this->safe = $safe;

        return $this;
    }

    /**
     * Get safe
     *
     * @return integer
     */
    public function getSafe()
    {
        return $this->safe;
    }

    /**
     * Set usa
     *
     * @param  integer      $usa
     * @return ComparisonChart
     */
    public function setUsa($usa)
    {
        $this->usa = $usa;

        return $this;
    }

    /**
     * Get usa
     *
     * @return integer
     */
    public function getUsa()
    {
        return $this->usa;
    }

    /**
     * Set warranty
     *
     * @param  string       $warranty
     * @return ComparisonChart
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return string
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Get comparisonChartId
     *
     * @return integer
     */
    public function getComparisonChartId()
    {
        return $this->comparisonChartId;
    }

    /**
     * Set asset
     *
     * @param  RocketDam\Entity\Asset $asset
     * @return ComparisonChart
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null)
    {
        $this->asset = $asset;

        return $this;
    }

    /**
     * Get asset
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset()
    {
        return $this->asset;
    }
}
