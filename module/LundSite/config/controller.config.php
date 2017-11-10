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
        'LundSite\Controller\NewsRelease'         => 'LundSite\Controller\Factory\NewsReleaseControllerFactory',
        'LundSite\Controller\ContactSubmission'   => 'LundSite\Controller\Factory\ContactSubmissionControllerFactory',
        'LundSite\Controller\DealersEdge'         => 'LundSite\Controller\Factory\DealersEdgeControllerFactory',
        'LundSite\Controller\DriversCouncil'      => 'LundSite\Controller\Factory\DriversCouncilControllerFactory',
        'LundSite\Controller\Faq'         		  => 'LundSite\Controller\Factory\FaqControllerFactory',
        'LundSite\Controller\ProductRegistration' => 'LundSite\Controller\Factory\ProductRegistrationControllerFactory',
        'LundSite\Controller\SpecialOffers'       => 'LundSite\Controller\Factory\SpecialOffersControllerFactory',
        'LundSite\Controller\SupportRequest'      => 'LundSite\Controller\Factory\SupportRequestControllerFactory',
        'LundSite\Controller\Showroom'            => 'LundSite\Controller\Factory\ShowroomControllerFactory',
        'LundSite\Controller\Slider'              => 'LundSite\Controller\Factory\SliderControllerFactory',
        'LundSite\Controller\Testimonial'         => 'LundSite\Controller\Factory\TestimonialControllerFactory',
        'LundSite\Controller\ProductQa'           => 'LundSite\Controller\Factory\ProductQaControllerFactory',
        'LundSite\Controller\CustomerReview'      => 'LundSite\Controller\Factory\CustomerReviewControllerFactory',
        'LundSite\Controller\VideoTestimonials'   => 'LundSite\Controller\Factory\VideoTestimonialsControllerFactory',
        'LundSite\Controller\ComparisonChart'     => 'LundSite\Controller\Factory\ComparisonChartControllerFactory',
    ),
);
