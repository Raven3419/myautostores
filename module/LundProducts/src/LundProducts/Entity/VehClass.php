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
 * VehClass
 *
 * @see VehClassInterface
 */
class VehClass implements VehClassInterface
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
    protected $vehClassId;

    /**
     * Set name
     *
     * @param  string   $name
     * @return VehClass
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
     * @return VehClass
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
     * Get vehClassId
     *
     * @return integer
     */
    public function getVehClassId()
    {
        return $this->vehClassId;
    }
}
