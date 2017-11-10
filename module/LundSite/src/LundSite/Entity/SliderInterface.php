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
 * Slider Interface
 */
interface SliderInterface
{
    /**
     * @param  \DateTime         $createdAt
     * @return Slider
     */
    public function setCreatedAt($createdAt);

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @param  string            $createdBy
     * @return Slider
     */
    public function setCreatedBy($createdBy);

    /**
     * @return string
     */
    public function getCreatedBy();

    /**
     * @param  \DateTime         $modifiedAt
     * @return Slider
     */
    public function setModifiedAt($modifiedAt);

    /**
     * @return \DateTime
     */
    public function getModifiedAt();

    /**
     * @param  string            $modifiedBy
     * @return Slider
     */
    public function setModifiedBy($modifiedBy);

    /**
     * @return string
     */
    public function getModifiedBy();

    /**
     * @param  boolean           $deleted
     * @return Slider
     */
    public function setDeleted($deleted);

    /**
     * @return boolean
     */
    public function getDeleted();

    /**
     * @param  boolean           $disabled
     * @return Slider
     */
    public function setDisabled($disabled);

    /**
     * @return boolean
     */
    public function getDisabled();

    /**
     * @param  integer            $position
     * @return Slider
     */
    public function setPosition($position);

    /**
     * @return integer
     */
    public function getPosition();

    /**
     * @param  string            $content
     * @return Slider
     */
    public function setContent($content);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param  string            $url
     * @return Slider
     */
    public function setUrl($url);

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return integer
     */
    public function getSliderId();

    /**
     * @param  \RocketCms\Entity\Site $site
     * @return Slider
     */
    public function setSite(\RocketCms\Entity\Site $site = null);

    /**
     * @return \RocketCms\Entity\Site
     */
    public function getSite();

    /**
     * @param  \RocketDam\Entity\Asset $asset
     * @return ProductCategories
     */
    public function setAsset(\RocketDam\Entity\Asset $asset = null);

    /**
     * @return \RocketDam\Entity\Asset
     */
    public function getAsset();

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
