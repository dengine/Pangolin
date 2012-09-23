<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

class Request
{

    private $_params;
    public $cookie;

    public function __construct(array $params)
    {
        $this->_params  = $params;
        $this->cookie   = new Http\Cookie();
        $this->session  = new Http\Session();
    }

    public function isPost()
    {
        return strtolower($_SERVER['REQUEST_METHOD']) == 'post';
    }

    public function get($param)
    {
        return array_key_exists($param, $this->_params) ? $this->_params[$param] : null;
    }

    public function post($param)
    {
        return isset($_POST[$param]) ? $_POST[$param] : null;
    }

}
