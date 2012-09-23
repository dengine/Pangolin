<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\System;

class File implements IFile
{

    private $handle;
    private $path;

    private function __construct($fileHandle, $path)
    {
        $this->handle = $fileHandle;
        $this->path = $path;
    }

    /**
     * Открывает файл в нужном режиме
     *
     * @static
     * @param $path
     * @param $mode
     * @return File
     */
    public static function Open($path, $mode)
    {
        return new self(
            fopen($path, $mode),
            $path
        );
    }

    /**
     * Проверяет существование файла
     *
     * @static
     * @param $path
     * @return bool
     */
    public static function Exists($path)
    {
        return file_exists($path);
    }

    /**
     * Возвращает размер файла
     *
     * @static
     * @param $path
     * @return int
     */
    public static function Size($path) {
        return filesize($path);
    }

    /**
     * Читает заданный блок данных из файла
     *
     * @param $length
     * @return string
     */
    public function read($length)
    {
        return fread($this->handle, $length);
    }

    /**
     * Записывает заданный блок данных в файла
     *
     * @param $data
     * @param $length
     * @return int
     */
    public function write($data, $length)
    {
        return fwrite($this->handle, $data, $length);
    }

    /**
     * Читает строку из файла
     *
     * @param $length
     * @return string
     */
    public function readString($length)
    {
        return fgets($this->handle, $length);
    }

    /**
     * Записывает строку в файл (синоним write)
     *
     * @param $data
     * @param $length
     */
    public function writeString($data, $length)
    {
        return fputs($this->handle, $data, $length);
    }

    /**
     * Передвигает курсор на заданное смещение
     *
     * @param $offset
     */
    public function seek($offset)
    {
        fseek($this->handle, $offset);
    }

    /**
     * Проверяет, достигнут ли конец файла
     *
     * @return bool
     */
    public function eof()
    {
        return feof($this->handle);
    }

    /**
     * Закрывает текущий файл
     */
    public function close()
    {
        fclose($this->handle);
    }

    /**
     * Возвращает имя текущего файла
     *
     * @return string
     */
    public function getFilename()
    {
        return basename($this->path);
    }

    /**
     * Возвращает путь к директории с текущим файлом
     *
     * @return string
     */
    public function getDirectory()
    {
        return dirname($this->path);
    }

    /**
     * Возвращает полный путь к файлу
     *
     * @return mixed
     */
    public function getPath() {
        return $this->path;
    }

}
