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

use LundSite\Service\NewsReleaseService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see NewsReleaseService}.
 */
class NewsReleaseServiceFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return NewsReleaseService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $newsReleaseService = new NewsReleaseService(
            $serviceLocator->get('LundSite\ObjectManager'),
            $serviceLocator->get('RocketUser\Repository\UserRepository'),
            $serviceLocator->get('RocketCms\Repository\SiteRepository'),
            $serviceLocator->get('LundSite\Repository\NewsReleaseRepository'),
            $serviceLocator->get('FormElementManager')->get('LundSite\Form\NewsReleaseForm')
        );

        $newsReleaseService->setNewsReleasePrototype($serviceLocator->get('LundSite\Entity\NewsReleasePrototype'));

        return $newsReleaseService;
    }
}
