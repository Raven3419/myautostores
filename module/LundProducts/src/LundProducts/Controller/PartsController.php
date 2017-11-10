<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundProducts\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\HelperPluginManager as ViewHelperManager;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use LundProducts\Controller\Options;
use LundProducts\Form\PartForm;
use LundProducts\Service\PartService;
use LundProducts\Service\PartAssetService;
use RocketAdmin\Service\MessageService;

/**
 * Parts controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PartsController extends AbstractActionController
{
    /**
     * @var PartService
     */
    protected $partService;

    /**
     * @var PartAssetService
     */
    protected $partAssetService;

    /**
     * @var \Zend\View\HelperPluginManager
     */
    protected $viewHelperManager;

    /**
     * @param PartService         $partService
     * @param PartAssetService    $partAssetService
     * @param HelperPluginManager $viewHelperManager
     */
    public function __construct(
        PartService       $partService,
        PartAssetService  $partAssetService,
        ViewHelperManager $viewHelperManager)
    {
        $this->partService       = $partService;
        $this->partAssetService  = $partAssetService;
        $this->viewHelperManager = $viewHelperManager;
    }

    /**
     * Display a table of parts
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function indexAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $records = $this->partService->getPartListings($this, (INT)$this->params()->fromQuery('iDisplayLength'),
                                                                  (INT)$this->params()->fromQuery('iDisplayStart'),
                                                                  (INT)$this->params()->fromQuery('sEcho'),
                                                                  (INT)$this->params()->fromQuery('iSortingCols'),
                                                                  (STRING)$this->params()->fromQuery('sSearch'));

            return new JsonModel($records);
        }

        return new ViewModel();
    }

    /**
     * View a single part record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function viewAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $record = $this->partService->getPart($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $form = $this->partService->getEditPartForm($recordId);

        $partAssets = $this->partAssetService->getPartAssetsByPart($record);

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
            'assets'   => $partAssets,
        ));
    }

    /**
     * Upload part assets
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function uploadAction()
    {
        if ($this->request->isPost()) {
            $post = array_merge_recursive(
                $this->request->getPost()->toArray(),
                $this->request->getFiles()->toArray()
            );

            $adapter = new \Zend\File\Transfer\Adapter\Http();
            $adapter->setDestination(dirname(__DIR__).'/../../../../public/assets/library/products/parts/staging');
            $adapter->receive($post['file']['name']);
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/rocket-admin/js/plugins/uploader/plupload.js')
            ->appendFile($base . '/assets/rocket-admin/js/plugins/uploader/plupload.html4.js')
            ->appendFile($base . '/assets/rocket-admin/js/plugins/uploader/plupload.html5.js')
            ->appendFile($base . '/assets/rocket-admin/js/plugins/uploader/jquery.plupload.queue.js');
        $this->viewHelperManager->get('HeadLink')
            ->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$('#file-uploader').pluploadQueue({runtimes : 'html5,html4',url : '/admin/products/parts/upload',max_file_size : '500mb',unique_names : true,filters : [{title : 'Image files', extensions : 'jpg,gif,png,jpeg,tiff,tif'}]});");

        return new ViewModel(array());
    }

    /**
     * Process part assets
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function processAction()
    {
        $asset_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse assets ' . dirname(__DIR__).'/../../../../public/assets/library/products/parts/staging';
        //var_dump($asset_shell_command);exit();
        $asset_shell_output = shell_exec($asset_shell_command);

        if ($asset_shell_output) {
            $this->flashMessenger()->setNamespace('success')
                ->addMessage('Your part assets have been processed.');

            return $this->redirect()->toRoute('rocket-admin/products/parts/upload');
        }
    }

    /**
     * Create a new part record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function createAction()
    {
        $record = new \LundProducts\Entity\Parts();

        $form = $this->partService->getCreatePartForm();

        if ($this->request->isPost()) {
            $post = array_merge_recursive(
                $this->request->getPost()->toArray(),
                $this->request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid()) {
                $this->partService->createPart($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully created a new part.');

                return $this->redirect()->toRoute('rocket-admin/products/parts');
            } else {
                $this->flashMessenger()->setNamespace('error')
                     ->addMessage('There was an error trying to create a new part.');
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('parts[detail]');});", 'text/javascript');

        return new ViewModel(array(
            'record' => $record,
            'form'   => $form,
        ));
    }

    /**
     * Edit an existing part record
     *
     * @return Zend\View\Model\ViewModel|array
     */
    public function editAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $record = $this->partService->getPart($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $form = $this->partService->getEditPartForm($recordId);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->partService->editPart($record, $this->identity());

                $this->flashMessenger()->setNamespace('success')
                     ->addMessage('You have successfully edited a part.');

                return $this->redirect()->toRoute('admin/products/parts');
            } else {
                $this->flashMessenger()->setNamespace('error')
                    ->addMessage('There was an error while attempting to edit a part.');
            }
        }

        $uri = $this->getRequest()->getUri();
        $base = sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
        $this->viewHelperManager->get('HeadScript')
            ->appendFile($base . '/assets/admin/ckeditor/ckeditor.js');
        $this->viewHelperManager->get('InlineScript')
            ->appendScript("$(function () {CKEDITOR.replace('parts[detail]');});", 'text/javascript');

        return new ViewModel(array(
            'record'   => $record,
            'form'     => $form,
            'recordId' => $recordId,
        ));
    }

    /**
     * Disable an existing part record (toggle disabled boolean)
     *
     * @return void
     */
    public function disableAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $record = $this->partService->getPart($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $this->partService->disablePart($record, $this->identity());

        $this->flashMessenger()->setNamespace('success')
             ->addMessage('You have successfully disabled a part.');

        return $this->redirect()->toRoute('rocket-admin/products/parts');
    }

    /**
     * @return Zend\View\Model\ViewModel|array
     */
    public function vehiclesAction()
    {
        $recordId = (int) $this->params('id', null);
        if (null === $recordId) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        $record = $this->partService->getPart($recordId);

        if (null === $record) {
            $this->flashMessenger()->setNamespace('error')
                 ->addMessage('You have attempted to access an invalid record.');

            return $this->redirect()->toRoute('rocket-admin/products/parts');
        }

        return new ViewModel(array(
            'record'   => $record,
            'recordId' => $recordId,
        ));
    }
}
