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
 * ProductQa Interface
 */
interface ProductQaInterface
{
    /**
     * @param  \DateTime   $createdAt
     * @return ProductQa
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string      $createdBy
     * @return ProductQa
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime   $modifiedAt
     * @return ProductQa
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string      $modifiedBy
     * @return ProductQa
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean     $deleted
     * @return ProductQa
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();
    
    /**
     * @param  string      $status
     * @return ProductQa
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getStatus();
    
    /**
     * @param  string      $email
     * @return ProductQa
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmail();
    
    /**
     * @param  string      $name
     * @return ProductQa
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();
    
    /**
     * @param  string      $question
     * @return ProductQa
     */
    public function setQuestion($question);

    /**
     * @return string
     */
    public function getQuestion();
    
    /**
     * @param  string      $answer
     * @return ProductQa
     */
    public function setAnswer($answer);

    /**
     * @return string
     */
    public function getAnswer();

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
    public function getProductQaId();
}
