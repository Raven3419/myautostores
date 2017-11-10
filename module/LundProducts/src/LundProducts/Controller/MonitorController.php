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

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use RecursiveIteratorIterator,
    RecursiveDirectoryIterator;

/**
 * Monitor upload directories controller for LundProducts module
 *
 * @category   Zend
 * @package    LundProducts
 * @subpackage Controller
 * @author     Raven Sampson <rsampson@thesmartdata.com>
 * @license    http://framework.zend.com/license/new-bsd New BSD License
 * @version    GIT: $Id$
 * @link       https://github.com/rocketred/www-lunddigitalplatform for the canonical source repository
 */
class MonitorController extends AbstractActionController
{
    /**
     * @var []
     */
    protected $_extensions = ['csv'];
    protected $_extensions2 = ['xml'];

    /**
     * @var []
     */
    protected $_assetExtensions = ['jpg', 'jpeg', 'png', 'gif', 'tiff'];

    /**
     * Monitor the supplement file directory.
     * Called by shell script/cron job
     */
    public function monitorsupplementAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname)
        );

        foreach ($files as $file) {

            if (!in_array(strtolower($file->getExtension()), $this->_extensions)) {
                continue;
            }

            // CREATE TRIGGER FILE
            shell_exec('touch ' . $dirname . '/supplement.trg');

            // TODO: launch parse supplement action in separate proc, via shell_exec()
            $supp_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse supplement ' .$file->getRealPath() . '';
            //echo $supp_shell_command;
            //exit;
            $supp_shell_output = shell_exec($supp_shell_command);
            //error_log(print_r($file->getRealPath(), true));
        }
    }

    /**
     * Monitor the master file directory.
     * Called by shell script/cron job
     */
    public function monitormasterAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname)
        );

        foreach ($files as $file) {
            if (!in_array(strtolower($file->getExtension()), $this->_extensions)) {
                continue;
            }

            // CREATE TRIGGER FILE
            shell_exec('touch ' . $dirname . '/master.trg');

            // TODO: launch parse master action in separate proc, via shell_exec()
            $master_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse master ' .$file->getRealPath() . '';
            $master_shell_output = shell_exec($master_shell_command);
            //error_log(print_r($file->getRealPath(), true));
        }
    }

    /**
     * Monitor the asset directory
     * Called by shell script/cron job
     */
    public function monitorassetsAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryiterator($dirname)
        );

        $hasFile = false;

        foreach ($files as $file) {
            if (!in_array(strtolower($file->getExtension()), $this->_assetExtensions)) {
                continue;
            }

            $hasFile = true;
        }

        if ($hasFile) {
            $asset_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse assets ' . $dirname . '';
            $asset_shell_output = shell_exec($asset_shell_command);
        }
    }
    
    /**
     * Monitor the promo file directory.
     * Called by shell script/cron job
     */
    public function monitorpromoAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');
        //$dirname = '/var/www/sites/SmartData/data/ftp/bpcs/product/supplement';
        
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname)
            );
        

        foreach ($files as $file) {
            if (!in_array(strtolower($file->getExtension()), $this->_extensions)) {
                continue;
            }
            
            // CREATE TRIGGER FILE
            shell_exec('touch ' . $dirname . '/promo.trg');
            
            // TODO: launch parse supplement action in separate proc, via shell_exec()
            $promo_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse promo ' .$file->getRealPath() . '';
            echo $promo_shell_command;
            exit;
            //$promo_shell_output = shell_exec($promo_shell_command);
        }
    }
    
    /**
    * Monitor the sdc file directory.
    * Called by shell script/cron job
    */
    public function monitorsdcpiesAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');
        //print_r(array_diff(scandir($directory), array('..', '.')));exit;
        
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname)
            );
        
        //print_r($files2);exit;
        foreach ($files as $file) {
            
            if (!in_array(strtolower($file->getExtension()), $this->_extensions2)) {
                continue;
            }
            
            // CREATE TRIGGER FILE
            shell_exec('touch ' . $dirname . '/sdcPies.trg');
            
            // TODO: launch parse supplement action in separate proc, via shell_exec()
            $supp_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse sdcpies ' .$file->getRealPath() . '';
            echo $supp_shell_command;
            exit;
            //$supp_shell_output = shell_exec($supp_shell_command);
            //error_log(print_r($file->getRealPath(), true));
        }
    }
    
    /**
     * Monitor the sdc file directory.
     * Called by shell script/cron job
     */
    public function monitorsdcacesAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');
        //print_r(array_diff(scandir($directory), array('..', '.')));exit;
        
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname)
            );
        
        //print_r($files2);exit;
        foreach ($files as $file) {
            
            if (!in_array(strtolower($file->getExtension()), $this->_extensions2)) {
                continue;
            }
            
            // CREATE TRIGGER FILE
            shell_exec('touch ' . $dirname . '/sdcAces.trg');
            
            // TODO: launch parse supplement action in separate proc, via shell_exec()
            $supp_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse sdcaces ' .$file->getRealPath() . '';
            echo $supp_shell_command;
            exit;
            //$supp_shell_output = shell_exec($supp_shell_command);
            //error_log(print_r($file->getRealPath(), true));
        }
    }
}
