<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Exception
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundSite\Exception;

class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface
{
    /**
    * @param mixed $newsRelease
    */
    public static function invalidNewsReleaseEntity($newsRelease)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\NewsReleaseInterface',
                is_object($newsRelease) ? get_class($newsRelease) : gettype($newsRelease)
            )
        );
    }

    /**
    * @param mixed $contactSubmission
    */
    public static function invalidContactSubmissionEntity($contactSubmission)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\ContactSubmissionInterface',
                is_object($contactSubmission) ? get_class($contactSubmission) : gettype($contactSubmission)
            )
        );
    }

    /**
    * @param mixed $dealersEdge
    */
    public static function invalidDealersEdgeEntity($dealersEdge)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\DealersEdgeInterface',
                is_object($dealersEdge) ? get_class($dealersEdge) : gettype($dealersEdge)
            )
        );
    }

    /**
    * @param mixed $driversCouncil
    */
    public static function invalidDriversCouncilEntity($driversCouncil)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\DriversCouncilInterface',
                is_object($driversCouncil) ? get_class($driversCouncil) : gettype($driversCouncil)
            )
        );
    }

    /**
    * @param mixed $productRegistration
    */
    public static function invalidProductRegistrationEntity($productRegistration)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\ProductRegistrationInterface',
                is_object($productRegistration) ? get_class($productRegistration) : gettype($productRegistration)
            )
        );
    }

    /**
    * @param mixed $supportRequest
    */
    public static function invalidSupportRequestEntity($supportRequest)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\SupportRequestInterface',
                is_object($supportRequest) ? get_class($supportRequest) : gettype($supportRequest)
            )
        );
    }

    /**
    * @param mixed $aboutHousehold
    */
    public static function invalidAboutHouseholdEntity($aboutHousehold)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\AboutHouseholdInterface',
                is_object($aboutHousehold) ? get_class($aboutHousehold) : gettype($aboutHousehold)
            )
        );
    }

    /**
    * @param mixed $lifestyleHousehold
    */
    public static function invalidLifestyleHouseholdEntity($lifestyleHousehold)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\LifestyleHouseholdInterface',
                is_object($lifestyleHousehold) ? get_class($lifestyleHousehold) : gettype($lifestyleHousehold)
            )
        );
    }

    /**
    * @param mixed $showroom
    */
    public static function invalidShowroomEntity($showroom)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\ShowroomInterface',
                is_object($showroom) ? get_class($showroom) : gettype($showroom)
            )
        );
    }

    /**
    * @param mixed $slider
    */
    public static function invalidSliderEntity($slider)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\SliderInterface',
                is_object($slider) ? get_class($slider) : gettype($slider)
            )
        );
    }

    /**
    * @param mixed $testimonial
    */
    public static function invalidTestimonialEntity($testimonial)
    {
        return new static(
            sprintf(
                '%s does not implement LundSite\Entity\TestimonialInterface',
                is_object($testimonial) ? get_class($testimonial) : gettype($testimonial)
            )
        );
    }
}
