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

use LundSite\Entity\SliderInterface;
use Zend\EventManager\Event;

/**
 * Slider events.
 */
class SliderEvent extends Event
{
    const EVENT_SLIDER_CREATED = 'sliderCreated';
    const EVENT_SLIDER_EDITED  = 'sliderEdited';
    const EVENT_SLIDER_DELETED = 'sliderDeleted';

    /**
     * @var SliderInterface
     */
    protected $slider;

    /**
     * @param string                     $name
     * @param SliderInterface $slider
     */
    public function __construct($name, SliderInterface $slider)
    {
        parent::__construct($name);
        $this->slider = $slider;
    }

    /**
     * @param  SliderInterface $slider
     * @return SliderEvent
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * @return SliderInterface
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
