<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/LundProducts for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use LundProducts\Controller\ImagineController;

/**
 * Controller Factory
 *
 * @category   Zend
 * @package    LundProducts\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/LundProducts for the canonical source repository
 */
class ImagineControllerFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sl
     *
     * @return \LundProducts\Controller\ImagineController
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();
        $em = $sm->get('EventManager');

        $cn = new ImagineController(
            $sm->get('RocketDam\Service\AssetService'),
            $sm->get('RocketAdmin\Imagine')
        );

        $cn->setEventManager($em);

        return $cn;
    }
}
