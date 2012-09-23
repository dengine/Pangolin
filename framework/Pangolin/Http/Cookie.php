<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Http;

class Cookie {

    const Session       = null;
    const OneDay        = 86400;
    const SevenDays     = 604800;
    const ThirtyDays    = 2592000;
    const SixMonths     = 15811200;
    const OneYear       = 31536000;
    const Lifetime      = -1; // 2030-01-01 00:00:00

    public function exists($name)
    {
        return isset($_COOKIE[$name]);
    }

    public function isEmpty($name)
    {
        return empty($_COOKIE[$name]);
    }

    public function get($name, $default = '')
    {
        return (isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default);
    }

    public function set($name, $value, $expiry = self::OneYear, $path = '/', $domain = false)
    {
        $result = false;
        if (!headers_sent()) {
            if ($domain === false) {
                $domain = $_SERVER['HTTP_HOST'];
            }

            if ($expiry === -1) {
                $expiry = 1893456000; // Lifetime = 2030-01-01 00:00:00
            } elseif (is_numeric($expiry)) {
                $expiry += time();
            } else {
                $expiry = strtotime($expiry);
            }
            $result = @setcookie($name, $value, $expiry, $path, $domain);
            if ($result) {
                $_COOKIE[$name] = $value;
            }
        }
        return $result;
    }

    public function delete($key, $path = '/', $domain = false, $removeFromGlobal = false)
    {
        $result = false;
        if (!headers_sent())
        {
            if ($domain === false) {
                $domain = $_SERVER['HTTP_HOST'];
            }
            $result = setcookie($key, '', time() - 3600, $path, $domain);
            if ($removeFromGlobal) {
                unset($_COOKIE[$key]);
            }
        }
        return $result;
    }

}