<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite;

return array(
    'factories' => array(
        'LundSite\Form\NewsReleaseForm'                      => 'LundSite\Form\Factory\NewsReleaseFormFactory',
        'LundSite\Form\Fieldset\NewsReleaseFieldset'         => 'LundSite\Form\Fieldset\Factory\NewsReleaseFieldsetFactory',
        'LundSite\Form\ContactSubmissionForm'                => 'LundSite\Form\Factory\ContactSubmissionFormFactory',
        'LundSite\Form\Fieldset\ContactSubmissionFieldset'   => 'LundSite\Form\Fieldset\Factory\ContactSubmissionFieldsetFactory',
        'LundSite\Form\DealersEdgeForm'                      => 'LundSite\Form\Factory\DealersEdgeFormFactory',
        'LundSite\Form\Fieldset\DealersEdgeFieldset'         => 'LundSite\Form\Fieldset\Factory\DealersEdgeFieldsetFactory',
        'LundSite\Form\DriversCouncilForm'                   => 'LundSite\Form\Factory\DriversCouncilFormFactory',
        'LundSite\Form\Fieldset\DriversCouncilFieldset'      => 'LundSite\Form\Fieldset\Factory\DriversCouncilFieldsetFactory',
        'LundSite\Form\FaqForm'                      		 => 'LundSite\Form\Factory\FaqFormFactory',
        'LundSite\Form\Fieldset\FaqFieldset'         		 => 'LundSite\Form\Fieldset\Factory\FaqFieldsetFactory',
        'LundSite\Form\ProductRegistrationForm'              => 'LundSite\Form\Factory\ProductRegistrationFormFactory',
        'LundSite\Form\Fieldset\ProductRegistrationFieldset' => 'LundSite\Form\Fieldset\Factory\ProductRegistrationFieldsetFactory',
        'LundSite\Form\SpecialOffersForm'                 	 => 'LundSite\Form\Factory\SpecialOffersFormFactory',
        'LundSite\Form\Fieldset\SpecialOffersFieldset'   	 => 'LundSite\Form\Fieldset\Factory\SpecialOffersFieldsetFactory',
        'LundSite\Form\SupportRequestForm'                   => 'LundSite\Form\Factory\SupportRequestFormFactory',
        'LundSite\Form\Fieldset\SupportRequestFieldset'      => 'LundSite\Form\Fieldset\Factory\SupportRequestFieldsetFactory',
        'LundSite\Form\ShowroomForm'                         => 'LundSite\Form\Factory\ShowroomFormFactory',
        'LundSite\Form\Fieldset\ShowroomFieldset'            => 'LundSite\Form\Fieldset\Factory\ShowroomFieldsetFactory',
        'LundSite\Form\SliderForm'                           => 'LundSite\Form\Factory\SliderFormFactory',
        'LundSite\Form\Fieldset\SliderFieldset'              => 'LundSite\Form\Fieldset\Factory\SliderFieldsetFactory',
        'LundSite\Form\TestimonialForm'                      => 'LundSite\Form\Factory\TestimonialFormFactory',
        'LundSite\Form\Fieldset\TestimonialFieldset'         => 'LundSite\Form\Fieldset\Factory\TestimonialFieldsetFactory',
        'LundSite\Form\ProductQaForm'                      	 => 'LundSite\Form\Factory\ProductQaFormFactory',
        'LundSite\Form\Fieldset\ProductQaFieldset'         	 => 'LundSite\Form\Fieldset\Factory\ProductQaFieldsetFactory',
        'LundSite\Form\ProductQaForm'                      	 => 'LundSite\Form\Factory\ProductQaFormFactory',
        'LundSite\Form\Fieldset\ProductQaFieldset'         	 => 'LundSite\Form\Fieldset\Factory\ProductQaFieldsetFactory',
        'LundSite\Form\CustomerReviewForm'                   => 'LundSite\Form\Factory\CustomerReviewFormFactory',
        'LundSite\Form\Fieldset\CustomerReviewFieldset'      => 'LundSite\Form\Fieldset\Factory\CustomerReviewFieldsetFactory',
        'LundSite\Form\VideoTestimonialsForm'                => 'LundSite\Form\Factory\VideoTestimonialsFormFactory',
        'LundSite\Form\Fieldset\VideoTestimonialsFieldset'   => 'LundSite\Form\Fieldset\Factory\VideoTestimonialsFieldsetFactory',
        'LundSite\Form\ComparisonChartForm'                  => 'LundSite\Form\Factory\ComparisonChartFormFactory',
        'LundSite\Form\Fieldset\ComparisonChartFieldset'     => 'LundSite\Form\Fieldset\Factory\ComparisonChartFieldsetFactory',
    ),
);
