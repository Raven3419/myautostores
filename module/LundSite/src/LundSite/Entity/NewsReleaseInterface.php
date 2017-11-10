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
 * NewsRelease Interface
 */
interface NewsReleaseInterface
{
    /**
     * @param  \DateTime   $createdAt
     * @return NewsRelease
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string      $createdBy
     * @return NewsRelease
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime   $modifiedAt
     * @return NewsRelease
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string      $modifiedBy
     * @return NewsRelease
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean     $deleted
     * @return NewsRelease
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean     $disabled
     * @return NewsRelease
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  string      $title
     * @return NewsRelease
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param  string      $newsType
     * @return NewsRelease
     */
    public function setNewsType($newsType);

    /**
     * @return string
     */
    public function getNewsType();

    /**
     * @param  string      $url
     * @return NewsRelease
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @param  string      $image
     * @return NewsRelease
     */
    public function setImage(\RocketDam\Entity\Asset $image = null);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param  string      $teaser
     * @return NewsRelease
     */
    public function setTeaser($teaser);

    /**
     * @return string
     */
    public function getTeaser();

    /**
     * @param  string      $displayDate
     * @return NewsRelease
     */
    public function setDisplayDate($displayDate);

    /**
     * @return string
     */
    public function getDisplayDate();

    /**
     * @param  string      $html
     * @return NewsRelease
     */
    public function setHtml($html);

    /**
     * @return string
     */
    public function getHtml();

    /**
     * @return integer
     */
    public function getNewsReleaseId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return NewsRelease
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
}
