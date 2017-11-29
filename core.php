<?php

/**
 * =================================================================================
 *
 * BROM
 * Class : Core
 *
 * =================================================================================
 */

/**
 * DEFAULT CONFIGURATION
 * All keys will be turned to constants.
 * This configuration can be overwritten by file 'config.php' placed in main
 * directory, which should return array with variables that you want to change.
 * Remember that each of the setting names should start with underscore.
 */

$default_config = [

	// Force displaying all errors, warnings and notices
	'_DEBUG' => preg_match('/(localhost|::1|\.dev)$/', @$_SERVER['SERVER_NAME']),

	// Primary module, that will be displayed to user when he enters root app path
	'_DEFAULT_BASE_MODULE' => 'api',

	// Directories
	'_BASE_DIR' => 'base/',
	'_LIBS_DIR' => 'libs/',
	'_MODULES_DIR' => 'modules/',
	'_STORAGE_DIR' => 'storage/',

	// Database file name. You can change this file name to something more complex
	// if you want to be more sure no one will access it from browser.
	'_DB_FILE_NAME' => 'db.sqlite',

	// Decide if debug info will be added to each response
	'_API_DISPLAY_INFO' => true,
];


/**
 * CORE CLASS
 */

class Core {
	public function init() {
		$this->load_configuration();

		error_reporting(_DEBUG ? E_ALL : 0);
		session_start();

		$this->define_paths();
		$this->define_autoloader();
	}

	/** ----------------------------------------------------------------------------
	 * Configuration defines
	 */

	public function load_configuration() {
		$config = $GLOBALS['default_config'];
		if (file_exists('config.php')) {
			$overwrite = include_once('config.php');
			$config = array_merge($config, $overwrite);
		}

		foreach($config as $key => $val) {
			define($key, $val);
		}
	}


	/** ----------------------------------------------------------------------------
	 * App paths definitions required to proper rooting
	 */

	public function define_paths() {

		/**
		 * PROTOCOL (http or https)
		 */

		define('APP_PROTOCOL', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http');


		/**
		 * ROOT URI
		 * This path represents browser location of index.php
		 * Everything after that address is a request.
		 */

		$root_uri = $_SERVER['SERVER_NAME'];
		$script_dirname = dirname($_SERVER['SCRIPT_NAME']);
		if ($script_dirname != '/') $root_uri .= $script_dirname;

		define('APP_ROOT_URI', $root_uri . '/');


		/**
		 * ROOT URL
		 */

		define('APP_ROOT_URL', APP_PROTOCOL . '://' . APP_ROOT_URI);


		/**
		 * REQUEST URI
		 * app_request is created by Mod Rewrite configured in .htaccess file
		 */

		define('REQUEST_URI', @$_GET['app_request']);
	}


	/** ----------------------------------------------------------------------------
	 * Autoload libs (PSR-0)
	 */

	public function define_autoloader() {
		spl_autoload_register(function($class) {
			$class_path = __DIR__ . '/' . _LIBS_DIR . str_replace('\\', '/', $class) . '.php';
			if (file_exists($class_path)) include_once($class_path);
		});
	}


	/**
	 *
	 */

	public function get_modules_list() {
		$directories = scandir(_MODULES_DIR);
		$modules = [];
		$index = 0;

		foreach($directories as $key => $dir) {
			if ($dir == '.' || $dir == '..' || $dir == 'default') continue;

			$module_config_file = _MODULES_DIR . $dir . '/module_config.php';

			if (is_file($module_config_file)) {
				$modules[$index] = include_once($module_config_file);
				$modules[$index]['node'] = $dir;
				$index++;
			}
		}

		return $modules;
	}
}