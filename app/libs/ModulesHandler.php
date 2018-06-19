<?php

class ModulesHandler {
	private $modules_configs = [];
	private $request;
	private $modules_dir;
	private $config_file_name;


	public function __construct(string $request, string $modules_dir, string $config_file_name) {
		$this->request = $request;
		$this->modules_dir = $modules_dir;
		$this->config_file_name = $config_file_name;
	}


	/**
	 * Get configs
	 */

	public function get_configs() : array {
		if (!$this->modules_configs) {
			$directories = scandir($this->modules_dir);

			foreach($directories as $key => $dir) {
				if ($dir == '.' || $dir == '..' || $dir == 'default') {
					continue;
				}

				$module_config_file = $this->modules_dir . $dir . '/' . $this->config_file_name;

				if (is_file($module_config_file)) {
					$this->modules_configs[$dir] = include_once $module_config_file;
				}
			}
		}

		return $this->modules_configs;
	}


	/**
	 * Create routes
	 */

	public function create_routes(Router $router) {
		foreach ($this->modules_configs as $module_config) {
			if (isset($module_config['routes']) && is_array($module_config['routes'])) {
				foreach ($module_config['routes'] as $route) {
					$router->add($route);
				}
			}
		}
	}


	/**
	 *
	 */

	public static function run_module() {
		//die('Module');
	}
}