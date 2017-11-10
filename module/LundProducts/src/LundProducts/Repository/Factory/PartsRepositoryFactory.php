<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundProducts
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts\Repository
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundProducts\Repository\Factory;

use LundProducts\Repository\PartsRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use PDO;

/**
 * BrandsRepositoryFactory
 *
 * @category   Zend
 * @package    LundProducts\Repository
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PartsRepositoryFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see   FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PartsRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

    	$config = $serviceLocator->get('Config');
    	
    	// initialize PDO for fast DB transactions
    	$connection = $this->getPDOConnection($config['doctrine']['connection']['orm_default']['params']);
    	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

        // initialize logging
        $logger = new \Zend\Log\Logger();

        $dimensions = new \Zend\Log\Writer\Stream('./data/logs/dimensions_parse.log');
        $logger->addWriter($dimensions);
    	
        return new PartsRepository(
            $serviceLocator->get('LundProducts\ObjectManager'),
            $serviceLocator->get('LundProducts\ObjectManager')->getRepository('LundProducts\Entity\Parts'),
            $connection,
            $logger,
            $serviceLocator->get('LundProducts\Repository\ChangesetsRepository'),
            $serviceLocator->get('LundProducts\Service\ParseMasterService')
        );
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
