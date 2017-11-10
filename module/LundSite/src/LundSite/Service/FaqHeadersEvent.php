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

use LundSite\Entity\FaqHeadersInterface;
use Zend\EventManager\Event;

/**
 * FaqHeaders events.
 */
class FaqHeadersEvent extends Event
{
    const EVENT_FAQ_CREATED = 'faqHeadersCreated';
    const EVENT_FAQ_EDITED  = 'faqHeadersEdited';
    const EVENT_FAQ_DELETED = 'faqHeadersDeleted';

    /**
     * @var FaqHeadersInterface
     */
    protected $faqHeaders;

    /**
     * @param string               $name
     * @param FaqHeadersInterface $faqHeaders
     */
    public function __construct($name, FaqHeadersInterface $faqHeaders)
    {
        parent::__construct($name);
        $this->faqHeaders = $faqHeaders;
    }

    /**
     * @param  FaqHeadersInterface $faqHeaders
     * @return FaqHeadersEvent
     */
    public function setFaqHeaders($faqHeaders)
    {
        $this->faqHeaders = $faqHeaders;

        return $this;
    }

    /**
     * @return FaqHeadersInterface
     */
    public function getFaqHeaders()
    {
        return $this->faqHeaders;
    }
}
