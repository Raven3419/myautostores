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
 * Promo
 *
 * @see PromoInterface
 */
class Promo implements PromoInterface
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
    protected $customerNumber;
    
    /**
     * @var \DateTime
     */
    protected $startDate;
    
    /**
     * @var \DateTime
     */
    protected $endDate;
    
    /**
     * @var string
     */
    protected $promoDesc;
    
    /**
     * @var string
     */
    protected $promoCode;
    
    /**
     * @var string
     */
    protected $promoNumber;
    
    /**
     * @var string
     */
    protected $promoLine;
    
    /**
     * @var string
     */
    protected $price;
    
    /**
     * @var string
     */
    protected $percent;
    
    /**
     * @var boolean
     */
    protected $promoPrice;
    
    /**
     * @var boolean
     */
    protected $promoOff;
    
    /**
     * @var boolean
     */
    protected $customerPromo;
    
    /**
     * @var boolean
     */
    protected $itemClassPromo;
    
    /**
     * @var boolean
     */
    protected $itemPromo;

    /**
     * @var text
     */
    protected $description;
    
    /**
     * @var integer
     */
    protected $promoId;
    
    /**
     * @var \LundProducts\Entity\Parts
     */
    protected $parts;
    
    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLine;


    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime  $createdAt
     * @return Promo
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
     * @param  string     $createdBy
     * @return Promo
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
     * @param  \DateTime  $modifiedAt
     * @return Promo
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
     * @param  string     $modifiedBy
     * @return Promo
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
     * @param  boolean    $deleted
     * @return Promo
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
     * @param  boolean    $disabled
     * @return Promo
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
     * Set customerNumber
     *
     * @param  integer    $customerNumber
     * @return Promo
     */
    public function setCustomerNumber($customerNumber)
    {
        $this->customerNumber= $customerNumber;
        
        return $this;
    }
    
    /**
     * Get customerNumber
     *
     * @return boolean
     */
    public function getCustomerNumber()
    {
        return $this->customerNumber;
    }
    
    /**
     * Set startDate
     *
     * @param  \DateTime  $startDate
     * @return Promo
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        
        return $this;
    }
    
    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }
    
    /**
     * Set endDate
     *
     * @param  \DateTime  $endDate
     * @return Promo
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        
        return $this;
    }
    
    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * Set promoDesc
     *
     * @param  string     $promoDesc
     * @return Promo
     */
    public function setPromoDesc($promoDesc)
    {
        $this->promoDesc = $promoDesc;
        
        return $this;
    }
    
    /**
     * Get promoDesc
     *
     * @return string
     */
    public function getPromoDesc()
    {
        return $this->promoDesc;
    }
    
    /**
     * Set promoCode
     *
     * @param  string     $promoCode
     * @return Promo
     */
    public function setPromoCode($promoCode)
    {
        $this->promoCode = $promoCode;
        
        return $this;
    }
    
    /**
     * Get promoCode
     *
     * @return string
     */
    public function getPromoCode()
    {
        return $this->promoCode;
    }
    
    /**
     * Set promoNumber
     *
     * @param  string     $promoNumber
     * @return Promo
     */
    public function setPromoNumber($promoNumber)
    {
        $this->promoNumber = $promoNumber;
        
        return $this;
    }
    
    /**
     * Get promoNumber
     *
     * @return string
     */
    public function getPromoNumber()
    {
        return $this->promoNumber;
    }
    
    /**
     * Set promoLine
     *
     * @param  string     $promoLine
     * @return Promo
     */
    public function setPromoLine($promoLine)
    {
        $this->promoLine = $promoLine;
        
        return $this;
    }
    
    /**
     * Get promoLine
     *
     * @return string
     */
    public function getPromoLine()
    {
        return $this->promoLine;
    }
    
    /**
     * Set price
     *
     * @param  string     $price
     * @return Promo
     */
    public function setPrice($price)
    {
        $this->price = $price;
        
        return $this;
    }
    
    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set percent
     *
     * @param  string     $percent
     * @return Promo
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;
        
        return $this;
    }
    
    /**
     * Get percent
     *
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }
    
    /**
     * Set promoPrice
     *
     * @param  boolean    $promoPrice
     * @return Promo
     */
    public function setPromoPrice($promoPrice)
    {
        $this->promoPrice = $promoPrice;
        
        return $this;
    }
    
    /**
     * Get promoPrice
     *
     * @return boolean
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }
    
    /**
     * Set promoOff
     *
     * @param  boolean    $promoOff
     * @return Promo
     */
    public function setPromoOff($promoOff)
    {
        $this->promoOff = $promoOff;
        
        return $this;
    }
    
    /**
     * Get promoOff
     *
     * @return boolean
     */
    public function getPromoOff()
    {
        return $this->promoOff;
    }
    
    /**
     * Set customerPromo
     *
     * @param  boolean    $customerPromo
     * @return Promo
     */
    public function setCustomerPromo($customerPromo)
    {
        $this->customerPromo = $customerPromo;
        
        return $this;
    }
    
    /**
     * Get customerPromo
     *
     * @return boolean
     */
    public function getCustomerPromo()
    {
        return $this->customerPromo;
    }
    
    /**
     * Set itemClassPromo
     *
     * @param  boolean    $itemClassPromo
     * @return Promo
     */
    public function setItemClassPromo($itemClassPromo)
    {
        $this->itemClassPromo = $itemClassPromo;
        
        return $this;
    }
    
    /**
     * Get itemClassPromo
     *
     * @return boolean
     */
    public function getItemClassPromo()
    {
        return $this->itemClassPromo;
    }
    
    /**
     * Set itemPromo
     *
     * @param  boolean    $itemPromo
     * @return Promo
     */
    public function setItemPromo($itemPromo)
    {
        $this->itemPromo = $itemPromo;
        
        return $this;
    }
    
    /**
     * Get itemPromo
     *
     * @return boolean
     */
    public function getItemPromo()
    {
        return $this->itemPromo;
    }
    
    /**
     * Set description
     *
     * @param  boolean    $description
     * @return Promo
     */
    public function setDescription($description)
    {
        $this->description= $description;
        
        return $this;
    }
    
    /**
     * Get description
     *
     * @return boolean
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set parts
     *
     * @param  \LundProducts\Entity\Parts $parts
     * @return Promo
     */
    public function setParts(\LundProducts\Entity\Parts $parts= null)
    {
        $this->parts = $parts;
        
        return $this;
    }
    
    /**
     * Get parts
     *
     * @return \LundProducts\Entity\Parts
     */
    public function getParts()
    {
        return $this->parts;
    }
    
    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return Promo
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
     * Get promoId
     *
     * @return integer
     */
    public function getPromoId()
    {
        return $this->promoId;
    }
}
