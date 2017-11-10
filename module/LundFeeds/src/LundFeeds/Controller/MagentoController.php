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
use LundFeeds\Magento\MagentoFactory;
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
class MagentoController extends AbstractActionController
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
     * Generate Magento Parts File file with given version from CLI.
     * @return void
     */
    public function generatemagentoPartsAction()
    {
        $version      = $this->getRequest()->getParam('version');
        $brand        = $this->getRequest()->getParam('brand');
        $generate     = $this->getRequest()->getParam('generate');
        $changeset_id = $this->getRequest()->getParam('changeset_id');

        $magento = MagentoFactory::getMagento(
            $version,
            $this->getServiceLocator()->get('LundProducts\Service\PartService'),
            $this->getServiceLocator()->get('LundFeeds\Service\MagentoService'),
            $this->getServiceLocator()->get('LundProducts\Repository\BrandsRepository'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetsService'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetDetailsService'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetDetailsVehiclesService'),
            $this->getServiceLocator()->get('LundProducts\Service\ProductLineService'),
            $this->getServiceLocator()->get('LundProducts\Service\ProductLineFeatureService'),
            $this->getServiceLocator()->get('LundProducts\Service\BrandProductCategoryService'),
            $brand,
            $generate,
            $changeset_id,
            $this->config
        );

        $magentoExt = ($version == 'csv' ? 'csv' : 'xml');

        $filename = 'MagentoParts_' . $version . '_' . strtolower(str_replace(' ', '', $brand)) . '_' . $generate . '_' . date('Ymdhis') . '.' . $magentoExt;

        // generate audit log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'Magento Parts Generation',
            'summary'   => 'Started Magento Parts generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);

        $filepath = realpath(__DIR__ . '/../../../../../data/magento/' . $version) . '/' . $filename;

        $filesave =  $magento->savePartsCSV($filepath);

        // move magento file to public dir
        shell_exec('cp ' . $filepath . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/magento') . '/' . $filename);

        // create asset
        $hashPath = 'library/products/magento/'.$filename;
        $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
        $hash = rtrim($hash, '.');
        $hash = 'l1_'.$hash;

        $mime = ($version == 'csv' ? 'text/csv' : 'application/xml');

        $asset = $this->assetService->saveFile('library/products/magento', $filename, ['mime'     => $mime,
                                                                                    'size'     => filesize($filepath),
                                                                                    'ext'      => $magentoExt,
                                                                                    'filetype' => 'magento'], $hash);

        if ($changeset_id > 0) {
            $changesets = $this->changesetsService->getChangeset($changeset_id);
        } else {
            $changesets = null;
        }

        // create file_log
        $fileLog = $this->fileLogService->create(['brand' => $brand, // string,
                                                  'type'  => 'magento-' . $generate . ($version == 'csv' ? '-csv' : '-xml'),
                                                  'changesets' => $changesets,
                                                  'asset' => $asset, ]); // obj ref]);

        // generate audit log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'Magento Parts Generation',
            'summary'   => 'Finished Magento Parts generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);
    }

    /*
     * Generate Magento Brands File file with given version from CLI.
     * @return void
     */
    public function generatemagentoBrandsAction()
    {
        $version      = $this->getRequest()->getParam('version');
        $brand        = $this->getRequest()->getParam('brand');
        $generate     = $this->getRequest()->getParam('generate');
        $changeset_id = $this->getRequest()->getParam('changeset_id');

        $magento = MagentoFactory::getMagento(
            $version,
            $this->getServiceLocator()->get('LundProducts\Service\PartService'),
            $this->getServiceLocator()->get('LundFeeds\Service\MagentoService'),
            $this->getServiceLocator()->get('LundProducts\Repository\BrandsRepository'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetsService'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetDetailsService'),
            $this->getServiceLocator()->get('LundProducts\Service\ChangesetDetailsVehiclesService'),
            $this->getServiceLocator()->get('LundProducts\Service\ProductLineService'),
            $this->getServiceLocator()->get('LundProducts\Service\ProductLineFeatureService'),
            $this->getServiceLocator()->get('LundProducts\Service\BrandProductCategoryService'),
            $brand,
            $generate,
            $changeset_id,
            $this->config
        );

        $magentoExt = ($version == 'csv' ? 'csv' : 'xml');

        $filename = 'MagentoBrands_' . $version . '_' . strtolower(str_replace(' ', '', $brand)) . '_' . $generate . '_' . date('Ymdhis') . '.' . $magentoExt;

        // generate audit log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'Magento Brands Generation',
            'summary'   => 'Started Magento Brands generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);

        $filepath = realpath(__DIR__ . '/../../../../../data/magento/' . $version) . '/' . $filename;

        $filesave =  $magento->saveBrandsCSV($filepath);

        // move magento file to public dir
        shell_exec('cp ' . $filepath . ' ' . realpath(__DIR__ . '/../../../../../public/assets/library/products/magento') . '/' . $filename);

        // create asset
        $hashPath = 'library/products/magento/'.$filename;
        $hash = strtr(base64_encode($hashPath), '+/=', '-_.');
        $hash = rtrim($hash, '.');
        $hash = 'l1_'.$hash;

        $mime = ($version == 'csv' ? 'text/csv' : 'application/xml');

        $asset = $this->assetService->saveFile('library/products/magento', $filename, ['mime'     => $mime,
                                                                                    'size'     => filesize($filepath),
                                                                                    'ext'      => $magentoExt,
                                                                                    'filetype' => 'magento'], $hash);

        if ($changeset_id > 0) {
            $changesets = $this->changesetsService->getChangeset($changeset_id);
        } else {
            $changesets = null;
        }

        // create file_log
        $fileLog = $this->fileLogService->create(['brand' => $brand, // string,
                                                  'type'  => 'magento-' . $generate . ($version == 'csv' ? '-csv' : '-xml'),
                                                  'changesets' => $changesets,
                                                  'asset' => $asset, ]); // obj ref]);

        // generate audit log entry
        $this->auditService->create([
            'createdBy' => 'system',
            'object'    => 'LundFeeds',
            'action'    => 'Magento Brands Generation',
            'summary'   => 'Finished Magento Brands generation for file \'' . $filename . '\'',
            'result'    => 'success',
        ]);
    }
}
