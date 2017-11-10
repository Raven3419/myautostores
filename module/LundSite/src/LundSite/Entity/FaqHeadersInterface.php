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
interface FaqHeadersInterface
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
     * @param  string      $header
     * @return Faq
     */
    public function setHeader($header);
    
    /**
     * @return string
     */
    public function getHeader();
    
    /**
     * @param  string      $position
     * @return Faq
     */
    public function setPosition($position);
    
    /**
     * @return string
     */
    public function getPosition();
    
    /**
     * @return integer
     */
    public function getFaqHeadersId();
}
