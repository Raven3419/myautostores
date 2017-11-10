<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Service
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundProducts\Service\Factory;

use LundProducts\Service\PromoService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see PromoService}
 */
class PromoServiceFactory implements FactoryInterface
{
    /**
     * Create Promo service from factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PromoService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $promoService = new PromoService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('LundProducts\Repository\PromoRepository'),
            $serviceLocator->get('LundProducts\Repository\PartsRepository'),
            $serviceLocator->get('LundProducts\Service\ParseMasterService'),
            $serviceLocator->get('LundProducts\Service\ParseSupplementService'),
            $serviceLocator->get('LundProducts\Repository\PartVehCollectionRepository'),
            $serviceLocator->get('doctrine.entitymanager.orm_default'),
            $serviceLocator->get('LundProducts\Repository\VehCollectionRepository'),
            $serviceLocator->get('RocketAdmin\Service\AuditService'),
            $serviceLocator->get('LundProducts\Repository\BrandsRepository'),
            $serviceLocator->get('LundProducts\Service\ProductLineService')
        );

        return $promoService;
    }
}
