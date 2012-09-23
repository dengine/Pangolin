<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

abstract class Controller implements \ArrayAccess
{

    private $_controllerName;
    private $_actionName;
    private $_templater;
    private $_templateParams = array();

    public function __construct($controllerName, $actionName)
    {
        $this->_controllerName  = $controllerName;
        $this->_actionName      = $actionName;
        $this->_templater       = __('templater');
        $this->preFilter();
    }

    public function preFilter()
    {
        //
    }

    final public function run($request)
    {
        $methodName = $this->getActionName() . 'Action';
        $result = $this->$methodName($request);
        if ($result instanceof Response) {
            if ($result->getCode()) {
                header("HTTP/1.1 {$result->getCode()}");
            }
            echo $result;
        } else {
            throw new \Exception('Result must be instance of "Response"');
        }
    }

    public function getControllerName()
    {
        return $this->_controllerName;
    }

    public function getActionName()
    {
        return $this->_actionName;
    }

    final public function render($templateName = null)
    {
        if (is_null($templateName)) {
            $templateName = strtolower($this->getControllerName()) .'/'. $this->getActionName();
        }
        return new Response($this->_templater->render(
            $this->_templateParams,
            $templateName
        ));
    }

    public function getRepository($modelName)
    {
        return new \Pangolin\Database\Repository($modelName);
    }

    final public function setOutputFormat($format)
    {
        switch ($format) {
            case 'json':
                $this->_templater = new \Pangolin\Templating\JsonTemplater();
                break;
            case 'html':
                $this->_templater = __('templater');
                break;
            default:
                throw new \Exception("Unknown output format");
        }
        return $this;
    }

    // ArrayAccess implementation
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_templateParams);
    }

    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->_templateParams) ? $this->_templateParams[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->_templateParams[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_templateParams[$offset]);
    }

}
