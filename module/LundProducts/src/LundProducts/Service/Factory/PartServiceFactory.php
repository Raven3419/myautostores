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

use LundProducts\Service\PartService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see PartService}
 */
class PartServiceFactory implements FactoryInterface
{
    /**
     * Create Part service from factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PartService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $partService = new PartService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('LundProducts\Repository\PartsRepository'),
            $serviceLocator->get('FormElementManager')->get('LundProducts\Form\PartForm')
        );

        return $partService;
    }
}
