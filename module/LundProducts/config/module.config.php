<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts;

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
        'not_found_template'       => 'admin-error/404',
        'exception_template'       => 'admin-error/index',
        'template_path_stack'      => array(
            'lund-products' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            include(__DIR__ . '/../template_map.php')
        ),
        'strategies'               => array(
            'ViewJsonStrategy',
        ),
    ),
    'module_layouts' => array(
        'LundProducts' => 'admin/layout',
    ),
);
