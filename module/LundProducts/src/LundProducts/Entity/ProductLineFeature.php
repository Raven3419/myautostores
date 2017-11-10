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

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductLineFeature
 *
 * @see ProductLineFeatureInterface
 */
class ProductLineFeature implements ProductLineFeatureInterface
{
    /**
     * @var integer
     */
    protected $productLineFeatureId;

    /**
     * @var \LundProducts\Entity\ProductLines
     */
    protected $productLine;

    /**
     * @var integer
     */
    protected $featureSeq;

    /**
     * @var string
     */
    protected $featureCopy;

    /**
     * Set featureSeq
     *
     * @param  integer          $featureSeq
     * @return ProductLineFeature
     */
    public function setFeatureSeq($featureSeq)
    {
        $this->featureSeq = $featureSeq;

        return $this;
    }

    /**
     * Get featureSeq
     *
     * @return integer
     */
    public function getFeatureSeq()
    {
        return $this->featureSeq;
    }

    /**
     * Get productLineFeatureId
     *
     * @return integer
     */
    public function getProductLineFeatureId()
    {
        return $this->productLineFeatureId;
    }

    /**
     * Set productLine
     *
     * @param  \LundProducts\Entity\ProductLines $productLine
     * @return ProductLineFeature
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
     * Set featureCopy
     *
     * @param  string           $featureCopy
     * @return ProductLineFeature
     */
    public function setFeatureCopy($featureCopy)
    {
        $this->featureCopy = $featureCopy;

        return $this;
    }

    /**
     * Get featureCopy
     *
     * @return string
     */
    public function getFeatureCopy()
    {
        return $this->featureCopy;
    }
}
