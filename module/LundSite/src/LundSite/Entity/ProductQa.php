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
 * ProductQa
 *
 * @see ProductQaInterface
 */
class ProductQa implements ProductQaInterface
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
    protected $email;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var text
     */
    protected $question;

    /**
     * @var text
     */
    protected $answer;

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
    protected $productQaId;

    /**
     * Set createdAt
     *
     * @param  \DateTime   $createdAt
     * @return ProductQa
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
     * @return ProductQa
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
     * @return ProductQa
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
     * @return ProductQa
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
     * @return ProductQa
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
     * @return ProductQa
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
     * Set email
     *
     * @param  string      $email
     * @return ProductQa
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set name
     *
     * @param  string      $name
     * @return ProductQa
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    
    /**
     * Set question
     *
     * @param  string      $question
     * @return ProductQa
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * Set answer
     *
     * @param  string      $answer
     * @return ProductQa
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return ProductQa
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
     * @return ProductQa
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
     * Get productQaId
     *
     * @return integer
     */
    public function getProductQaId()
    {
        return $this->productQaId;
    }
}
