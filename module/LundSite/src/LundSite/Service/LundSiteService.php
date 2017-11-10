<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Service
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Service;

use RocketCms\Entity\SiteInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use DoctrineORMModule\Proxy\__CG__\LundSite\Entity\VideoTestimonials;

/**
 * Service injecting all lund site servies.
 */
class LundSiteService implements EventManagerAwareInterface
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var NewsReleaseService
     */
    protected $newsReleaseService;

    /**
     * @var SpecialOffersService
     */
    protected $specialOffersService;

    /**
     * @var DealersEdgeService
     */
    protected $dealersEdgeService;

    /**
     * @var DriversCouncilService
     */
    protected $driversCouncilService;

    /**
     * @var ProductRegistrationService
     */
    protected $productRegistrationService;

    /**
     * @var SupportRequestService
     */
    protected $supportRequestService;

    /**
     * @var ContactSubmissionService
     */
    protected $contactSubmissionService;

    /**
     * @var ShowroomService
     */
    protected $showroomService;

    /**
     * @var SliderService
     */
    protected $sliderService;

    /**
     * @var TestimonialService
     */
    protected $testimonialService;

    /**
     * @var FaqService
     */
    protected $faqService;
    
    /**
     * @var FaqHeadersService
     */
    protected $faqHeadersService;

    /**
     * @var ProductQaService
     */
    protected $productQaService;

    /**
     * @var CustomerReviewService
     */
    protected $customerReviewService;

    /**
     * @var VideoTestimonialsService
     */
    protected $videoTestimonialsService;

    /**
     * @var ComparisonChartService
     */
    protected $comparisonChartService;

    /**
     * @param ObjectManager $objectManager
     * @param NewsreleaseService $newsReleaseService
     * @param DealersEdgeService $dealersEdgeService
     * @param DriversCouncilService $driversCouncilService
     * @param ProductRegistrationService $productRegistrationService
     * @param SupportRequestService $supportRequestService
     * @param ContactSubmissionService $contactSubmissionService
     * @param ShowroomService $showroomService
     * @param SliderService $sliderService
     * @param TestimonialService $testimonialService
     * @param SpecialOffersService $specialOffersService
     * @param FaqService $faqService
     * @param FaqService $faqHeadersService
     * @param ProductQaService $productQaService
     * @param CustomerReviewService $customerReviewService
     * @param VideoTestimonialsService $videoTestimonialsService
     * @param ComparisonChartService $comparisonChartService
     */
    public function __construct(
        ObjectManager $objectManager,
        NewsReleaseService $newsReleaseService,
        DealersEdgeService $dealersEdgeService,
        DriversCouncilService $driversCouncilService,
        ProductRegistrationService $productRegistrationService,
        SupportRequestService $supportRequestService,
        ContactSubmissionService $contactSubmissionService,
        ShowroomService $showroomService,
        SliderService $sliderService,
        TestimonialService $testimonialService,
        SpecialOffersService $specialOffersService,
        FaqService $faqService,
        FaqHeadersService $faqHeadersService,
        ProductQaService $productQaService,
        CustomerReviewService $customerReviewService,
        VideoTestimonialsService $videoTestimonialsService,
        ComparisonChartService $comparisonChartService
    ) {
        $this->objectManager    = $objectManager;
        $this->newsReleaseService = $newsReleaseService;
        $this->dealersEdgeService = $dealersEdgeService;
        $this->driversCouncilService = $driversCouncilService;
        $this->productRegistrationService = $productRegistrationService;
        $this->supportRequestService = $supportRequestService;
        $this->contactSubmissionService = $contactSubmissionService;
        $this->showroomService = $showroomService;
        $this->sliderService = $sliderService;
        $this->testimonialService = $testimonialService;
        $this->specialOffersServie = $specialOffersService;
        $this->faqService = $faqService;
        $this->faqHeadersService = $faqHeadersService;
        $this->productQaService = $productQaService;
        $this->customerReviewService = $customerReviewService;
        $this->videoTestimonialsService = $videoTestimonialsService;
        $this->comparisonChartService = $comparisonChartService;
    }

    /**
     * Return NewsReleaseService
     *
     * @return NewsReleaseService
     */
    public function getNewsReleaseService()
    {
        return $this->newsReleaseService;
    }

    /**
     * Return FaqService
     *
     * @return FaqService
     */
    public function getFaqService()
    {
        return $this->faqService;
    }
    
    /**
     * Return FaqHeadersService
     *
     * @return FaqHeadersService
     */
    public function getFaqHeadersService()
    {
        return $this->faqHeadersService;
    }

    /**
     * Return ProductQaService
     *
     * @return ProductQaService
     */
    public function getProductQaService()
    {
        return $this->productQaService;
    }

    /**
     * Return CustomerReviewService
     *
     * @return CustomerReviewService
     */
    public function getCustomerReviewService()
    {
        return $this->customerReviewService;
    }

    /**
     * Return VideoTestimonialsService
     *
     * @return VideoTestimonialsService
     */
    public function getVideoTestimonialsService()
    {
        return $this->videoTestimonialsService;
    }

    /**
     * Return ComparisonChartService
     *
     * @return ComparisonChartService
     */
    public function getComparisonChartService()
    {
        return $this->comparisonChartService;
    }

    /**
     * Return SpecialOffersService
     *
     * @return SpecialOffersService
     */
    public function getSpecialOffersService()
    {
        return $this->specialOffersServie;
    }

    /**
     * Return DealersEdgeService
     *
     * @return DealersEdgeService
     */
    public function getDealersEdgeService()
    {
        return $this->dealersEdgeService;
    }

    /**
     * Return DriversCouncilService
     *
     * @return DriversCouncilService
     */
    public function getDriversCouncilService()
    {
        return $this->driversCouncilService;
    }

    /**
     * Returns ProductRegistrationService
     *
     * @return ProductRegistrationService
     */
    public function getProductRegistrationService()
    {
        return $this->productRegistrationService;
    }

    /**
     * Return SupportRequestService
     *
     * @return SupportRequestService
     */
    public function getSupportRequestService()
    {
        return $this->supportRequestService;
    }

    /**
     * Return ContactSubmissionService
     *
     * @return ContactSubmissionService
     */
    public function getContactSubmissionService()
    {
        return $this->contactSubmissionService;
    }

    /**
     * Return ShowroomService
     *
     * @return ShowroomService
     */
    public function getShowroomService()
    {
        return $this->showroomService;
    }

    /**
     * Return SliderService
     *
     * @return SliderService
     */
    public function getSliderService()
    {
        return $this->sliderService;
    }

    /**
     * Return TestimonialService
     *
     * @return TestimonialService
     */
    public function getTestimonialService()
    {
        return $this->testimonialService;
    }

    /**
     * setEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::setEventManager()
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(__CLASS__, get_class($this)));

        $this->eventManager = $eventManager;
    }

    /**
     * getEventManager(): defined by EventManagerAwareInterface.
     *
     * @see    EventManagerAwareInterface::getEventManager()
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }
}
