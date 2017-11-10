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

use Doctrine\ORM\Mapping as ORM;

/**
 * ChangesetDetailsVehicles
 */
class ChangesetDetailsVehicles
{
    /**
     * @var string
     */
    private $vehMakeLabel;

    /**
     * @var string
     */
    private $vehModelLabel;

    /**
     * @var string
     */
    private $vehSubmodelLabel;

    /**
     * @var string
     */
    private $vehYearLabel;

    /**
     * @var string
     */
    private $vehClassLabel;

    /**
     * @var integer
     */
    private $changesetDetailVehicleId;

    /**
     * @var \LundProducts\Entity\VehCollection
     */
    private $vehCollection;

    /**
     * @var \LundProducts\Entity\VehMake
     */
    private $vehMake;

    /**
     * @var \LundProducts\Entity\VehModel
     */
    private $vehModel;

    /**
     * @var \LundProducts\Entity\VehSubmodel
     */
    private $vehSubmodel;

    /**
     * @var \LundProducts\Entity\VehYear
     */
    private $vehYear;

    /**
     * @var \LundProducts\Entity\VehClass
     */
    private $vehClass;

    /**
     * @var \LundProducts\Entity\ChangesetDetails
     */
    private $changesetDetails;

    /**
     * Set vehMakeLabel
     *
     * @param  string                   $vehMakeLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehMakeLabel($vehMakeLabel)
    {
        $this->vehMakeLabel = $vehMakeLabel;

        return $this;
    }

    /**
     * Get vehMakeLabel
     *
     * @return string
     */
    public function getVehMakeLabel()
    {
        return $this->vehMakeLabel;
    }

    /**
     * Set vehModelLabel
     *
     * @param  string                   $vehModelLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehModelLabel($vehModelLabel)
    {
        $this->vehModelLabel = $vehModelLabel;

        return $this;
    }

    /**
     * Get vehModelLabel
     *
     * @return string
     */
    public function getVehModelLabel()
    {
        return $this->vehModelLabel;
    }

    /**
     * Set vehSubmodelLabel
     *
     * @param  string                   $vehSubmodelLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehSubmodelLabel($vehSubmodelLabel)
    {
        $this->vehSubmodelLabel = $vehSubmodelLabel;

        return $this;
    }

    /**
     * Get vehSubmodelLabel
     *
     * @return string
     */
    public function getVehSubmodelLabel()
    {
        return $this->vehSubmodelLabel;
    }

    /**
     * Set vehYearLabel
     *
     * @param  string                   $vehYearLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehYearLabel($vehYearLabel)
    {
        $this->vehYearLabel = $vehYearLabel;

        return $this;
    }

    /**
     * Get vehYearLabel
     *
     * @return string
     */
    public function getVehYearLabel()
    {
        return $this->vehYearLabel;
    }

    /**
     * Set vehClassLabel
     *
     * @param  string                   $vehClassLabel
     * @return ChangesetDetailsVehicles
     */
    public function setVehClassLabel($vehClassLabel)
    {
        $this->vehClassLabel = $vehClassLabel;

        return $this;
    }

    /**
     * Get vehClassLabel
     *
     * @return string
     */
    public function getVehClassLabel()
    {
        return $this->vehClassLabel;
    }

    /**
     * Get changesetDetailVehicleId
     *
     * @return integer
     */
    public function getChangesetDetailVehicleId()
    {
        return $this->changesetDetailVehicleId;
    }

    /**
     * Set vehCollection
     *
     * @param  \LundProducts\Entity\VehCollection $vehCollection
     * @return ChangesetDetailsVehicles
     */
    public function setVehCollection(\LundProducts\Entity\VehCollection $vehCollection = null)
    {
        $this->vehCollection = $vehCollection;

        return $this;
    }

    /**
     * Get vehCollection
     *
     * @return \LundProducts\Entity\VehCollection
     */
    public function getVehCollection()
    {
        return $this->vehCollection;
    }

    /**
     * Set vehMake
     *
     * @param  \LundProducts\Entity\VehMake $vehMake
     * @return ChangesetDetailsVehicles
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
     * Set vehModel
     *
     * @param  \LundProducts\Entity\VehModel $vehModel
     * @return ChangesetDetailsVehicles
     */
    public function setVehModel(\LundProducts\Entity\VehModel $vehModel = null)
    {
        $this->vehModel = $vehModel;

        return $this;
    }

    /**
     * Get vehModel
     *
     * @return \LundProducts\Entity\VehModel
     */
    public function getVehModel()
    {
        return $this->vehModel;
    }

    /**
     * Set vehSubmodel
     *
     * @param  \LundProducts\Entity\VehSubmodel $vehSubmodel
     * @return ChangesetDetailsVehicles
     */
    public function setVehSubmodel(\LundProducts\Entity\VehSubmodel $vehSubmodel = null)
    {
        $this->vehSubmodel = $vehSubmodel;

        return $this;
    }

    /**
     * Get vehSubmodel
     *
     * @return \LundProducts\Entity\VehSubmodel
     */
    public function getVehSubmodel()
    {
        return $this->vehSubmodel;
    }

    /**
     * Set vehYear
     *
     * @param  \LundProducts\Entity\VehYear $vehYear
     * @return ChangesetDetailsVehicles
     */
    public function setVehYear(\LundProducts\Entity\VehYear $vehYear = null)
    {
        $this->vehYear = $vehYear;

        return $this;
    }

    /**
     * Get vehYear
     *
     * @return \LundProducts\Entity\VehYear
     */
    public function getVehYear()
    {
        return $this->vehYear;
    }

    /**
     * Set vehClass
     *
     * @param  \LundProducts\Entity\VehClass $vehClass
     * @return ChangesetDetailsVehicles
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

    /**
     * Set changesetDetails
     *
     * @param  \LundProducts\Entity\ChangesetDetails $changesetDetails
     * @return ChangesetDetailsVehicles
     */
    public function setChangesetDetails(\LundProducts\Entity\ChangesetDetails $changesetDetails = null)
    {
        $this->changesetDetails = $changesetDetails;

        return $this;
    }

    /**
     * Get changesetDetails
     *
     * @return \LundProducts\Entity\ChangesetDetails
     */
    public function getChangesetDetails()
    {
        return $this->changesetDetails;
    }
}
