<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * This source file is part of Commander.
 *
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RocketEcom\Service\OrderService;
use RocketEcom\Service\OrderItemService;
use RocketEcom\Entity\OrdersInterface;
use RocketEcom\Entity\OrderItemInterface;
use LundProducts\Service\PartService;
use LundProducts\Entity\PartsInterface;

/**
 * OrderItem controller for admin module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class OrderItemController extends AbstractActionController
{
    /**
     * @var \RocketEcom\Service\OrderService
     */
    protected $orderService;

    /**
     * @var \RocketEcom\Service\OrderItemService
     */
    protected $orderItemService;

    /**
     * @var \LundProducts\Service\PartService
     */
    protected $partService;

    /**
     * @param OrderService     $orderService
     * @param OrderItemService $orderItemService
     * @param PartService      $partService
     */
    public function __construct(
        OrderService $orderService,
        OrderItemService $orderItemService,
        PartService $partService
    ) {
        $this->orderService = $orderService;
        $this->orderItemService = $orderItemService;
        $this->partService = $partService;
    }

    /**
     * Display a table of order items
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        $orderId = (int) $this->params()->fromRoute('id', null);

        if (null === $orderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select an order to access the items.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $order = $this->orderService->getOrder($orderId);

        if (!($order instanceof OrdersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You must first select an order to access the items.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $part = $this->partService;

        return new ViewModel(array(
            'records' => $this->orderItemService->getOrderItemsByOrder($order),
            'part' => $part,
            'order' => $order,
        ));
    }

    /**
     * View a single order record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $orderId = (int) $this->params()->fromRoute('id', null);

        if (null === $orderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $order = $this->orderService->getOrder($orderId);

        if (!($order instanceof OrdersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $form = $this->orderService->getEditOrderForm($orderId);

        return new ViewModel(array(
            'form'     => $form,
            'recordId' => $orderId,
        ));
    }

    /**
     * Create a new order record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $form = $this->orderService->getCreateOrderForm();

        if ($this->request->isPost()) {
            $order = $this->orderService->create($this->identity(), $this->request->getPost());

            if ($order instanceof OrdersInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully created a order.');

                return $this->redirect()->toRoute('rocket-admin/order-system/order');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error creating a new order.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form' => $form,
        ));
    }

    /**
     * Edit an existing order record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $orderId = (int) $this->params()->fromRoute('id', null);

        if (null === $orderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $order = $this->orderService->getOrder($orderId);

        if (!($order instanceof OrdersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $form = $this->orderService->getEditOrderForm($orderId);

        if ($this->request->isPost()) {
            $order = $this->orderService->edit($this->identity(), $this->request->getPost(), $order);

            if ($order instanceof OrdersInterface) {
                $this->flashMessenger()->setNamespace('success')
                    ->addMessage('You have successfully edited the order.');

                return $this->redirect()->toRoute('rocket-admin/order-system/order');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error editing the order.');

                $form->setData($this->request->getPost());
            }
        }

        return new ViewModel(array(
            'form'   => $form,
            'orderId' => $orderId,
        ));
    }

    /**
     * Delete an existing order record (toggle deleted boolean)
     *
     * @return void
     */
    public function deleteAction()
    {
        $orderId = (int) $this->params()->fromRoute('id', null);

        if (null === $orderId) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $order = $this->orderService->getOrder($orderId);

        if (!($order instanceof OrdersInterface)) {
            $this->flashMessenger()->setNamespace('error')
                ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/order-system/order');
        }

        $this->orderService->delete($this->identity(), $order);

        $this->flashMessenger()->setNamespace('success')
            ->addMessage('You have successfully deleted the order.');

        return $this->redirect()->toRoute('rocket-admin/order-system/order');
    }
}
