<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of digitalplatform
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ChangesetsControllerFactory implements FactoryInterface
{
    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $sl
     *
     * @return \LundProducts\Controller\ChangesetsController
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();
        $em = $sm->get('EventManager');

        $cn = new \LundProducts\Controller\ChangesetsController(
            $sm->get('LundProducts\Service\ChangesetsService'),
            $sm->get('LundProducts\Service\ChangesetDetailsService'),
            $sm->get('LundProducts\Service\ChangesetDetailsVehiclesService'),
            $sm->get('LundProducts\Options\LundProductsOptions')
        );

        $em->attach('dispatch', function ($e) use ($cn) {
            $cn->layout()->pageTitle = 'Product System';
            $cn->layout()->pageDescr = 'Product Taxonomy';
        }, 100);

        $cn->setEventManager($em);

        return $cn;
    }
}
