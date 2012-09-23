<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Http;

class Session implements ISession
{

    public function __construct()
    {
        session_start();
    }
    public function get($param)
    {
        return array_key_exists($param, $_SESSION) ? $_SESSION[$param] : null;
    }

    public function set($param, $value)
    {
        $_SESSION[$param] = $value;
    }

    public function __get($param)
    {
        return $this->get($param);
    }

    public function __set($param, $value)
    {
        $this->set($param, $value);
    }

}
