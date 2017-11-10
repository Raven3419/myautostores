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

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Mvc\Controller\AbstractActionController;
use RecursiveIteratorIterator,
    RecursiveDirectoryIterator;

/**
 * Monitor upload directories controller for LundCustomer module
 *
 * @category   Zend
 * @package    LundCustomer
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

    /**
     * Monitor the customer file directory.
     * Called by shell script/cron job
     */
    public function monitorcustomerAction()
    {
        $dirname = $this->getRequest()->getParam('dirname');

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dirname)
        );

        foreach ($files as $file) {
            if ($file->getExtension() == 'trg') {
                // FOUND TRIGGER FILE
                exit();
            }
        }

        foreach ($files as $file) {
            if (!in_array(strtolower($file->getExtension()), $this->_extensions)) {
                continue;
            }

            // CREATE TRIGGER FILE
            shell_exec('touch ' . $dirname . '/customer.trg');

            // TODO: launch parse customer action in separate proc, via shell_exec()
            $cust_shell_command = 'export APP_ENV="' .getenv('APP_ENV') . '" && export APP_SITE="' .getenv('APP_SITE') . '" && php public/index.php parse customer ' .$file->getRealPath() . '';
            echo $cust_shell_command;exit;
            $cust_shell_output = shell_exec($cust_shell_command);
            //error_log(print_r($file->getRealPath(), true));
        }
    }
}
