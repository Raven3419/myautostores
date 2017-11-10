<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundFeeds
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds\Service
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 **/

namespace LundFeeds\Service\Factory;

use LundFeeds\Service\PiesService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see PiesService}
 */
class PiesServiceFactory implements FactoryInterface
{
    /**
     * Create Pies service from factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PiesService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        $piesService = new PiesService(
            $serviceLocator->get('LundProducts\Service\ProductLineFeatureService')
        );

        return $piesService;
    }
}
