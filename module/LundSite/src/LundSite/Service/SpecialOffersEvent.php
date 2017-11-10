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

use LundSite\Entity\SpecialOffersInterface;
use Zend\EventManager\Event;

/**
 * SpecialOffers events.
 */
class SpecialOffersEvent extends Event
{
    const EVENT_SPECIALOFFERS_CREATED = 'specialOffersCreated';
    const EVENT_SPECIALOFFERS_EDITED  = 'specialOffersEdited';
    const EVENT_SPECIALOFFERS_DELETED = 'specialOffersDeleted';

    /**
     * @var SpecialOffersInterface
     */
    protected $specialOffers;

    /**
     * @param string               $name
     * @param SpecialOffersInterface $specialOffers
     */
    public function __construct($name, SpecialOffersInterface $specialOffers)
    {
        parent::__construct($name);
        $this->specialOffers = $specialOffers;
    }

    /**
     * @param  SpecialOffersInterface $specialOffers
     * @return SpecialOffersEvent
     */
    public function setSpecialOffers($specialOffers)
    {
        $this->specialOffers = $specialOffers;

        return $this;
    }

    /**
     * @return SpecialOffersInterface
     */
    public function getSpecialOffers()
    {
        return $this->specialOffers;
    }
}
