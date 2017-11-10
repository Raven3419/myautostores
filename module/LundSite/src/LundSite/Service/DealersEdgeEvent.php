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

use LundSite\Entity\DealersEdgeInterface;
use Zend\EventManager\Event;

/**
 * DealersEdge events.
 */
class DealersEdgeEvent extends Event
{
    const EVENT_DEALERSEDGE_CREATED = 'dealersEdgeCreated';
    const EVENT_DEALERSEDGE_EDITED  = 'dealersEdgeEdited';
    const EVENT_DEALERSEDGE_DELETED = 'dealersEdgeDeleted';

    /**
     * @var DealersEdgeInterface
     */
    protected $dealersEdge;

    /**
     * @param string               $name
     * @param DealersEdgeInterface $dealersEdge
     */
    public function __construct($name, DealersEdgeInterface $dealersEdge)
    {
        parent::__construct($name);
        $this->dealersEdge = $dealersEdge;
    }

    /**
     * @param  DealersEdgeInterface $dealersEdge
     * @return DealersEdgeEvent
     */
    public function setDealersEdge($dealersEdge)
    {
        $this->dealersEdge = $dealersEdge;

        return $this;
    }

    /**
     * @return DealersEdgeInterface
     */
    public function getDealersEdge()
    {
        return $this->dealersEdge;
    }
}
