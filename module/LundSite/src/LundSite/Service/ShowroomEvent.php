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

use LundSite\Entity\ShowroomInterface;
use Zend\EventManager\Event;

/**
 * Showroom events.
 */
class ShowroomEvent extends Event
{
    const EVENT_SHOWROOM_CREATED = 'showroomCreated';
    const EVENT_SHOWROOM_EDITED  = 'showroomEdited';
    const EVENT_SHOWROOM_DELETED = 'showroomDeleted';

    /**
     * @var ShowroomInterface
     */
    protected $showroom;

    /**
     * @param string                     $name
     * @param ShowroomInterface $showroom
     */
    public function __construct($name, ShowroomInterface $showroom)
    {
        parent::__construct($name);
        $this->showroom = $showroom;
    }

    /**
     * @param  ShowroomInterface $showroom
     * @return ShowroomEvent
     */
    public function setShowroom($showroom)
    {
        $this->showroom = $showroom;

        return $this;
    }

    /**
     * @return ShowroomInterface
     */
    public function getShowroom()
    {
        return $this->showroom;
    }
}
