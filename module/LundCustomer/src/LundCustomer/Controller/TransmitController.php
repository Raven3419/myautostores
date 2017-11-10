<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use LundCustomer\Service\CustomerTransmitService;
use LundCustomer\Service\CustomerService;
use LundCustomer\Entity\CustomerTransmitInterface;
use LundCustomer\Entity\CustomerInterface;

/**
 * LundCustomer
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class TransmitController extends AbstractActionController
{
    /**
     * @var \LundCustomer\Service\CustomerTransmitService
     */
    protected $customerTransmitService;

    /**
     * @var \LundCustomer\Service\CustomerService
     */
    protected $customerService;

    /**
     * @param CustomerTransmitService $customerTransmitService
     * @param CustomerService         $customerService
     */
    public function __construct(
        CustomerTransmitService $customerTransmitService,
        CustomerService $customerService
    ) {
        $this->customerTransmitService = $customerTransmitService;
        $this->customerService = $customerService;
    }

    /**
     * Transmit product data to a customer.
     * Called by shell script/cron job
     */
    public function transmitcustomerAction()
    {
        $frequency = $this->getRequest()->getParam('frequency');

        $customers = $this->customerService->getCustomersByFrequency($frequency);

        if (null != $customers) {
            foreach ($customers as $customer) {
                $this->customerTransmitService->transmit($customer);
            }
        }
    }
}
