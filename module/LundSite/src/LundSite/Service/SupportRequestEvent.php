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

use LundSite\Entity\SupportRequestInterface;
use Zend\EventManager\Event;

/**
 * SupportRequest events.
 */
class SupportRequestEvent extends Event
{
    const EVENT_SUPPORTREQUEST_CREATED = 'supportRequestCreated';
    const EVENT_SUPPORTREQUEST_EDITED  = 'supportRequestEdited';
    const EVENT_SUPPORTREQUEST_DELETED = 'supportRequestDeleted';

    /**
     * @var SupportRequestInterface
     */
    protected $supportRequest;

    /**
     * @param string                  $name
     * @param SupportRequestInterface $supportRequest
     */
    public function __construct($name, SupportRequestInterface $supportRequest)
    {
        parent::__construct($name);
        $this->supportRequest = $supportRequest;
    }

    /**
     * @param  SupportRequestInterface $supportRequest
     * @return SupportRequestEvent
     */
    public function setSupportRequest($supportRequest)
    {
        $this->supportRequest = $supportRequest;

        return $this;
    }

    /**
     * @return SupportRequestInterface
     */
    public function getSupportRequest()
    {
        return $this->supportRequest;
    }
}
