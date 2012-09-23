<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__ .'/../framework/Bootstrap.php';

define('MIGRATE_DIR', ROOT_DIR . DS .'tools'. DS .'migrations');

try {
    function getMigrationName($filename) 
    {
        if (preg_match('/^(.*)\.sql$/', $filename, $matches)) {
            return $matches[1];
        }
        return null;
    }
    
    function getMigrationVersion()
    {
        if (file_exists(MIGRATE_DIR . DS .'version.lock')) {
            return file_get_contents(MIGRATE_DIR . DS .'version.lock');
        } else {
            return 0;
        }
    }
        
    function updateVersion($version)
    {
        file_put_contents(MIGRATE_DIR . DS .'version.lock', $version);
    }
    
    $migrateList = array_filter(scandir(MIGRATE_DIR), function($name) {
        return !is_null(getMigrationName($name))
            && ($name != '.')
            && ($name != '..');
    });
    sort($migrateList);
    
    $currentVersion = getMigrationVersion();
    $appliedMigrated = 0;
    foreach ($migrateList as $migrate) {
        $data = file_get_contents(MIGRATE_DIR . DS . $migrate);
        if (strcmp($currentVersion, getMigrationName($migrate)) < 0) {
            __('database')->getConnection()->query($data);
            $appliedMigrated++;
            updateVersion(getMigrationName($migrate));
        }
    }
    
    $currentVersion = getMigrationVersion();
    if ($appliedMigrated > 0) {
        echo "Successfully updated to \"{$currentVersion}\".\n";
    } else {
        echo "Installed newest migration.\n";
    }
    
} catch(Exception $e) {
    echo "Exception[{$e->getCode()}]: {$e->getMessage()}";
}