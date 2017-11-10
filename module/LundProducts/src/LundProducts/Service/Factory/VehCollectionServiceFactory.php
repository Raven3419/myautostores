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

use LundProducts\Service\VehCollectionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see VehCollectionService}
 */
class VehCollectionServiceFactory implements FactoryInterface
{
    /**
     * Create Vehicle Collection service from factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return VehCollectionService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $vehCollectionService = new VehCollectionService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('LundProducts\Repository\VehCollectionRepository'),
            $serviceLocator->get('LundProducts\Repository\VehYearRepository')
        );

        return $vehCollectionService;
    }
}
