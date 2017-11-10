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
 * AboutHousehold
 *
 * @see AboutHouseholdInterface
 */
class AboutHousehold implements AboutHouseholdInterface
{
    /**
     * @var boolean
     */
    protected $deleted;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var integer
     */
    protected $aboutHouseholdId;

    /**
     * Set deleted
     *
     * @param  boolean        $deleted
     * @return AboutHousehold
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
     * Set title
     *
     * @param  string         $title
     * @return AboutHousehold
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get aboutHouseholdId
     *
     * @return integer
     */
    public function getAboutHouseholdId()
    {
        return $this->aboutHouseholdId;
    }
}
