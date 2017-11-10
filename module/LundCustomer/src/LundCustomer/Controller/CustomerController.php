<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundCustomer\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use LundCustomer\Service\CustomerService;
use LundCustomer\Entity\CustomerInterface;
use LundCustomer\Options\LundCustomerOptionsInterface;
use LundCustomer\Service\CustomerTransmitService;

/**
 * Customers controller for admin module
 *
 * @category   Zend
 * @package    LundCustomer
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class CustomerController extends AbstractActionController
{
    /**
     * @var \LundCustomer\Service\CustomerService
     */
    protected $customerService;

    /**
     * @var \LundCustomer\Service\CustomerTransmitService
     */
    protected $customerTransmitService;

    /**
     * @var \LundCustomer\Option\LundCustomerOptions
     */
    protected $options;

    /**
     * @param CustomerService              $customerService
     * @param CustomerTransmitService      $customerTransmitServiec
     * @param LundCustomerOptionsInterface $options
     */
    public function __construct(
        CustomerService $customerService,
        CustomerTransmitService $customerTransmitService,
        LundCustomerOptionsInterface $options
    ) {
        $this->customerService = $customerService;
        $this->customerTransmitService = $customerTransmitService;
        $this->options         = $options;
    }

    /**
     * Display a table of customers
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'records' => $this->customerService->getActiveCustomers(),
        ));
    }

    /**
     * View a single customer record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $customerId = (int) $this->params()->fromRoute('id', null);

        if (null === $customerId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/customer');
        }

        $customer = $this->customerService->getCustomer($customerId);

        if (!($customer instanceof CustomerInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/customer');
        }

        $form = $this->customerService->getEditCustomerForm($customerId);

        $transmitLogs = $this->customerTransmitService->getCustomerTransmitLogsByCustomer($customer);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $customerId,
            'customer' => $customer,
            'transmitLogs' => $transmitLogs,
        ));
    }

    /**
     * Create a new customer record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->customerService->getCreateCustomerForm();

        if ($this->request->isPost()) {
            $customer = $this->customerService->create($this->identity(), $this->request->getPost());

            if ($customer instanceof CustomerInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a customer.');

                $customerId = $customer->getCustomerId();
                $customerName = $customer->getName();
                $customerPath = realpath(__DIR__ . '/../../../../../public/assets/library/customers/accounts/' . $customerName);

                if (!is_dir($customerPath)) {
                    mkdir($customerPath);
                    touch($customerPath . '/.gitignore');
                }

                return $this->redirect()->toRoute('rocket-admin/accounts/customer');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new customer.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Edit an existing customer record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $customerId = (int) $this->params()->fromRoute('id', null);

        if (null === $customerId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/customer');
        }

        $customer = $this->customerService->getCustomer($customerId);

        if (!($customer instanceof CustomerInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/customer');
        }

        $form = $this->customerService->getEditCustomerForm($customerId);

        if ($this->request->isPost()) {
            $customer = $this->customerService->edit($this->identity(), $this->request->getPost(), $customer);

            if ($customer instanceof CustomerInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the customer.');

                return $this->redirect()->toRoute('rocket-admin/accounts/customer');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the customer.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
            'customerId' => $customerId,
        ));
    }

    /**
     * Delete an existing customer record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $customerId = (int) $this->params()->fromRoute('id', null);

        if (null === $customerId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/customer');
        }

        $customer = $this->customerService->getCustomer($customerId);

        if (!($customer instanceof CustomerInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/accounts/customer');
        }

        $this->customerService->delete($this->identity(), $customer);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the customer.');

        return $this->redirect()->toRoute('rocket-admin/accounts/customer');
    }
}
