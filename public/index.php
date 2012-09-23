<?php
/* This file is part of the Pangolin Framework.
 *
 * (c) Karabutin Alex <karabutinalex@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define('DEV_MODE', true);

try {
    require '../framework/Bootstrap.php';
    
    // Routing
    $requestString = '/' . $_SERVER["QUERY_STRING"];
    __('router', new Pangolin\Router());
    $route = __('router')->getRoute($requestString, $_SERVER['REQUEST_METHOD']);

    $controllerName = $route['controller'];
    $actionName     = $route['action'];
    $request        = $route['params'];

    // Templater
    require_once ROOT_DIR .'/vendor/twig/twig/lib/Twig/Autoloader.php';
    __('templater', new Pangolin\Templating\TwigTemplater(
        ROOT_DIR . '/applications/views',
        DEV_MODE ? false : CACHE_DIR . '/compilation_cache'
    ));

    // Controller loader
    $className = '\\Controllers\\' . $controllerName . 'Controller';
    $controller = new $className($controllerName, $actionName);
    $controller->run(new \Pangolin\Request($request));
}
catch (Exception $e) {
    echo "<b>Exception:</b> {$e->getMessage()}";
}

if (DEV_MODE) {
    $time_end = microtime(true);
    printf("\n<hr/>\nExecution time is %.3f seconds\n", $time_end - $time_start);
}