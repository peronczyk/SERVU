<?php

declare(strict_types=1);

class ModulesHandler {
	private $active_module;
	private $modules_configs = [];
	private $modules_dir;
	private $config_file_name;


	public function __construct(DependencyContainer $dependencies, string $modules_dir, string $config_file_name) {
		$dependencies->register($this);

		$this->active_module = $this->_core->get_first_of_processed_request();
		$this->modules_dir = $modules_dir;
		$this->config_file_name = $config_file_name;
	}


	/**
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


	/**
	 * Create routes
	 */

	public function createRoutes(Router $router) {
		$module = $this->active_module;

		if (!empty($module)) {
			if (!isset($this->modules_configs[$module]) || !is_array($this->modules_configs[$module])) {
				throw new Exception("Selected module '{$module}' does not have valid configuration.");
			}

			$module_config = $this->modules_configs[$module];

			if (!isset($module_config['routes']) || !is_array($module_config['routes']) || count($module_config['routes']) < 1) {
				throw new Exception("Selected module '{$module}' does not have any routes set.");
			}

			$this->_core->shift_processed_request();

			foreach ($module_config['routes'] as $route) {
				$router->add($route);
			}
		}
	}
}