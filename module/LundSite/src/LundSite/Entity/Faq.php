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
 * Faq
 *
 * @see FaqInterface
 */
class Faq implements FaqInterface
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
    protected $question;

    /**
     * @var string
     */
    protected $answer;

    /**
     * @var integer
     */
    protected $faqId;

    /**
     * @var \RocketCms\Entity\Site
     */
    protected $site;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $brand;
    
    /**
     * @var \LundSite\Entity\FaqHeaders
     */
    protected $faqHeaders;

    /**
     * Set createdAt
     *
     * @param  \DateTime   $createdAt
     * @return Faq
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
     * @return Faq
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
     * @return Faq
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
     * @return Faq
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
     * @return Faq
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
     * @param  boolean     $disabled
     * @return Faq
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
     * Set question
     *
     * @param  string      $question
     * @return Faq
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
     * @return Faq
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
     * Get faqId
     *
     * @return integer
     */
    public function getFaqId()
    {
        return $this->faqId;
    }

    /**
     * Set site
     *
     * @param  \RocketCms\Entity\Site $site
     * @return Faq
     */
    public function setSite(\RocketCms\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \RocketCms\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set brand
     *
     * @param  \LundProducts\Entity\Brands $brand
     * @return ProductLines
     */
    public function setBrand(\LundProducts\Entity\Brands $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \LundProducts\Entity\Brands
     */
    public function getBrand()
    {
        return $this->brand;
    }
    
    /**
     * Set faqHeaders
     *
     * @param  \LundSite\Entity\FaqHeaders $faqHeaders
     * @return ProductLines
     */
    public function setFaqHeaders(\LundSite\Entity\FaqHeaders $faqHeaders= null)
    {
        $this->faqHeaders= $faqHeaders;
        
        return $this;
    }
    
    /**
     * Get faqHeaders
     *
     * @return \LundSite\Entity\FaqHeaders
     */
    public function getFaqHeaders()
    {
        return $this->faqHeaders;
    }
}
