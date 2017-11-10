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

use LundProducts\Service\ProductLineService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PDO;

/**
 * Service factory that instantiates {@see ProductLineService}
 */
class ProductLineServiceFactory implements FactoryInterface
{
	
    /**
     * Create Product Line service from factory
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ProductLineService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
		$config = $serviceLocator->get('Config');
		
		// initialize PDO for fast DB transactions
		$connection = $this->getPDOConnection($config['doctrine']['connection']['orm_default']['params']);
		$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
        $brandsService = new ProductLineService(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('LundProducts\Repository\ProductLinesRepository'),
            $serviceLocator->get('FormElementManager')->get('LundProducts\Form\ProductLineForm'),
            $serviceLocator->get('LundProducts\Service\ProductLineFeatureService'),
            $connection
        );

        return $brandsService;
    }

    /*
     * @param array $config
     *
     * @return PDO
     */
    private function getPDOConnection(array $config)
    {
        $return = new PDO('mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['dbname'],
                          $config['user'],
                          $config['password']);

        return $return;
    }
}
