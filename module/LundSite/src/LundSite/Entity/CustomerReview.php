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
 * CustomerReview
 *
 * @see CustomerReviewInterface
 */
class CustomerReview implements CustomerReviewInterface
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
     * @var integer
     */
    protected $price;

    /**
     * @var integer
     */
    protected $value;

    /**
     * @var integer
     */
    protected $quality;

    /**
     * @var decimal
     */
    protected $total;

    /**
     * @var string
     */
    protected $summary;

    /**
     * @var text
     */
    protected $review;

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
    protected $customerReviewId;

    /**
     * Set createdAt
     *
     * @param  \DateTime   $createdAt
     * @return CustomerReview
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
     * @return CustomerReview
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
     * @return CustomerReview
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
     * @return CustomerReview
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
     * @return CustomerReview
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
     * @return CustomerReview
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
     * Set price
     *
     * @param  integer      $price
     * @return CustomerReview
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set value
     *
     * @param  integer      $value
     * @return CustomerReview
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Set quality
     *
     * @param  integer      $quality
     * @return CustomerReview
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return integer
     */
    public function getQuality()
    {
        return $this->quality;
    }
    
    /**
     * Set total
     *
     * @param  decimal      $total
     * @return CustomerReview
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return decimal
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * Set summary
     *
     * @param  string      $summary
     * @return CustomerReview
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }
    
    /**
     * Set review
     *
     * @param  string      $review
     * @return CustomerReview
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return string
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return CustomerReview
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
     * @return CustomerReview
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
     * Get customerReviewId
     *
     * @return integer
     */
    public function getCustomerReviewId()
    {
        return $this->customerReviewId;
    }
}
