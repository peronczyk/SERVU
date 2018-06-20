<?php

class Router {
	private $routes = [];
	private $dependencies;
	private $options = [
		'default_method' => 'GET',
	];

	// Custom requirements that should be met by route
	private $requirements = [];


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

		// Set default method
		if (!isset($params['method'])) {
			$params['method'] = $this->options['default_method'];
		}

		array_push($this->routes, $params);
	}


	/**
	 * Add requirement
	 */

	public function add_requirement($name, $operator, $to) : void {
		array_push($this->requirements, [$name, $operator, $to]);
	}


	/**
	 * Check custom requirements
	 */

	private function check_custom_requirements($route) : bool {
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


	/**
	 * Prepare regexp
	 */

	private function prepare_regexp(string $pattern) : string {
		// Turn "(/)" into "/?"
		$pattern = preg_replace('#\(/\)#', '/?', $pattern);

		// Create capture group for ":parameter"
		$allowed_param_chars = '[a-zA-Z0-9\_\-]+';
		$pattern = preg_replace(
			'/:(' . $allowed_param_chars . ')/',   # Replace ":parameter"
			'(?<$1>' . $allowed_param_chars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
			$pattern
		);

		// Add start and end matching
		$pattern_as_regex = "@^" . $pattern . "$@D";

		return $pattern_as_regex;
	}


	/** ----------------------------------------------------------------------------
	 * Run route that matches actual path
	 */

	public function run(string $actual_path) {
		echo '<pre>';
		foreach ($this->routes as $route) {
			//echo $actual_path . ' | ' . $route['path'] . ' &nbsp;&nbsp;|&nbsp;&nbsp; ' . $this->prepare_regexp($route['path']) . '<br>';
			if (
				$route['method'] == $_SERVER['REQUEST_METHOD'] &&
				$this->check_custom_requirements($route) &&
				preg_match($this->prepare_regexp($route['path']), $actual_path, $matches)
			) {
				$route['callback']($this->dependencies, $matches);
				return true;
			}
		}

		throw new Exception("There is no route that matches path: {$actual_path} or that meet the requirements.");
	}
}