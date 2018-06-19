<?php

class Router {
	private $actual_path;
	private $routes = [];
	private $dependencies;

	public function __construct(DependencyContainer $dependencies) {
		$this->dependencies = $dependencies;
	}


	/** ----------------------------------------------------------------------------
	 * Add route
	 * @param $params - array that describes route.
	 */

	public function add(array $params) : void {
		if (!isset($params['path'])) {
			throw new Exception("Path is missing in route definition: " . print_r($params, true));
		}
		if (isset($params['callback']) && !is_callable($params['callback'])) {
			throw new Exception("Provided callback for route '{$params['path']}' cannot be run because of it's type.");
		}

		array_push($this->routes, $params);
	}


	/** ----------------------------------------------------------------------------
	 * Run route that matches actual path
	 */

	public function run() {
		foreach ($this->routes as $route) {
			if (isset($route['controller'])) {
				$controller = new $route['controller']();

				if (isset($route['method'])) {
					return $controller->$route['method'];
				}

				return $controller;
			}
			if (isset($route['callback'])) {
				return $route['callback']($this->dependencies);
			}
		}

		throw new Exception("Selected route has no callable function or method.");
	}
}