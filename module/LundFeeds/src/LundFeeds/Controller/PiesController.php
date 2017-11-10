<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
/**
 * PHP version 5.5
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 * @since      File available since Release 1.0.0
 */

namespace LundFeeds\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Console\Request as ConsoleRequest;
use LundFeeds\PIES\PiesFactory;
use RocketDam\Service\AssetService;
use LundProducts\Service\FileLogService;
use LundProducts\Service\ChangesetsService;
use RocketAdmin\Service\AuditService;

/**
 * PIES file generation through CLI.
 *
 * @category   Zend
 * @package    LundFeeds
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class PiesController extends AbstractActionController
{
    /**
     * @var AssetService
     */
    protected $assetService;

    /**
     * @var FileLogService
     */
    protected $fileLogService;

    /**
     * @var AuditService
     */
    protected $auditService;

    /**
     * @var ChangesetsServie
     */
    protected $changesetsService;

    /**
     * @var []
     */
    protected $config;

    /**
     * @param AssetService      $assetService
     * @param FileLogService    $fileLogService
     * @param AuditService      $auditService
     * @param ChangesetsService $changesetsService
     * @param []                $config
     */
    public function __construct(
        AssetService   $assetService,
        FileLogService $fileLogService,
        AuditService   $auditService,
        ChangesetsService $changesetsService,
        $config
    )
    {
        $this->assetService   = $assetService;
        $this->fileLogService = $fileLogService;
        $this->auditService   = $auditService;
        $this->changesetsService = $changesetsService;
        $this->config         = $config;
    }

    /*
     * Generate PIES XML file with given version from CLI.
     * @return void
     */
    public function generatepiesAction()
    {
        $version      = $this->getRequest()->getParam('version');
        $brand        = $this->getRequest()->getParam('brand');
        $generate     = $this->getRequest()->getParam('generate');
        $changeset_id = $this->getRequest()->getParam('changeset_id');

        $pies = PiesFactory::getPies(
            $version,
            $this->getServiceLocator()->get('LundProducts\Service\PartService'),
            $this->getServiceLocator()->get('LundFeeds\Service\PiesService'),
            $this->getServiceLocator()->get('LundProducts\Repository\BrandsRepository'),
            $brand,
            $generate,
            $changeset_id,
            $this->config
        );

        $piesExt = ($version == 'csv' ? 'csv' : 'xml');

        $filename = 'PIES_' . $version . '_' . strtolower(str_replace(' ', '', $brand)) . '_' . $generate . '_' . date('Ymdhis') . '.' . $piesExt;

        // generate audit log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'PIES Generation',
            'summary'   => 'Started PIES generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);

        $filepath = realpath(__DIR__ . '/../../../../../data/pies/' . $version) . '/' . $filename;

        $filesave = ($version == 'csv' ? $pies->saveCSV($filepath) : $pies->saveXML($filepath));

        // move pies file to public dir
        shell_exec('cp ' . $filepath . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/pies') . '/' . $filename);

        // create asset
        $hashPath = 'library/products/pies/'.$filename;
        $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
        $hash = rtrim($hash, '.');
        $hash = 'l1_'.$hash;

        $mime = ($version == 'csv' ? 'text/csv' : 'application/xml');

        $asset = $this->assetService->saveFile('library/products/pies', $filename, ['mime'     => $mime,
                                                                                    'size'     => filesize($filepath),
                                                                                    'ext'      => $piesExt,
                                                                                    'filetype' => 'pies'], $hash);

        if ($changeset_id > 0) {
            $changesets = $this->changesetsService->getChangeset($changeset_id);
        } else {
            $changesets = null;
        }

        // create file_log
        $fileLog = $this->fileLogService->create(['brand' => $brand, // string,
                                                  'type'  => 'pies-' . $generate . ($version == 'csv' ? '-csv' : '-xml'),
                                                  'changesets' => $changesets,
                                                  'asset' => $asset, ]); // obj ref]);

        // generate audit log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'PIES Generation',
            'summary'   => 'Finished PIES generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);
    }
}
