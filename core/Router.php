<?php

/**
 * Class to work with HTTP routes
 *
 * Class uses nikic/fast-route package
 *
 * @package  Phonebook
 * @author   Andrey A. Kosinov <aka@portalmaster.ru>
 */

namespace Core;

use Exception;
use Core\Response;

class Router
{

	/**
	 * Array of defined routes
	 * @var array
	 */
	private static $routes = [];

	/**
	 * Add route to array that will be handled later
	 * @param string $method     HTTP method, like GET, POST, PUT and others
	 * @param string $path       URL path, for example '/users'
	 * @param string $controller Link to Controller and method to handle the request in format 'ClassName@method', example: UserController@create
	 */
	public static function add(string $method, string $path, string $controller) {
		self::$routes[] = [
			'method' => $method,
			'path'   => $path,
			'controller' => $controller
		];
	}

	/**
	 * Run handling all added routes
	 * @param  string $routes_file name of the route file to parse. Route file should be placed in folder 'routes'
	 */
	public static function run(string $routes_file) {

		require_once __DIR__.'/../routes/'.$routes_file.'.php';

		$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $router) {
			foreach (static::$routes as $r) {
				$router->addRoute($r['method'], $r['path'], $r['controller']);
			}
		});

		// Fetch method and URI from somewhere
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_URI'];

		// Strip query string (?foo=bar) and decode URI
		if (false !== $pos = strpos($uri, '?')) {
	    	$uri = substr($uri, 0, $pos);
		}
		$uri = rawurldecode($uri);

		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

		switch ($routeInfo[0]) {
		    case \FastRoute\Dispatcher::NOT_FOUND:
		        // 404 Not Found
		        Response::abort(404,'Not found');
		        break;
		    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
		    	// ... 405 Method Not Allowed
		        $allowedMethods = $routeInfo[1];
		        Response::abort(405,'Method not allowed');
		        break;
		    case \FastRoute\Dispatcher::FOUND:
		        $handler = $routeInfo[1];
		        $vars = $routeInfo[2];
		        list($class, $method) = explode('@',$handler);
		        $class = 'App\Controllers\\'.$class;
		        if (class_exists($class)) {
		        	if (method_exists($class, $method)) {
		        		Response::return(call_user_func_array([$class,$method],$vars));
		        	} else {
		        		throw new Exception("Method '$method' not found in class '$class'", 1);
		        	}
		        } else {
		        	throw new Exception("Class '$class' not found", 1);

		        }
		        break;
		}

	}
}