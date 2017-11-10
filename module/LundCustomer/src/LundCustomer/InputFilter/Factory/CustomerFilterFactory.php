<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 */
/**
 * LundCustomer
 *
 * @category   Zend
 * @package    LundCustomer\InputFilter
 * @subpackage Factory
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 0.1.0
 */

namespace LundCustomer\InputFilter\Factory;

use LundCustomer\InputFilter\CustomerFilter;
use DoctrineModule\Validator\UniqueObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Service factory that instantiates {@see CustomerFilter}.
 */
class CustomerFilterFactory implements FactoryInterface
{
    /**
     * createService(): defined by FactoryInterface.
     *
     * @see    FactoryInterface::createService()
     * @param  ServiceLocatorInterface $serviceLocator
     * @return CustomerFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $parentLocator      = $serviceLocator->getServiceLocator();
        $customerRepository = $parentLocator->get('LundCustomer\Repository\CustomerRepository');
        $options            = $parentLocator->get('LundCustomer\Options\LundCustomerOptions');

        $emailValidator = new UniqueObject(array(
            'object_manager'    => $parentLocator->get('LundCustomer\ObjectManager'),
            'object_repository' => $customerRepository,
            'fields'            => 'email'
        ));

        return new CustomerFilter($customerRepository, $emailValidator, $options);
    }
}
