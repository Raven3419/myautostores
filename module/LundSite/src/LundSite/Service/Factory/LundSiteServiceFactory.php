<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite\Service
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service\Factory;

use LundSite\Service\LundSiteService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see LundSiteService}.
 */
class LundSiteServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return LundSiteService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $lundSiteService = new LundSiteService(
            $serviceLocator->get('LundSite\ObjectManager'),
            $serviceLocator->get('LundSite\Service\NewsReleaseService'),
            $serviceLocator->get('LundSite\Service\DealersEdgeService'),
            $serviceLocator->get('LundSite\Service\DriversCouncilService'),
            $serviceLocator->get('LundSite\Service\ProductRegistrationService'),
            $serviceLocator->get('LundSite\Service\SupportRequestService'),
            $serviceLocator->get('LundSite\Service\ContactSubmissionService'),
            $serviceLocator->get('LundSite\Service\ShowroomService'),
            $serviceLocator->get('LundSite\Service\SliderService'),
            $serviceLocator->get('LundSite\Service\TestimonialService'),
            $serviceLocator->get('LundSite\Service\SpecialOffersService'),
            $serviceLocator->get('LundSite\Service\FaqService'),
            $serviceLocator->get('LundSite\Service\FaqHeadersService'),
            $serviceLocator->get('LundSite\Service\ProductQaService'),
            $serviceLocator->get('LundSite\Service\CustomerReviewService'),
            $serviceLocator->get('LundSite\Service\VideoTestimonialsService'),
            $serviceLocator->get('LundSite\Service\ComparisonChartService')
        );

        return $lundSiteService;
    }
}
