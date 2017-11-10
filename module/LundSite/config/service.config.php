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
    'abstract_factories' => array(
        'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        'Zend\Log\LoggerAbstractServiceFactory',
    ),
    'aliases' => array(
        'LundSite\ObjectManager' => 'Doctrine\ORM\EntityManager',
    ),
    'invokables' => array(
        'LundSite\Entity\NewsReleasePrototype'         => 'LundSite\Entity\NewsRelease',
        'LundSite\Entity\ContactSubmissionPrototype'   => 'LundSite\Entity\ContactSubmission',
        'LundSite\Entity\DealersEdgePrototype'         => 'LundSite\Entity\DealersEdge',
        'LundSite\Entity\DriversCouncilPrototype'      => 'LundSite\Entity\DriversCouncil',
        'LundSite\Entity\FaqPrototype'         		   => 'LundSite\Entity\Faq',
        'LundSite\Entity\FaqHeadersPrototype'         		   => 'LundSite\Entity\FaqHeaders',
        'LundSite\Entity\ProductRegistrationPrototype' => 'LundSite\Entity\ProductRegistration',
        'LundSite\Entity\SpecialOffersPrototype'       => 'LundSite\Entity\SpecialOffers',
        'LundSite\Entity\SupportRequestPrototype'      => 'LundSite\Entity\SupportRequest',
        'LundSite\Entity\ShowroomPrototype'            => 'LundSite\Entity\Showroom',
        'LundSite\Entity\SliderPrototype'              => 'LundSite\Entity\Slider',
        'LundSite\Entity\TestimonialPrototype'         => 'LundSite\Entity\Testimonial',
        'LundSite\Entity\ProductQaPrototype'           => 'LundSite\Entity\ProductQa',
        'LundSite\Entity\CustomerReviewPrototype'      => 'LundSite\Entity\CustomerReview',
        'LundSite\Entity\VideoTestimonialsPrototype'   => 'LundSite\Entity\VideoTestimonials',
        'LundSite\Entity\ComparisonChartPrototype'     => 'LundSite\Entity\ComparisonChart',
    ),
    'factories' => array(
        'LundSite\Repository\NewsReleaseRepository'         => 'LundSite\Repository\Factory\NewsReleaseRepositoryFactory',
        'LundSite\Service\NewsReleaseService'               => 'LundSite\Service\Factory\NewsReleaseServiceFactory',
        'LundSite\Repository\ContactSubmissionRepository'   => 'LundSite\Repository\Factory\ContactSubmissionRepositoryFactory',
        'LundSite\Service\ContactSubmissionService'         => 'LundSite\Service\Factory\ContactSubmissionServiceFactory',
        'LundSite\Repository\DealersEdgeRepository'         => 'LundSite\Repository\Factory\DealersEdgeRepositoryFactory',
        'LundSite\Service\DealersEdgeService'               => 'LundSite\Service\Factory\DealersEdgeServiceFactory',
        'LundSite\Repository\DriversCouncilRepository'      => 'LundSite\Repository\Factory\DriversCouncilRepositoryFactory',
        'LundSite\Service\DriversCouncilService'            => 'LundSite\Service\Factory\DriversCouncilServiceFactory',
        'LundSite\Repository\FaqRepository'         		=> 'LundSite\Repository\Factory\FaqRepositoryFactory',
        'LundSite\Service\FaqService'               		=> 'LundSite\Service\Factory\FaqServiceFactory',
        'LundSite\Repository\FaqHeadersRepository'         		=> 'LundSite\Repository\Factory\FaqHeadersRepositoryFactory',
        'LundSite\Service\FaqHeadersService'               		=> 'LundSite\Service\Factory\FaqHeadersServiceFactory',
        'LundSite\Repository\ProductRegistrationRepository' => 'LundSite\Repository\Factory\ProductRegistrationRepositoryFactory',
        'LundSite\Service\ProductRegistrationService'       => 'LundSite\Service\Factory\ProductRegistrationServiceFactory',
        'LundSite\Repository\SpecialOffersRepository'      	=> 'LundSite\Repository\Factory\SpecialOffersRepositoryFactory',
        'LundSite\Service\SpecialOffersService'           	=> 'LundSite\Service\Factory\SpecialOffersServiceFactory',
        'LundSite\Repository\SupportRequestRepository'      => 'LundSite\Repository\Factory\SupportRequestRepositoryFactory',
        'LundSite\Service\SupportRequestService'            => 'LundSite\Service\Factory\SupportRequestServiceFactory',
        'LundSite\Repository\AboutHouseholdRepository'      => 'LundSite\Repository\Factory\AboutHouseholdRepositoryFactory',
        'LundSite\Repository\LifestyleHouseholdRepository'  => 'LundSite\Repository\Factory\LifestyleHouseholdRepositoryFactory',
        'LundSite\Service\LundSiteService'                  => 'LundSite\Service\Factory\LundSiteServiceFactory',
        'LundSite\Service\ShowroomService'                  => 'LundSite\Service\Factory\ShowroomServiceFactory',
        'LundSite\Repository\ShowroomRepository'            => 'LundSite\Repository\Factory\ShowroomRepositoryFactory',
        'LundSite\Service\SliderService'                    => 'LundSite\Service\Factory\SliderServiceFactory',
        'LundSite\Repository\SliderRepository'              => 'LundSite\Repository\Factory\SliderRepositoryFactory',
        'LundSite\Service\TestimonialService'               => 'LundSite\Service\Factory\TestimonialServiceFactory',
        'LundSite\Repository\TestimonialRepository'         => 'LundSite\Repository\Factory\TestimonialRepositoryFactory',
        'LundSite\Repository\ProductQaRepository'         	=> 'LundSite\Repository\Factory\ProductQaRepositoryFactory',
        'LundSite\Service\ProductQaService'               	=> 'LundSite\Service\Factory\ProductQaServiceFactory',
        'LundSite\Repository\CustomerReviewRepository'      => 'LundSite\Repository\Factory\CustomerReviewRepositoryFactory',
        'LundSite\Service\CustomerReviewService'            => 'LundSite\Service\Factory\CustomerReviewServiceFactory',
        'LundSite\Repository\VideoTestimonialsRepository'   => 'LundSite\Repository\Factory\VideoTestimonialsRepositoryFactory',
        'LundSite\Service\VideoTestimonialsService'         => 'LundSite\Service\Factory\VideoTestimonialsServiceFactory',
        'LundSite\Repository\ComparisonChartRepository'     => 'LundSite\Repository\Factory\ComparisonChartRepositoryFactory',
        'LundSite\Service\ComparisonChartService'           => 'LundSite\Service\Factory\ComparisonChartServiceFactory',
    ),
);
