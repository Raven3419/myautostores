<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts;

return array(
    'factories' => array(
        'LundProducts\InputFilter\BrandFilter'                => 'LundProducts\InputFilter\Factory\BrandFilterFactory',
        'LundProducts\InputFilter\ProductLineFilter'          => 'LundProducts\InputFilter\Factory\ProductLineFilterFactory',
        'LundProducts\InputFilter\PartFilter'                 => 'LundProducts\InputFilter\Factory\PartFilterFactory',
        'LundProducts\InputFilter\ProductCategoryFilter'      => 'LundProducts\InputFilter\Factory\ProductCategoryFilterFactory',
        'LundProducts\InputFilter\ProductReviewFilter'        => 'LundProducts\InputFilter\Factory\ProductReviewFilterFactory',
        'LundProducts\InputFilter\PartAssetFilter'            => 'LundProducts\InputFilter\Factory\PartAssetFilterFactory',
        'LundProducts\InputFilter\ProductLineAssetFilter'     => 'LundProducts\InputFilter\Factory\ProductLineAssetFilterFactory',
        'LundProducts\InputFilter\BrandProductCategoryFilter' => 'LundProducts\InputFilter\Factory\BrandProductCategoryFilterFactory',
        'LundProducts\InputFilter\ProductLineFeatureFilter'   => 'LundProducts\InputFilter\Factory\ProductLineFeatureFilterFactory',
    ),
);
