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
 * Faq Interface
 */
interface FaqInterface
{
    /**
     * @param  \DateTime   $createdAt
     * @return Faq
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string      $createdBy
     * @return Faq
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime   $modifiedAt
     * @return Faq
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string      $modifiedBy
     * @return Faq
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean     $deleted
     * @return Faq
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean     $disabled
     * @return Faq
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();
    
    /**
     * @param  string      $question
     * @return Faq
     */
    public function setQuestion($question);

    /**
     * @return string
     */
    public function getQuestion();
    
    /**
     * @param  string      $answer
     * @return Faq
     */
    public function setAnswer($answer);

    /**
     * @return string
     */
    public function getAnswer();

    /**
     * @return integer
     */
    public function getFaqId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return Faq
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \LundProducts\Entity\Brands $brand
     * @return ProductLines
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null);

    /**
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand();
    
    /**
     * @param  \LundSite\Entity\FaqHeaders $faqHeaders
     * @return ProductLines
     */
    public function setFaqHeaders(\LundSite\Entity\FaqHeaders $faqHeaders= null);
    
    /**
     * @return \LundSite\Entity\FaqHeaders
     */
    public function getFaqHeaders();
}
