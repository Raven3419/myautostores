<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Exception
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Exception;

class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
    /**
    * @param mixed $partAsset

    */
    public static function invalidPartAssetEntity($partAsset)
    {
        return new static(
            sprintf(
                '%s does not implement LundProducts\Entity\PartAssetInterface',
                is_object($partAsset) ? get_class($partAsset) : gettype($partAsset)
            )
        );
    }

    /**
    * @param mixed $productLineAsset

    */
    public static function invalidProductLineAssetEntity($productLineAsset)
    {
        return new static(
            sprintf(
                '%s does not implement LundProducts\Entity\ProductLineAssetInterface',
                is_object($productLineAsset) ? get_class($productLineAsset) : gettype($productLineAsset)
            )
        );
    }

    /**
    * @param mixed $productLineFeature

    */
    public static function invalidProductLineFeatureEntity($productLineFeature)
    {
        return new static(
            sprintf(
                '%s does not implement LundProducts\Entity\ProductLineFeatureInterface',
                is_object($productLineFeature) ? get_class($productLineFeature) : gettype($productLineFeature)
            )
        );
    }

    /**
    * @param mixed $brandProductCategory

    */
    public static function invalidBrandProductCategoryEntity($brandProductCategory)
    {
        return new static(
            sprintf(
                '%s does not implement LundProducts\Entity\BrandProductCategoryInterface',
                is_object($brandProductCategory) ? get_class($brandProductCategory) : gettype($brandProductCategory)
            )
        );
    }
}
