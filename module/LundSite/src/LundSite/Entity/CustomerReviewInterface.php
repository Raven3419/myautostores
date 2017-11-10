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
 * CustomerReview Interface
 */
interface CustomerReviewInterface
{
    /**
     * @param  \DateTime   $createdAt
     * @return CustomerReview
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string      $createdBy
     * @return CustomerReview
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime   $modifiedAt
     * @return CustomerReview
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string      $modifiedBy
     * @return CustomerReview
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean     $deleted
     * @return CustomerReview
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();
    
    /**
     * @param  string      $status
     * @return CustomerReview
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param  integer      $price
     * @return CustomerReview
     */
    public function setPrice($price);
    
    /**
     * @return integer
     */
    public function getPrice();
    
    /**
     * @param  integer      $value
     * @return CustomerReview
     */
    public function setValue($value);
    
    /**
     * @return integer
     */
    public function getValue();
    
    /**
     * @param  integer      $quality
     * @return CustomerReview
     */
    public function setQuality($quality);
    
    /**
     * @return integer
     */
    public function getQuality();
    
    /**
     * @param  decimal      $total
     * @return CustomerReview
     */
    public function setTotal($total);

    /**
     * @return decimal
     */
    public function getTotal();
    
    /**
     * @param  string      $summary
     * @return CustomerReview
     */
    public function setSummary($summary);
    
    /**
     * @return string
     */
    public function getSummary();
    
    /**
     * @param  string      $review
     * @return CustomerReview
     */
    public function setReview($review);

    /**
     * @return string
     */
    public function getReview();
    

    /**
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return ProductQa
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null);

    /**
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine();

    /**
     * @param  \RocketEcom\Entity\EcomCustomer $ecomCustomer
     * @return ProductQa
     */
    public function setEcomCustomer(\RocketEcom\Entity\EcomCustomer $ecomCustomer = null);

    /**
     * @return \RocketEcom\Entity\EcomCustomer
     */
    public function getEcomCustomer();

    /**
     * @return integer
     */
    public function getCustomerReviewId();
}
