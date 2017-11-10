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
 * VideoTestimonials Interface
 */
interface VideoTestimonialsInterface
{
    /**
     * @param  \DateTime   $createdAt
     * @return VideoTestimonials
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string      $createdBy
     * @return VideoTestimonials
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime   $modifiedAt
     * @return VideoTestimonials
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string      $modifiedBy
     * @return VideoTestimonials
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean     $deleted
     * @return VideoTestimonials
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();
    
    /**
     * @param  string      $status
     * @return VideoTestimonials
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();
    
    /**
     * @param  string      $title
     * @return VideoTestimonials
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();
    
    /**
     * @param  string      $comment
     * @return VideoTestimonials
     */
    public function setComment($comment);

    /**
     * @return string
     */
    public function getComment();
    
    /**
     * @param  string      $url
     * @return VideoTestimonials
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getUrl();
    
    /**
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return VideoTestimonials
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null);

    /**
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine();

    /**
     * @param  \RocketEcom\Entity\EcomCustomer $ecomCustomer
     * @return VideoTestimonials
     */
    public function setEcomCustomer(\RocketEcom\Entity\EcomCustomer $ecomCustomer = null);

    /**
     * @return \RocketEcom\Entity\EcomCustomer
     */
    public function getEcomCustomer();

    /**
     * @return integer
     */
    public function getVideoTestimonialsId();
}
