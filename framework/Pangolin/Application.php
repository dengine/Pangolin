<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

abstract class Application
{

    private $argCount;
    private $argList;

    public function __construct($argCount, array $argList)
    {
        $this->argCount = $argCount;
        $this->argList = $argList;
        $this->onCreate();
    }

    public function __destruct()
    {
        $this->onDestroy();
    }

    public function getArgCount()
    {
        return $this->argCount;
    }

    final public function getArgString($index)
    {
        return isset($this->argList[$index]) ? $this->argList[$index] : null;
    }

    final public function run()
    {
        $this->onRun();
    }

    abstract protected function onRun();

    protected function onCreate()
    {
    }

    protected function onDestroy()
    {
    }

}
