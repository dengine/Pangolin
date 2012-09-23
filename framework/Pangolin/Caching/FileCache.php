<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Caching;

class FileCache extends ICacheWrapper
{

    private $_cacheDir;

    public function __construct($cacheDir)
    {
        $this->setCacheDirectory($cacheDir);
    }

    public function get($key)
    {
        if (file_exists($this->_cacheDir . DS . $key)) {
            return unserialize(file_get_contents($this->_cacheDir . DS . $key));
        }
        throw new \Exception('FileCache: Item not exists');
    }

    public function set($key, $value, $expirationTime = 0)
    {
        file_put_contents(
            $this->_cacheDir . DS . $key,
            serialize($value)
        );
        return $this;
    }

    public function delete($key)
    {
        unlink($this->_cacheDir . DS . $key);
        return $this;
    }

    public function exists($key)
    {
        return file_exists($this->_cacheDir . DS . $key);
    }

    public function getCacheDirectory()
    {
        return $this->_cacheDir;
    }

    public function setCacheDirectory($path)
    {
        $this->_cacheDir = $path;
        return $this;
    }

}
