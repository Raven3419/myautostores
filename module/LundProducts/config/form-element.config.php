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
        'LundProducts\Form\BrandForm'                             => 'LundProducts\Form\Factory\BrandFormFactory',
        'LundProducts\Form\Fieldset\BrandFieldset'                => 'LundProducts\Form\Fieldset\Factory\BrandFieldsetFactory',
        'LundProducts\Form\ProductLineForm'                       => 'LundProducts\Form\Factory\ProductLineFormFactory',
        'LundProducts\Form\Fieldset\ProductLineFieldset'          => 'LundProducts\Form\Fieldset\Factory\ProductLineFieldsetFactory',
        'LundProducts\Form\PartForm'                              => 'LundProducts\Form\Factory\PartFormFactory',
        'LundProducts\Form\Fieldset\PartFieldset'                 => 'LundProducts\Form\Fieldset\Factory\PartFieldsetFactory',
        'LundProducts\Form\ProductCategoryForm'                   => 'LundProducts\Form\Factory\ProductCategoryFormFactory',
        'LundProducts\Form\Fieldset\ProductCategoryFieldset'      => 'LundProducts\Form\Fieldset\Factory\ProductCategoryFieldsetFactory',
        'LundProducts\Form\ProductReviewForm'                     => 'LundProducts\Form\Factory\ProductReviewFormFactory',
        'LundProducts\Form\Fieldset\ProductReviewFieldset'        => 'LundProducts\Form\Fieldset\Factory\ProductReviewFieldsetFactory',
        'LundProducts\Form\PartAssetForm'                         => 'LundProducts\Form\Factory\PartAssetFormFactory',
        'LundProducts\Form\Fieldset\PartAssetFieldset'            => 'LundProducts\Form\Fieldset\Factory\PartAssetFieldsetFactory',
        'LundProducts\Form\ProductLineAssetForm'                  => 'LundProducts\Form\Factory\ProductLineAssetFormFactory',
        'LundProducts\Form\Fieldset\ProductLineAssetFieldset'     => 'LundProducts\Form\Fieldset\Factory\ProductLineAssetFieldsetFactory',
        'LundProducts\Form\BrandProductCategoryForm'              => 'LundProducts\Form\Factory\BrandProductCategoryFormFactory',
        'LundProducts\Form\Fieldset\BrandProductCategoryFieldset' => 'LundProducts\Form\Fieldset\Factory\BrandProductCategoryFieldsetFactory',
        'LundProducts\Form\ProductLineFeatureForm'                => 'LundProducts\Form\Factory\ProductLineFeatureFormFactory',
        'LundProducts\Form\Fieldset\ProductLineFeatureFieldset'   => 'LundProducts\Form\Fieldset\Factory\ProductLineFeatureFieldsetFactory',
    ),
);
