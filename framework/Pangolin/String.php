<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

class String implements \ArrayAccess
{
    
    private $data;

    public function __construct($data = '')
    {
        $this->data = (string) $data;
    }
    
    public function __toString()
    {
        return $this->data;
    }
    
    /**
     * Возвращает длину строки
     * 
     * @return int
     */
    public function length()
    {
        return strlen($this->data);
    }
    
    /**
     * Возвращает подстроку
     * 
     * @param int $start
     * @param int $length
     * @return String
     */
    public function subString($start, $length = null)
    {
        if (is_null($length)) {
            $result = substr($this->data, $start);
        } else {
            $result = substr($this->data, $start, $length);
        }        
        return new self($result);
    }
    
    /**
     * Заменяет все вхождения строки поиска на строку замены
     *
     * @param string $search
     * @param string $replace
     * @return String
     */
    public function replace($search, $replace)
    {
        return new self(str_replace($search, $replace, $this->data));
    }
    
    public static function Join($glue , array $pieces)
    {
        return new self(
            implode($glue, $pieces)
        );
    }
    
    /// <  ArrayAccess implementation  >
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }
    
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }
    
    public function offsetUnset($offset)
    {
        // ...
    }
    
    public function offsetExists($offset)
    {
        return true;
    }
    /// </ ArrayAccess implementation  >
    
}
