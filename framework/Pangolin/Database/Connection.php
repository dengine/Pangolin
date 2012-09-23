<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Database;

class Connection implements IConnection
{

    private $_pdoObject;

    public function __construct(\PDO $pdoObject)
    {
        $this->_pdoObject = $pdoObject;
    }

    public function query($query)
    {
        $result = $this->_pdoObject->query($query, \PDO::FETCH_CLASS, 'stdClass');
        if ($result == false) {
            $errorInfo = $this->_pdoObject->errorInfo();
            throw new \Exception("Database: {$errorInfo[2]}");
        }
        return $result;
    }

    public function prepare($prepare)
    {
        return $this->_pdoObject->prepare($prepare);
    }

    public function lastInsertId()
    {
        return $this->_pdoObject->lastInsertId();
    }

}
