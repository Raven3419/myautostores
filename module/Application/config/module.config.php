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
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
                'cache' => 'rocket_memcached',
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_entities',
                ),
            ),
        ),
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'rocket_memcached',
                'query_cache'    => 'rocket_memcached',
                'result_cache'   => 'rocket_memcached',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'default_template_suffix'  => 'phtml',
        'not_found_template'       => 'application-error/404',
        'exception_template'       => 'application-error/index',
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'application/layout' => __DIR__ . '/../view/layout/application-layout.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/application-layout.phtml',
            'application-error/404' => __DIR__ . '/../view/application/error/application-404.phtml',
            'application-error/403' => __DIR__ . '/../view/application/error/application-403.phtml',
            'application-error/index' => __DIR__ . '/../view/application/error/application-index.phtml',
            //include(__DIR__ . '/../template_map.php')
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'module_layouts' => array(
        'Application' => 'application/layout',
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../public',
            ),
        ),
        'caching' => array(
            'default' => array(
                'cache'   => 'FilePath',
                'options' => array(
                    'dir' => 'public',
                ),
            ),
        ),
    ),
);
