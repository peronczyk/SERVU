<?php

declare(strict_types=1);

class ModulesHandler {
	private $modules_configs = [];
	private $modules_dir;
	private $config_file_name;


	public function __construct(string $modules_dir, string $config_file_name) {
		$this->modules_dir = $modules_dir;
		$this->config_file_name = $config_file_name;
	}


	/** ----------------------------------------------------------------------------
	 * Get configs
	 */

	public function getConfigs() : array {
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


	/** ----------------------------------------------------------------------------
	 * Create routes
	 */

	public function createRoutes(Router $router) {
		foreach ($this->modules_configs as $dirname => $module_config) {
			if (!empty($module_config['routes']) && is_array($module_config['routes'])) {
				foreach ($module_config['routes'] as $route) {
					$router->add($route);
				}
			}
		}
	}
}