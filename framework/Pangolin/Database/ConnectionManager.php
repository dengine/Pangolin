<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Database;

class ConnectionManager {

    const DEFAULT_CONNECTION = 0;

    private $_connectionList = array();

    public function getConnection($connectionId = self::DEFAULT_CONNECTION)
    {
        if (isset($this->_connectionList[$connectionId])) {
            return $this->_connectionList[$connectionId];
        }
        throw new \Exception('No connections');
    }

    public function createConnection($connectionString)
    {
        $host       = '127.0.0.1';
        $port       = '';
        $login      = '';
        $password   = '';
        $database   = '';
        $driver     = '';

        $auth = '';
        $temp = '';

        if (strpos($connectionString, '://') !== false) {

            list($driver, $temp) = explode('://', $connectionString);

            if (strpos($temp, '/') !== false) {
                list($temp, $database) = explode('/', $temp);
            }

            if (strpos($temp, '@') !== false) {
                list($auth, $temp) = explode('@', $temp);
            }

            if (strpos($auth, ':') !== false) {
                list($login, $password) = explode(':', $auth);
            } else {
                $login = $auth;
            }

            if (strpos($temp, ':') !== false) {
                list($host, $port) = explode(':', $temp);
            } else {
                $host = $temp;
            }
        } else {
            throw new \Exception('Connection string syntax error');
        }

        try {
            $pdo = new \PDO("{$driver}:dbname={$database};host={$host};port={$port}", $login, $password);
            $this->_connectionList[] = new Connection($pdo);
        } catch (\PDOException $e) {
            throw new \Exception("Database: {$e->getMessage()}", $e->getCode());
        }
    }

}
