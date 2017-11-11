<?php

/**
 * Default configuration array.
 * All keys will be turned to constants.
 * This configuration can be overwritten by file 'config.php' placed in main
 * directory, which returns array with variables that you want to change.
 *
 * Remember that each of the setting names starts with underscore "_".
 */

$base_config = [
	'_DEFAULT_MODULE' => 'api',
	'_LIBS_DIR' => 'libs/',
	'_MODULES_DIR' => 'modules/',
];


/**
 * Core class
 */

class Core {
	public function __construct() {
		error_reporting(E_ALL);
		session_start();

		/**
		 * Configuration defines
		 */
		foreach($GLOBALS['base_config'] as $key => $val) {
			define($key, $val);
		}

		/**
		 * Autoload libs (PSR-0)
		 */
		spl_autoload_register(function($class) {
			$class_path = './' . _LIBS_DIR . str_replace('\\', '/', $class) . '.php';
			if (file_exists($class_path)) include_once($class_path);
		});
	}
}