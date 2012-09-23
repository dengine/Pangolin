<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\Net;

class Socket
{

    private function __construct($handle)
    {
        $this->handle = $handle;
        if ($this->handle === false) {
            throw new \Exception("Socket: Initialization error");
        }
    }
    
    /**
     * Создать сокет
     * 
     * @param $domain
     * @param $communacationType
     * @param $protocol
     */
    public function Create($domain, $communacationType, $protocol)
    {
        $handle = socket_create($domain, $communacationType, $protocol);
        if ($handle === false) {
            throw new \Exception("Socket: Initialization error");
        }
        return new self($handle);
    }
    
    /**
     * Открывает сокет на указанном порту для принятия соединений
     *
     * @param int $port
     * @param int $backlog
     * @return Socket 
     */
    public function Listen($port, $backlog = 128)
    {
        return new self(
            socket_create_listen($port, $backlog)
        );
    }

    /**
     * Инициировать соедидение на сокете
     *
     * @param $address
     * @param int $port
     * @return bool
     */
    public function connect($address, $port = 0)
    {
        return socket_connect($this->handle, $address, $port);
    }

    /**
     * Отправить данные в подключенный сокет
     *
     * @param $buffer
     * @param $length
     * @param $flags
     * @return int
     */
    public function send($buffer, $length, $flags)
    {
        return socket_send($this->handle, $buffer, $length, $flags);
    }

    /**
     * Получить данные из подлюченного сокета
     *
     * @param $length
     * @param $flags
     * @return bool|string
     */
    public function receive($length, $flags)
    {
        $result = '';
        if (socket_recv($this->handle, $result, $length, $flags) === false) {
            return false;
        }
        return $result;
    }

    /**
     * Закрыть сокет
     */
    public function close()
    {
        socket_close($this->handle);
    }

    /**
     * Принимает соединение на сокете
     * 
     * @return Socket 
     */
    public function accept()
    {
        return new self(socket_accept($this->handle));
    }

    /**
     * Привязывает имя к сокету
     * 
     * @param string $address
     * @param int $port
     * @return bool
     */
    public function bind($address, $port = 0)
    {
        return socket_bind($this->handle, $address, $port);
    }

    /**
     * Читает строку байт максимальной длины length из сокета
     *
     * @param int $length
     * @param int $mode
     * @return string 
     */
    public function read($length, $mode = PHP_BINARY_READ)
    {
        return socket_read($this->handle, $length, $mode);
    }

    /**
     * Запись в сокет
     * 
     * @param string $buffer
     * @param int $length
     * @return int
     */
    public function write($buffer, $length = 0)
    {
        return socket_write($this->handle, $buffer, $length);
    }

    /**
     * Возвращает строку, описывающую ошибку сокета
     * 
     * @return string
     */
    public function getError()
    {
        return socket_strerror(
            socket_last_error($this->handle)         
        );
    }

    /**
     * Очищает ошибку на сокете или последний код ошибки
     */
    public function clearError()
    {
        socket_clear_error($this->handle);
    }

}
