<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
    if (!defined('DEV_MODE')) {
        define('DEV_MODE', false);
    }
    
    define('DS', DIRECTORY_SEPARATOR);

    define('ROOT_DIR', realpath(__DIR__ .'/../'));
    define('CACHE_DIR', ROOT_DIR .'/cache');
    define('CONFIG_DIR', ROOT_DIR .'/config');

    if (DEV_MODE) {
        $time_start = microtime(true);
    }
    
    if (!file_exists(ROOT_DIR . '/vendor/composer/ClassLoader.php')) {
        die('Please, do "php composer.phar install"');
    }
    
    // Autoloader
    require ROOT_DIR . '/vendor/composer/ClassLoader.php';
    $loader = new \Composer\Autoload\ClassLoader();
    $loader->add('Pangolin',    ROOT_DIR .'/framework');
    $loader->add('Controllers', ROOT_DIR .'/applications');
    $loader->add('Models',      ROOT_DIR .'/applications');
    $loader->register();
    $loader->setUseIncludePath(true);
    
    // ServiceManager
    // ... quick access
    function __($serviceName, $serviceInstance = null) {
        $serviceManager = \Pangolin\ServiceManager::GetInstance();
        if (!is_null($serviceInstance)) {
            $serviceManager->registerService($serviceName, $serviceInstance);
        }
        if ($serviceInstance === false) {
            $serviceManager->unregisterService($serviceName);
        } else {
            return \Pangolin\ServiceManager::getInstance()
                ->getService($serviceName);
        }
    }
    
    // Caching
    if (extension_loaded('apc')) {
        $cache = new Pangolin\Caching\ApcCache();
    } else {
        $cache = new Pangolin\Caching\FileCache(CACHE_DIR);
    }
    __('cache', $cache);


    // Database
    __('database', new Pangolin\Database\ConnectionManager());
    if (file_exists(ROOT_DIR ."/config/database.json")) {
        $config = json_decode(file_get_contents(ROOT_DIR ."/config/database.json"), true);
        foreach($config as $dbConfig) {
        __('database')->createConnection(
            "{$dbConfig['driver']}://{$dbConfig['username']}:{$dbConfig['password']}@"
            ."{$dbConfig['hostname']}:{$dbConfig['port']}/{$dbConfig['database']}");
        }
        if (count($config)) {
            \Pangolin\Database\ActiveRecord::SetConnection(__('database')->getConnection());
        }
    }