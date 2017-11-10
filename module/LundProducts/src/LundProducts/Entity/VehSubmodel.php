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
 * VehSubmodel
 *
 * @see VehSubmodelInterface
 */
class VehSubmodel implements VehSubmodelInterface
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
    protected $vehSubmodelId;

    /**
     * @var \LundProducts\Entity\VehModel
     */
    protected $vehModel;

    /**
     * Set name
     *
     * @param  string      $name
     * @return VehSubmodel
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
     * @param  string      $shortCode
     * @return VehSubmodel
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
     * Get vehSubmodelId
     *
     * @return integer
     */
    public function getVehSubmodelId()
    {
        return $this->vehSubmodelId;
    }

    /**
     * Set vehModel
     *
     * @param  \LundProducts\Entity\VehModel $vehModel
     * @return VehSubmodel
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
}
