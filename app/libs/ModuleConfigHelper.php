<?php

declare(strict_types=1);

class ModuleConfigHelper {
	protected $directory;
	protected $controller_name;

	/**
	 * Constructor
	 */
	public function __construct(string $dir, string $controller_name) {
		$this->directory = $dir;
		$this->controller_name = $controller_name;
	}

	/**
	 * Closure that simplifies code required to create module config routes.
	 * This code allows of running module controller method when callback is fired.
	 */
	public function PassCallbackMethod(string $method) : callable {
		return function(DependencyContainer $dependencies, array $params) use ($method) {
			$controller_file = $this->directory . '/' . $this->controller_name . '.php';

			if (file_exists($controller_file)) {
				require_once $controller_file;
				$controller = new $this->controller_name($dependencies);
				$controller->$method($params);
			}
			else {
				throw new Exception("Controller for module '{$this->controller_name}' does not exist");
			}
		};
	}
}