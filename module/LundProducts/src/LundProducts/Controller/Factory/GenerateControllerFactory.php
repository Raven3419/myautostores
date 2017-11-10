<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
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
use Aws\S3\S3Client;

/**
 * GenerateController Factory
 *
 * @category   Zend
 * @package    LundProducts\Controller
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class GenerateControllerFactory implements FactoryInterface
{
    /*
     * @param ServiceLocatorInterface $sl
     *
     * @return GenerateController
     */
    public function createService(ServiceLocatorInterface $sl)
    {
        $sm = $sl->getServiceLocator();

        return new \LundProducts\Controller\GenerateController(
            $sm->get('LundProducts\Service\PartService'),
            $sm->get('RocketAdmin\Service\AuditService'),
            S3Client::factory([
                'key'    => 'AKIAJWVEJYUOKUTX5YTQ',
                'secret' => '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',
            ]),
            $sm->get('RocketDam\Service\AssetService'),
            $sm->get('LundProducts\Service\FileLogService'),
            $sm->get('LundProducts\Service\ChangesetsService'),
            $sm->get('LundProducts\Repository\BrandsRepository')
        );
    }
}
