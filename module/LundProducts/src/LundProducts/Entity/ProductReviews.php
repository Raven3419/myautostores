<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Entity
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * ProductLines
 *
 * @see ProductReviewsInterface
 */
class ProductReviews implements ProductReviewsInterface
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
     * @var boolean
     */
    protected $disabled;

    /**
     * @var string
     */
    protected $review;

    /**
     * @var integer
     */
    protected $rating;

    /**
     * @var integer
     */
    protected $productReviewId;

    /**
     * @var \RocketUser\Entity\User
     */
    protected $user;

    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLines;

    /**
     * Set createdAt
     *
     * @param  \DateTime      $createdAt
     * @return ProductReviews
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
     * @param  string         $createdBy
     * @return ProductReviews
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
     * @param  \DateTime      $modifiedAt
     * @return ProductReviews
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
     * @param  string         $modifiedBy
     * @return ProductReviews
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
     * @param  boolean        $deleted
     * @return ProductReviews
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
     * Set disabled
     *
     * @param  boolean        $disabled
     * @return ProductReviews
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * Set review
     *
     * @param  string         $review
     * @return ProductReviews
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
     * Set rating
     *
     * @param  integer        $rating
     * @return ProductReviews
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Get productReviewId
     *
     * @return integer
     */
    public function getProductReviewId()
    {
        return $this->productReviewId;
    }

    /**
     * Set user
     *
     * @param  \RocketUser\Entity\User $user
     * @return ProductReviews
     */
    public function setUser(\RocketUser\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \RocketUser\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set productLines
     *
     * @param  \LundProducts\Entity\ProductLines $productLines
     * @return ProductReviews
     */
    public function setProductLines(\LundProducts\Entity\ProductLines $productLines = null)
    {
        $this->productLines = $productLines;

        return $this;
    }

    /**
     * Get productLines
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLines()
    {
        return $this->productLines;
    }
}
