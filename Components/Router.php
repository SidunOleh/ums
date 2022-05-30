<?php 

namespace Components;

class Router
{
	/** 
     * @var array routes
     */
	private $routes;

	function __construct()
	{
		$this->routes = require_once  'Config/routes.php';
	}

	/**
     * Gets the path out of URL
     *      
     * @return string path
     */
	private function getPath()
	{
		$path = preg_replace("~\?.*~", '', $_SERVER['REQUEST_URI']);

		return $path;
	}

	/**
     * Routing
     *      
     * @return string response
     */
	public function run()
	{
		$path = $this->getPath();

		foreach ($this->routes as $pattern => $route) {
			if(preg_match("~^$pattern$~", $path)) {

				$route = preg_replace("~^$pattern$~", $route, $path);
				$segms = explode('/', $route);

				$controllerName =  'Controllers\\' . ucfirst(array_shift($segms)) . 'Controller';
				$methodName     = array_shift($segms);

				$controller = new $controllerName();

				$response = call_user_func_array([$controller, $methodName], $segms);

				return $response;
			}
		}

		$response = Request::makeError(404, 'Not Found');

		return $response;
	}
}
