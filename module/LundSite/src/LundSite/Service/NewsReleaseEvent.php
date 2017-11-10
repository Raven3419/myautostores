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

use LundSite\Entity\NewsReleaseInterface;
use Zend\EventManager\Event;

/**
 * NewsRelease events.
 */
class NewsReleaseEvent extends Event
{
    const EVENT_NEWSRELEASE_CREATED = 'newsReleaseCreated';
    const EVENT_NEWSRELEASE_EDITED  = 'newsReleaseEdited';
    const EVENT_NEWSRELEASE_DELETED = 'newsReleaseDeleted';

    /**
     * @var NewsReleaseInterface
     */
    protected $newsRelease;

    /**
     * @param string               $name
     * @param NewsReleaseInterface $newsRelease
     */
    public function __construct($name, NewsReleaseInterface $newsRelease)
    {
        parent::__construct($name);
        $this->newsRelease = $newsRelease;
    }

    /**
     * @param  NewsReleaseInterface $newsRelease
     * @return NewsReleaseEvent
     */
    public function setNewsRelease($newsRelease)
    {
        $this->newsRelease = $newsRelease;

        return $this;
    }

    /**
     * @return NewsReleaseInterface
     */
    public function getNewsRelease()
    {
        return $this->newsRelease;
    }
}
