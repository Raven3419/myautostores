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
 * VehYear
 *
 * @see VehYearInterface
 */
class VehYear implements VehYearInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $vehYearId;

    /**
     * Set name
     *
     * @param  string  $name
     * @return VehYear
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
     * Get vehYearId
     *
     * @return integer
     */
    public function getVehYearId()
    {
        return $this->vehYearId;
    }
}
