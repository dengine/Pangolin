<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Pangolin;

class Router
{

    private $_routes;
    private $_paths;

    public function __construct()
    {
        if (!__('cache')->exists('routes_read') || DEV_MODE) {
            $this->compile();
        }
        $this->_routes  = __('cache')->get('routes_read');
        $this->_paths   = __('cache')->get('routes_write');
    }

    private function compile()
    {
        $routes = \Pangolin\Data\Yaml::FromFile(
            \Pangolin\System\File::Open(CONFIG_DIR . '/routes.yml', \Pangolin\System\IFile::READ_ONLY)
        )->toArray();

        $routesWrite = array();
        $routesReadGet = array();
        $routesReadPost = array();
        foreach($routes as $routeName => $route) {
            // routes_write
            $routesWrite[$routeName] = $route['pattern'];

            // routes_read
            $pattern = $route['pattern'];
            while (preg_match('/\{([\w\d_]+)\}/', $pattern, $matches)) {
                if (isset($route['requirements'][$matches[1]])) {
                    $paramPattern = '(?P<'.$matches[1].'>' . $route['requirements'][$matches[1]] . ')';
                } else {
                    $paramPattern = '(?P<'.$matches[1].'>[\w\d_.-]+)';
                }
                $pattern = str_replace($matches[0], $paramPattern, $pattern);
            }
            $pattern = str_replace('/', '\/', $pattern);
            $pattern = "/^{$pattern}$/";

            if (isset($route['requirements']['_method'])) {
                if ($route['requirements']['_method'] == 'POST') {
                    $routesReadPost[$pattern] = $route['defaults']['_controller'];
                } else {
                    $routesReadGet[$pattern] = $route['defaults']['_controller'];
                }
            } else {
                $routesReadGet[$pattern] = $route['defaults']['_controller'];
                $routesReadPost[$pattern] = $route['defaults']['_controller'];
            }

        }

        __('cache')->set('routes_read', array(
            'GET'   => $routesReadGet,
            'POST'  => $routesReadPost
        ));

        __('cache')->set('routes_write', $routesWrite);
    }

    public function getRoute($requestString, $method)
    {
        $controller = '';
        $action = '';
        $params = '';

        foreach ($this->_routes[$method] as $pattern => $route) {
            if (preg_match($pattern, $requestString, $matches)) {
                list($controller, $action) = explode('::', $route);
                $params = $matches;
                array_shift($params);
                break;
            }
        }

        if ($controller == '') {
            throw new \Exception('Unknown route', 404);
        }

        return array(
            'controller'    => $controller,
            'action'        => $action,
            'params'        => $params
        );
    }

    public function getPath($routeName, array $params = array())
    {
        $path = $this->_paths[$routeName];
        foreach ($params as $param => $value) {
            $path = str_replace("{{$param}}", $value, $path);
        }
        return $path;
    }

}
