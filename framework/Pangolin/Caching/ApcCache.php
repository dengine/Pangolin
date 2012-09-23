<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Caching;

class ApcCache extends ICacheWrapper
{

    public function __construct()
    {
        if (!extension_loaded('apc')) {
            throw new \Exception('Cache: Extension \'APC\' not loaded');
        }
    }

    public function get($key)
    {
        return apc_fetch($key);
    }

    public function set($key, $value, $expirationTime = 0)
    {
        apc_store($key, $value, $expirationTime);
    }

    public function delete($key)
    {
       apc_delete($key);
    }

    public function exists($key)
    {
        return apc_exists($key);
    }

}
