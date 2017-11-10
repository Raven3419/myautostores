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

use LundSite\Entity\FaqInterface;
use Zend\EventManager\Event;

/**
 * Faq events.
 */
class FaqEvent extends Event
{
    const EVENT_FAQ_CREATED = 'faqCreated';
    const EVENT_FAQ_EDITED  = 'faqEdited';
    const EVENT_FAQ_DELETED = 'faqDeleted';

    /**
     * @var FaqInterface
     */
    protected $faq;

    /**
     * @param string               $name
     * @param FaqInterface $faq
     */
    public function __construct($name, FaqInterface $faq)
    {
        parent::__construct($name);
        $this->faq = $faq;
    }

    /**
     * @param  FaqInterface $faq
     * @return FaqEvent
     */
    public function setFaq($faq)
    {
        $this->faq = $faq;

        return $this;
    }

    /**
     * @return FaqInterface
     */
    public function getFaq()
    {
        return $this->faq;
    }
}
