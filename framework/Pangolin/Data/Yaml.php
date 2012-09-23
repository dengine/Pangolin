<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Data;

use Pangolin\Data\Yaml\Spyc;
use Pangolin\System\IFile;

class Yaml implements \ArrayAccess
{

    private $data;

    private function __construct($data)
    {
        if (is_string($data)) {
            $this->data = Spyc::YAMLLoadString($data);
        } elseif (is_array($data)) {
            $this->data = $data;
        } elseif (is_object($data)) {
            $this->data = (array) $data;
        } else {
            throw new \Exception("Invalid data");
        }
    }

    public static function FromString($string)
    {
        return new self($string);
    }

    public static function FromFile(IFile $file)
    {
        $data = '';
        while (!$file->eof()) {
            $data .= $file->read(1024);
        }
        return new self($data);
    }

    public static function FromArray(array $data)
    {
        return new self($data);
    }

    public static function FromObject($data)
    {
        return new self($data);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function __toString()
    {
        return Spyc::YAMLDump($this->data);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset)
    {
        unset($this->data);
    }
}
