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
 * NewsRelease
 *
 * @see NewsReleaseInterface
 */
class NewsRelease implements NewsReleaseInterface
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
    protected $newsType;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \RocketDam\Entity\Asset
     */
    protected $image;

    /**
     * @var string
     */
    protected $teaser;

    /**
     * @var date
     */
    protected $displayDate;

    /**
     * @var string
     */
    protected $html;

    /**
     * @var integer
     */
    protected $newsReleaseId;

    /**
     * @var \RocketCms\Entity\Site
     */
    protected $site;

    /**
     * @var \LundProducts\Entity\Brands
     */
    protected $brand;

    /**
     * Set createdAt
     *
     * @param  \DateTime   $createdAt
     * @return NewsRelease
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
     * @return NewsRelease
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
     * @return NewsRelease
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
     * @return NewsRelease
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
     * @return NewsRelease
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
     * @return NewsRelease
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
     * Set title
     *
     * @param  string      $title
     * @return NewsRelease
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set newsType
     *
     * @param  string      $newsType
     * @return NewsRelease
     */
    public function setNewsType($newsType)
    {
        $this->newsType = $newsType;

        return $this;
    }

    /**
     * Get newsType
     *
     * @return string
     */
    public function getNewsType()
    {
        return $this->newsType;
    }

    /**
     * Set url
     *
     * @param  string      $url
     * @return NewsRelease
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set image
     *
     * @param  \RocketDam\Entity\Asset $image
     * @return NewsRelease
     */
    public function setImage(\RocketDam\Entity\Asset $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \RocketDam\Entity\Asset
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set teaser
     *
     * @param  string      $teaser
     * @return NewsRelease
     */
    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set displayDate
     *
     * @param  string      $displayDate
     * @return NewsRelease
     */
    public function setDisplayDate($displayDate)
    {
        $this->displayDate = $displayDate;

        return $this;
    }

    /**
     * Get displayDate
     *
     * @return string
     */
    public function getDisplayDate()
    {
        return $this->displayDate;
    }

    /**
     * Set html
     *
     * @param  string      $html
     * @return NewsRelease
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get html
     *
     * @return string
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Get newsReleaseId
     *
     * @return integer
     */
    public function getNewsReleaseId()
    {
        return $this->newsReleaseId;
    }

    /**
     * Set site
     *
     * @param  \RocketCms\Entity\Site $site
     * @return NewsRelease
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
}
