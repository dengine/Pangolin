<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

class ServiceManager
{

    private $_services = array();

    private function __construct()
    {
        //
    }

    public function registerService($serviceName, $instance)
    {
        $this->_services[$serviceName] = $instance;
        return $this;
    }

    public function getService($serviceName)
    {
        if (array_key_exists($serviceName, $this->_services)) {
            return $this->_services[$serviceName];
        }
        throw new \Exception("Unknown service");
    }

    public function unregisterService($serviceName)
    {
        unset($this->_services[$serviceName]);
    }

    // <Singleton>
    private static $_instance;

    public static function GetInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // </Singleton>
}
