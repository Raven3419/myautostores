<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite\Entity;

/**
 * VideoTestimonials
 *
 * @see VideoTestimonialsInterface
 */
class VideoTestimonials implements VideoTestimonialsInterface
{
    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var \DateTime
     */
    protected $modifiedAt;

    /**
     * @var string
     */
    protected $modifiedBy;

    /**
     * @var boolean
     */
    protected $deleted;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $title;
    
    /**
     * @var text
     */
    protected $comment;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLine;

    /**
     * @var \RocketEcom\Entity\EcomCustomer
     */
    protected $ecomCustomer;

    /**
     * @var integer
     */
    protected $videoTestimonialsId;

    /**
     * Set createdAt
     *
     * @param  \DateTime   $createdAt
     * @return VideoTestimonials
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param  string      $createdBy
     * @return VideoTestimonials
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedAt
     *
     * @param  \DateTime   $modifiedAt
     * @return VideoTestimonials
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedBy
     *
     * @param  string      $modifiedBy
     * @return VideoTestimonials
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return string
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set deleted
     *
     * @param  boolean     $deleted
     * @return VideoTestimonials
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
    
    /**
     * Set status
     *
     * @param  string      $status
     * @return VideoTestimonials
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set title
     *
     * @param  string      $title
     * @return VideoTestimonials
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set comment
     *
     * @param  string      $comment
     * @return VideoTestimonials
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * Set url
     *
     * @param  string      $url
     * @return VideoTestimonials
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return VideoTestimonials
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null)
    {
        $this->productLine = $productLine;

        return $this;
    }

    /**
     * Get productLine
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine()
    {
        return $this->productLine;
    }

    /**
     * Set ecomCustomer
     *
     * @param  \RocketEcom\Entity\EcomCustomer $ecomCustomer
     * @return VideoTestimonials
     */
    public function setEcomCustomer(\RocketEcom\Entity\EcomCustomer $ecomCustomer = null)
    {
        $this->ecomCustomer = $ecomCustomer;

        return $this;
    }

    /**
     * Get productLine
     *
     * @return \RocketEcom\Entity\EcomCustomer
     */
    public function getEcomCustomer()
    {
        return $this->ecomCustomer;
    }

    /**
     * Get videoTestimonialsId
     *
     * @return integer
     */
    public function getVideoTestimonialsId()
    {
        return $this->videoTestimonialsId;
    }
}
