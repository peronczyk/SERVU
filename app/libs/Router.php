<?php

declare(strict_types=1);

class Router {
	private $routes = [];
	private $dependencies;
	private $options = [
		'default_method' => 'GET',
	];

	// Custom requirements that should be met by route
	private $requirements = [];


	public function __construct(DependencyContainer $container) {
		$this->dependencies = $container;
	}


	/** ----------------------------------------------------------------------------
	 * Add route
	 * @param Array $params - array that describes route.
	 */

	public function add(array $params) {
		if (!isset($params['path'])) {
			throw new Exception("Path is missing in route definition: " . print_r($params, true));
		}
		if (isset($params['callback']) && !is_callable($params['callback'])) {
			throw new Exception("Provided callback for route '{$params['path']}' cannot be run because of it's type.");
		}

		// Set default method
		if (!isset($params['method'])) {
			$params['method'] = $this->options['default_method'];
		}

		array_push($this->routes, $params);
	}


	/** ----------------------------------------------------------------------------
	 * Add requirement
	 */

	public function addRequirement($name, $operator, $to) {
		array_push($this->requirements, [$name, $operator, $to]);
	}


	/** ----------------------------------------------------------------------------
	 * Check custom requirements
	 */

	private function checkCustomRequirements($route) : bool {
		if (!$this->requirements) {
			return true;
		}

		foreach ($this->requirements as list($var_name, $operator, $compare_to)) {
			if (!isset($route[$var_name])) {
				return true;
			}

			switch ($operator) {
				case '==':
					if ($compare_to == $route[$var_name]) return true; break;

				case '!=':
					if ($compare_to != $route[$var_name]) return true; break;

				case '>':
					if ($compare_to > $route[$var_name]) return true; break;

				case '<':
					if ($compare_to < $route[$var_name]) return true; break;

				case '>=':
					if ($compare_to >= $route[$var_name]) return true; break;

				case '<=':
					if ($compare_to <= $route[$var_name]) return true; break;
			}
		}

		return false;
	}


	/** ----------------------------------------------------------------------------
	 * Prepare regexp
	 */

	private function prepareRegexp(string $pattern) : string {
		// Turn "(/)" into "/?"
		$pattern = preg_replace('#\(/\)#', '/?', $pattern);

		// Create capture group for ":parameter"
		$allowed_param_chars = '[a-zA-Z0-9\_\-]+';
		$pattern = preg_replace(
			'/:(' . $allowed_param_chars . ')/',   // Replace ":parameter"
			'(?<$1>' . $allowed_param_chars . ')', // with "(?<parameter>[a-zA-Z0-9\_\-]+)"
			$pattern
		);

		// Add start and end matching
		$pattern_as_regex = "@^" . $pattern . "$@D";

		return $pattern_as_regex;
	}


	/** ----------------------------------------------------------------------------
	 * Run route that matches actual path
	 */

	public function run(string $request_target) {
		// Find route that matches actual path
		foreach ($this->routes as $route) {
			if (
				$route['method'] == $_SERVER['REQUEST_METHOD'] &&
				$this->checkCustomRequirements($route) &&
				preg_match($this->prepareRegexp($route['path']), $request_target, $matches)
			) {
				// Run callback and inject dependencies and params
				$route['callback']($this->dependencies, $matches);
				return true;
			}
		}

		throw new Exception("There is no route that matches path: '{$request_target}' or that meet the requirements.");
	}

	public function getRoutes() {
		return $this->routes;
	}
}