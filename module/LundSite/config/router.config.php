<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundSite
 *
 * @category   Zend
 * @package    LundSite
 * @subpackage Config
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundSite;

return array(
    'router' => array(
        'routes' => array(
            'rocket-admin' => array(
                'child_routes' => array(
                    'lund' => array(
                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route'    => '/lund',
                            'defaults' => array(
                                'controller' => 'LundSite\Controller\NewsRelease',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'news-release' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/news-release',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\NewsRelease',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\NewsRelease',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\NewsRelease',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\NewsRelease',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\NewsRelease',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'faq' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/faq',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\Faq',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\Faq',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Faq',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Faq',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Faq',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'customer-review' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/customer-review',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\CustomerReview',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\CustomerReview',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\CustomerReview',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\CustomerReview',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\CustomerReview',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'video-testimonials' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/video-testimonials',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\VideoTestimonials',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\VideoTestimonials',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\VideoTestimonials',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\VideoTestimonials',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\VideoTestimonials',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'product-qa' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/product-qa',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\ProductQa',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\ProductQa',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ProductQa',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ProductQa',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ProductQa',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'special-offers' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/special-offers',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\SpecialOffers',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\SpecialOffers',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\SpecialOffers',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\SpecialOffers',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\SpecialOffers',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'showroom' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/showroom',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\Showroom',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\Showroom',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Showroom',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Showroom',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Showroom',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'slider' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/slider',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\Slider',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\Slider',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Slider',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Slider',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Slider',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'rank-up' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/rank-up/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Slider',
                                                'action'     => 'rankUp',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'rank-down' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/rank-down/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Slider',
                                                'action'     => 'rankDown',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'testimonial' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/testimonial',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\Testimonial',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\Testimonial',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Testimonial',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Testimonial',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Testimonial',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'rank-up' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/rank-up/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Testimonial',
                                                'action'     => 'rankUp',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'rank-down' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/rank-down/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\Testimonial',
                                                'action'     => 'rankDown',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'contact-submission' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/contact-submission',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\ContactSubmission',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\ContactSubmission',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ContactSubmission',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ContactSubmission',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ContactSubmission',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'support-request' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/support-request',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\SupportRequest',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\SupportRequest',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\SupportRequest',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\SupportRequest',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\SupportRequest',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'product-registration' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/product-registration',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\ProductRegistration',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\ProductRegistration',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ProductRegistration',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ProductRegistration',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ProductRegistration',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'dealers-edge' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/dealers-edge',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\DealersEdge',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\DealersEdge',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\DealersEdge',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\DealersEdge',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\DealersEdge',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'comparison-chart' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/comparison-chart',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\ComparisonChart',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\ComparisonChart',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ComparisonChart',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ComparisonChart',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\ComparisonChart',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                            'drivers-council' => array(
                                'type'    => 'Zend\Mvc\Router\Http\Literal',
                                'options' => array(
                                    'route'    => '/drivers-council',
                                    'defaults' => array(
                                        'controller' => 'LundSite\Controller\DriversCouncil',
                                        'action'     => 'index',
                                    ),
                                ),
                                'may_terminate' => true,
                                'child_routes'  => array(
                                    'create' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                            'route'    => '/create',
                                            'defaults' => array(
                                                'controller' => 'LundSite\Controller\DriversCouncil',
                                                'action'     => 'create',
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/edit/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\DriversCouncil',
                                                'action'     => 'edit',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'delete' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/delete/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\DriversCouncil',
                                                'action'     => 'delete',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                    'view' => array(
                                        'type'    => 'Zend\Mvc\Router\Http\Segment',
                                        'options' => array(
                                            'route'       => '/view/:id',
                                            'constraints' => array(
                                                'id' => '[0-9]*',
                                            ),
                                            'defaults'    => array(
                                                'controller' => 'LundSite\Controller\DriversCouncil',
                                                'action'     => 'view',
                                                'id'         => 0,
                                            ),
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
