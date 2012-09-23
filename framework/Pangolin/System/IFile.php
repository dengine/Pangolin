<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin\System;

interface IFile
{

    const READ_ONLY = 'r';

    /**
     * @static
     * @abstract
     * @param $path
     * @param $mode
     * @return IFile
     */
    public static function Open($path, $mode);

    /**
     * @static
     * @abstract
     * @param $path
     * @return bool
     */
    public static function Exists($path);

    /**
     * @static
     * @abstract
     * @param $path
     * @return mixed
     */
    public static function Size($path);

    /**
     * @abstract
     * @param $length
     * @return string
     */
    public function read($length);

    /**
     * @abstract
     * @param $data
     * @param $length
     * @return int
     */
    public function write($data, $length);

    /**
     * @abstract
     * @param $length
     * @return string
     */
    public function readString($length);

    /**
     * @abstract
     * @param $data
     * @param $length
     * @return mixed
     */
    public function writeString($data, $length);

    /**
     * @abstract
     * @param $offset
     * @return mixed
     */
    public function seek($offset);

    /**
     * @abstract
     * @return bool
     */
    public function eof();

    /**
     * @abstract
     * @return mixed
     */
    public function close();

    /**
     * @abstract
     * @return mixed
     */
    public function getFilename();

    /**
     * @abstract
     * @return mixed
     */
    public function getDirectory();

    /**
     * @abstract
     * @return mixed
     */
    public function getPath();

}
