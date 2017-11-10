<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * Lund Digital Platform Application
 *
 * @category   Zend
 * @package    Application
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace Application;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'     => 'Zend\Mvc\Router\Http\Segment',
                'priority' => 100,
                'options'  => array(
                    'route'       => '/[:slugone][/:slugtwo][/:slugthree][/:slugfour][/:slugfive]',
                    'constraints' => array(
                        'slugone'   => '(?!admin)[a-zA-Z][a-zA-Z0-9_-]*',
                        'slugtwo'   => '[a-zA-Z0-9][a-zA-Z0-9&%+_-]*',
                        'slugthree' => '[a-zA-Z0-9][a-zA-Z0-9&%+_-]*',
                        'slugfour'  => '[a-zA-Z0-9][a-zA-Z0-9&%+_-]*',
                        'slugfive'  => '[a-zA-Z0-9][a-zA-Z0-9&%+_-]*',
                        //'slug' => '^(?!admin).*$',
                    ),
                    'defaults'    => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                        'slugone'    => 'index',
                        'slugtwo'    => false,
                        'slugthree'  => false,
                        'slugfour'   => false,
                        'slugfive'   => false,
                    ),
                ),
            ),
        ),
    ),
);
