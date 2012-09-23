<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Database;

class Repository
{

    private $className;

    public function __construct($className)
    {
        $this->className = "\\Models\\{$className}";
        if (!class_exists($this->className)) {
            throw new \Exception("Model \"{$this->className}\" not found");
        }
    }

    public function findOneBy($condition)
    {
        $className = $this->className;
        return current(
            $className::Find($condition, 1)
        );
    }

    public function findBy($condition, $limit = null)
    {
        $className = $this->className;
        return $className::Find($condition, $limit);
    }

    public function find($itemId)
    {
        $className = $this->className;
        return new $className($itemId);
    }

    public function getList($countOrOffset, $countOnly = null, $condition = array())
    {
        $offset = is_null($countOnly) ? 0 : $countOrOffset;
        $count = is_null($countOnly) ? $countOrOffset : $countOnly;

        $className = $this->className;
        return $className::Find($condition, array($offset, $count));
    }

}
