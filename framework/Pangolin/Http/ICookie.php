<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Http;

interface ICookie
{

    public function get($key);
    public function set($key, $value);
    public function delete($key);
    public function exists($key);
    public function isEmpty($key);

}
