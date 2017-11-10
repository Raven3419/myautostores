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
 * ProductLineFeature Interface
 */
interface ProductLineFeatureInterface
{
    /**
     * @param  integer          $assetSeq
     * @return ProductLineFeature
     */
    public function setFeatureSeq($assetSeq);

    /**
     * @return integer
     */
    public function getFeatureSeq();

    /**
     * @return integer
     */
    public function getProductLineFeatureId();

    /**
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return ProductLineFeature
     */
    public function setProductLine(\LundProducts\Entity\ProductLines $productLine = null);

    /**
     * @return \LundProducts\Entity\ProductLines
     */
    public function getProductLine();

    /**
     * @param  string           $featureCopy
     * @return ProductLineFeature
     */
    public function setFeatureCopy($featureCopy);

    /**
     * @return string
     */
    public function getFeatureCopy();
}
