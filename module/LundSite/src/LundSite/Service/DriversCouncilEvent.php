<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use LundSite\Entity\DriversCouncilInterface;
use Zend\EventManager\Event;

/**
 * DriversCouncil events.
 */
class DriversCouncilEvent extends Event
{
    const EVENT_DRIVERSCOUNCIL_CREATED = 'driversCouncilCreated';
    const EVENT_DRIVERSCOUNCIL_EDITED  = 'driversCouncilEdited';
    const EVENT_DRIVERSCOUNCIL_DELETED = 'driversCouncilDeleted';

    /**
     * @var DriversCouncilInterface
     */
    protected $driversCouncil;

    /**
     * @param string                  $name
     * @param DriversCouncilInterface $driversCouncil
     */
    public function __construct($name, DriversCouncilInterface $driversCouncil)
    {
        parent::__construct($name);
        $this->driversCouncil = $driversCouncil;
    }

    /**
     * @param  DriversCouncilInterface $driversCouncil
     * @return DriversCouncilEvent
     */
    public function setDriversCouncil($driversCouncil)
    {
        $this->driversCouncil = $driversCouncil;

        return $this;
    }

    /**
     * @return DriversCouncilInterface
     */
    public function getDriversCouncil()
    {
        return $this->driversCouncil;
    }
}
