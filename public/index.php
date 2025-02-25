<?php

/**
*  * Zend Developer Tools
*   * If server version of PHP is lower than 5.4.0 add the following in your index.php
*    */
define('REQUEST_MICROTIME', microtime(true));
//$_SERVER['APP_ENV'] = 'development';
/**
*  * Display all errors when APP_ENV is development.
*   */
if ($_SERVER['APP_ENV'] == 'development') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}
else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    ini_set("display_errors", 0);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));
define('ZF_CLASS_CACHE', 'data/cache/classes.php.cache'); if (file_exists(ZF_CLASS_CACHE)) require_once ZF_CLASS_CACHE;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
