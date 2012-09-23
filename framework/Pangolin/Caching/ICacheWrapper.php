<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Caching;

abstract class ICacheWrapper implements ICache, \ArrayAccess
{

    /// <  Property accessing  >
    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }
    /// </ Property accessing  >

    /// <  Array accessing  >
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetUnset($key)
    {
        $this->delete($key);
    }

    public function offsetExists($key)
    {
        $this->exists($key);
    }
    /// </ Array accessing  >

}
