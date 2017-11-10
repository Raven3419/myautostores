<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * @category   Zend
 * @package    LundProducts\Entity
 * @subpackage Interface
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Entity;

/**
 * ProductLines interface
 */
interface ProductReviewsInterface
{
    /**
     * Set createdAt
     *
     * @param  \DateTime      $createdAt
     * @return ProductReviews
     */
    public function setCreatedAt($createdAt);

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Set createdBy
     *
     * @param  string         $createdBy
     * @return ProductReviews
     */
    public function setCreatedBy($createdBy);

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy();

    /**
     * Set modifiedAt
     *
     * @param  \DateTime      $modifiedAt
     * @return ProductReviews
     */
    public function setModifiedAt($modifiedAt);

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * Set modifiedBy
     *
     * @param  string         $modifiedBy
     * @return ProductReviews
     */
    public function setModifiedBy($modifiedBy);

    /**
     * Get modifiedBy
     *
     * @return string
     */
    public function getModifiedBy();

    /**
     * Set deleted
     *
     * @param  boolean        $deleted
     * @return ProductReviews
     */
    public function setDeleted($deleted);

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted();

    /**
     * Set disabled
     *
     * @param  boolean        $disabled
     * @return ProductReviews
     */
    public function setDisabled($disabled);

    /**
     * Get disabled
     *
     * @return boolean
     */
    public function getDisabled();

    /**
     * Set review
     *
     * @param  string         $review
     * @return ProductReviews
     */
    public function setReview($review);

    /**
     * Get review
     *
     * @return string
     */
    public function getReview();

    /**
     * Set rating
     *
     * @param  integer        $rating
     * @return ProductReviews
     */
    public function setRating($rating);

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating();

    /**
     * Get productReviewId
     *
     * @return integer
     */
    public function getProductReviewId();

    /**
     * Set user
     *
     * @param  \RocketUser\Entity\User $user
     * @return ProductReviews
     */
    public function setUser(\RocketUser\Entity\User $user = null);

    /**
     * Get user
     *
     * @return \RocketUser\Entity\User
     */
    public function getUser();

    /**
     * Set productLines
     *
     * @param  \LundProducts\Entity\ProductLines $productLines
     * @return ProductReviews
     */
    public function setProductLines(\LundProducts\Entity\ProductLines $productLines = null);

    /**
     * Get productLines
     *
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLines();
}
