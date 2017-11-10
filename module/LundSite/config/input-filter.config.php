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
        'LundSite\InputFilter\NewsReleaseFilter'         => 'LundSite\InputFilter\Factory\NewsReleaseFilterFactory',
        'LundSite\InputFilter\ContactSubmissionFilter'   => 'LundSite\InputFilter\Factory\ContactSubmissionFilterFactory',
        'LundSite\InputFilter\DealersEdgeFilter'         => 'LundSite\InputFilter\Factory\DealersEdgeFilterFactory',
        'LundSite\InputFilter\DriversCouncilFilter'      => 'LundSite\InputFilter\Factory\DriversCouncilFilterFactory',
        'LundSite\InputFilter\FaqFilter'         		 => 'LundSite\InputFilter\Factory\FaqFilterFactory',
        'LundSite\InputFilter\ProductRegistrationFilter' => 'LundSite\InputFilter\Factory\ProductRegistrationFilterFactory',
        'LundSite\InputFilter\SpecialOffersFilter'       => 'LundSite\InputFilter\Factory\SpecialOffersFilterFactory',
        'LundSite\InputFilter\SupportRequestFilter'      => 'LundSite\InputFilter\Factory\SupportRequestFilterFactory',
        'LundSite\InputFilter\ShowroomFilter'            => 'LundSite\InputFilter\Factory\ShowroomFilterFactory',
        'LundSite\InputFilter\SliderFilter'              => 'LundSite\InputFilter\Factory\SliderFilterFactory',
        'LundSite\InputFilter\TestimonialFilter'         => 'LundSite\InputFilter\Factory\TestimonialFilterFactory',
        'LundSite\InputFilter\ProductQaFilter'         	 => 'LundSite\InputFilter\Factory\ProductQaFilterFactory',
        'LundSite\InputFilter\CustomerReviewFilter'      => 'LundSite\InputFilter\Factory\CustomerReviewFilterFactory',
        'LundSite\InputFilter\VideoTestimonialsFilter'   => 'LundSite\InputFilter\Factory\VideoTestimonialsFilterFactory',
        'LundSite\InputFilter\ComparisonChartFilter'     => 'LundSite\InputFilter\Factory\ComparisonChartFilterFactory',
    ),
);
