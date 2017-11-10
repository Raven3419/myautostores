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

use LundSite\Entity\TestimonialInterface;
use Zend\EventManager\Event;

/**
 * Testimonial events.
 */
class TestimonialEvent extends Event
{
    const EVENT_TESTIMONIAL_CREATED = 'testimonialCreated';
    const EVENT_TESTIMONIAL_EDITED  = 'testimonialEdited';
    const EVENT_TESTIMONIAL_DELETED = 'testimonialDeleted';

    /**
     * @var TestimonialInterface
     */
    protected $testimonial;

    /**
     * @param string                     $name
     * @param TestimonialInterface $testimonial
     */
    public function __construct($name, TestimonialInterface $testimonial)
    {
        parent::__construct($name);
        $this->testimonial = $testimonial;
    }

    /**
     * @param  TestimonialInterface $testimonial
     * @return TestimonialEvent
     */
    public function setTestimonial($testimonial)
    {
        $this->testimonial = $testimonial;

        return $this;
    }

    /**
     * @return TestimonialInterface
     */
    public function getTestimonial()
    {
        return $this->testimonial;
    }
}
