<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Database;

abstract class ActiveRecord
{

    private $_properties = array();
    private $className;
    private static $_connection;

    protected static function GetTableName()
    {
        return '';
    }

    public function __construct($itemId = 0)
    {
        $properties['id'] = $itemId;
        $this->className = get_called_class();
        if ($itemId != 0) {
            $className = $this->className;
            $result = self::$_connection->query(
                "SELECT
                    *
                FROM
                    {$className::GetTableName()}
                WHERE
                    id = {$itemId}
                LIMIT 1
            ");
            if ($result->rowCount()) {
                $this->_properties = $result->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new \Pangolin\NotFoundException(
                    "ActiveRecord: Item #{$itemId} of {$this->getTableName()} not exists"
                );
            }
        }
    }

    public static function Find(array $_conditions, $_limit)
    {
        $conditions = array();
        foreach ($_conditions as $condition) {
            if (!is_null($condition) && is_string($condition)) {
                $conditions[] = "({$condition})";
            }
        }

        $where = '';
        if (count($conditions)) {
            $where = "WHERE ". implode(' AND ', $conditions);
        }

        $limits = '';
        if (!is_null($_limit)) {
            if (is_array($_limit) && count($_limit) == 2) {
                $limits = "LIMIT {$_limit[0]}, {$_limit[1]}";
            } else {
                if (is_array($_limit)) {
                    $limits = "LIMIT {$_limit[0]}";
                } else {
                    $limits = "LIMIT {$_limit}";
                }
            }
        }

        $className = get_called_class();
        $queryResult = self::$_connection->query("
            SELECT *
            FROM {$className::GetTableName()}
            {$where}
            {$limits}
        ");
        unset($conditions);
        $result = array();
        while($item = $queryResult->fetch(\PDO::FETCH_ASSOC)) {
            $instance = new $className();
            $instance->_properties = $item;
            $result[] = $item;
        }
        return $result;
    }

    public static function SetConnection(Connection $connection)
    {
        self::$_connection = $connection;
    }

    public function save()
    {
        if ($this->id == 0) {
            $fields = array();
            $values = array();
            foreach ($this->_properties as $field => $value) {
                if (!is_null($value)) {
                    $fields[] = $field;
                    $values[] = "'{$value}'";
                }
            }
            self::$_connection->query(
                "INSERT INTO {$this->getTableName()}"
                    ." (". implode(', ', $fields) .")"
                    ." VALUES (". implode(', ', $values) .")"
            );
            $this->_properties['id'] = self::$_connection->lastInsertId();
        } else {
            $params = array();
            foreach ($this->_properties as $field => $value) {
                if (!is_null($value)) {
                    $params[] = "{$field} = '{$value}'";
                }
            }
            self::$_connection->query(
                "UPDATE {$this->getTableName()}"
                ." SET " . implode(', ', $params)
                ." WHERE id = {$this->id} LIMIT 1"
            );
        }

    }

    public function delete()
    {
        if ($this->id) {
            self::$_connection->query(
                "DELETE FROM {$this->getTableName()}"
                    ." WHERE id = {$this->id} LIMIT 1"
            );
        }
    }

    public function __get($property)
    {
        return isset($this->_properties[$property]) ? $this->_properties[$property] : null;
    }

    public function __set($property, $value)
    {
        if ($property == 'id') {
            throw new \Exception('ActiveRecord: "id" is read-only property');
        }
        $this->_properties[$property] = $value;
    }
    
    public function __call($method, array $params)
    {
        if (preg_match('/^(get|set)(.*$)/', $method, $matches)) {
            $type = $matches[1];
            $propertyName = $matches[2];
            $propertyName[0] = strtolower($propertyName[0]);

            if ($type == 'get') {
                return $this->$propertyName;
            } elseif (($type == 'set') && count($params) && ($propertyName != 'id')) {
                $this->$propertyName = current($params);
            }
        }
    }

}
