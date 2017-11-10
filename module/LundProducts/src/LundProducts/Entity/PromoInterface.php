<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
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
 * Promo interface
 */
interface PromoInterface
{
    /**
     * @param  \DateTime  $createdAt
     * @return Promo
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string     $createdBy
     * @return Promo
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime  $modifiedAt
     * @return Promo
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string     $modifiedBy
     * @return Promo
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean    $deleted
     * @return Promo
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean    $disabled
     * @return Promo
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();
    
    /**
     * @param  integer    $customerNumber
     * @return Promo
     */
    public function setCustomerNumber($customerNumber);
    
    /**
     * @return boolean
     */
    public function getCustomerNumber();
    
    /**
     * @param  \DateTime  $startDate
     * @return Promo
     */
    public function setStartDate($startDate);
    
    /**
     * @return \DateTime
     */
    public function getStartDate();
    
    /**
     * @param  \DateTime  $endDate
     * @return Promo
     */
    public function setEndDate($endDate);
    
    /**
     * @return \DateTime
     */
    public function getEndDate();
    
    /**
     * @param  string     $promoDesc
     * @return Promo
     */
    public function setPromoDesc($promoDesc);
    
    /**
     * @return string
     */
    public function getPromoDesc();
    
    /**
     * @param  string     $promoCode
     * @return Promo
     */
    public function setPromoCode($promoCode);
    
    /**
     * @return string
     */
    public function getPromoCode();
    
    /**
     * @param  string     $promoNumber
     * @return Promo
     */
    public function setPromoNumber($promoNumber);
    
    /**
     * @return string
     */
    public function getPromoNumber();
    
    /**
     * @param  string     $promoLine
     * @return Promo
     */
    public function setPromoLine($promoLine);
    
    /**
     * @return string
     */
    public function getPromoLine();
    
    /**
     * @param  string     $price
     * @return Promo
     */
    public function setPrice($price);
    
    /**
     * @return string
     */
    public function getPrice();
    
    /**
     * @param  string     $percent
     * @return Promo
     */
    public function setPercent($percent);
    
    /**
     * @return string
     */
    public function getPercent();
    
    /**
     * @param  boolean    $promoPrice
     * @return Promo
     */
    public function setPromoPrice($promoPrice);
    
    /**
     * @return boolean
     */
    public function getPromoPrice();
    
    /**
     * @param  boolean    $promoOff
     * @return Promo
     */
    public function setPromoOff($itemPromoOff);
    
    /**
     * @return boolean
     */
    public function getPromoOff();
    
    /**
     * @param  boolean    $customerPromo
     * @return Promo
     */
    public function setCustomerPromo($customerPromo);
    
    /**
     * @return boolean
     */
    public function getCustomerPromo();
    
    /**
     * @param  boolean    $itemClassPromo
     * @return Promo
     */
    public function setItemClassPromo($itemClassPromo);
    
    /**
     * @return boolean
     */
    public function getItemClassPromo();
    
    /**
     * @param  boolean    $itemPromo
     * @return Promo
     */
    public function setItemPromo($itemPromo);
    
    /**
     * @return boolean
     */
    public function getItemPromo();
    
    /**
     * @param  \LundProducts\Entity\Parts $parts
     * @return Promo
     */
    public function setParts(\LundProducts\Entity\Parts $parts= null);
    
    /**
     * @return \LundProducts\Entity\Parts
     */
    public function getParts();
    
    /**
     * @param  boolean    $description
     * @return Promo
     */
    public function setDescription($description);
    
    /**
     * @return boolean
     */
    public function getDescription();
    
    /**
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return Promo
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null);
    
    /**
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine();
    
    /**
     * @return integer
     */
    public function getPromoId();
}
