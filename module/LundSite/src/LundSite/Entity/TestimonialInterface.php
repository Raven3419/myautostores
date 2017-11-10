<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Entity;

/**
 * Testimonial Interface
 */
interface TestimonialInterface
{
    /**
     * @param  \DateTime         $createdAt
     * @return Testimonial
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string            $createdBy
     * @return Testimonial
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime         $modifiedAt
     * @return Testimonial
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string            $modifiedBy
     * @return Testimonial
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean           $deleted
     * @return Testimonial
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean           $disabled
     * @return Testimonial
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  integer            $position
     * @return Testimonial
     */
    public function setPosition($position);

    /**
     * @return integer
     */
    public function getPosition();

    /**
     * @param  string            $content
     * @return Testimonial
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return integer
     */
    public function getTestimonialId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return Testimonial
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();
}
