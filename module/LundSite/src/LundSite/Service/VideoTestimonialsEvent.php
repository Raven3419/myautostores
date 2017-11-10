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

use LundSite\Entity\VideoTestimonialsInterface;
use Zend\EventManager\Event;

/**
 * VideoTestimonials events.
 */
class VideoTestimonialsEvent extends Event
{
    const EVENT_VIDEOTESTIMONIALS_CREATED = 'videoTestimonialsCreated';
    const EVENT_VIDEOTESTIMONIALS_EDITED  = 'videoTestimonialsEdited';
    const EVENT_VIDEOTESTIMONIALS_DELETED = 'videoTestimonialsDeleted';

    /**
     * @var VideoTestimonialsInterface
     */
    protected $videoTestimonials;

    /**
     * @param string               $name
     * @param VideoTestimonialsInterface $videoTestimonials
     */
    public function __construct($name, VideoTestimonialsInterface $videoTestimonials)
    {
        parent::__construct($name);
        $this->videoTestimonials = $videoTestimonials;
    }

    /**
     * @param  VideoTestimonialsInterface $videoTestimonials
     * @return VideoTestimonialsEvent
     */
    public function setVideoTestimonials($videoTestimonials)
    {
        $this->videoTestimonials = $videoTestimonials;

        return $this;
    }

    /**
     * @return VideoTestimonialsInterface
     */
    public function getVideoTestimonials()
    {
        return $this->videoTestimonials;
    }
}
