<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

class Response
{

    private $_data;
    private $_code;

    public function __construct($data, $code = 0)
    {
        $this->_data = $data;
        $this->_code = $code;
    }

    public function setCode($code)
    {
        $this->_code = $code;
        return $this;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function __toString()
    {
        return $this->_data;
    }

}
