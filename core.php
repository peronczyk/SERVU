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

	// Force displaying all errors, warnings and notices
	'_DEBUG' => preg_match('/(localhost|::1|\.dev)$/', @$_SERVER['SERVER_NAME']),

	// Primary module, that will be displayed to user when he enters root app path
	'_ENTRY_MODULE' => 'api',

	// Directories
	'_LIBS_DIR' => 'libs/',
	'_MODULES_DIR' => 'modules/',
	'_STORAGE_DIR' => 'storage/',

	// Database file name. You can change this file name to something more complex
	// if you want to be more sure no one will access it from browser.
	'_DB_FILE_NAME' => 'db.sqlite',
];


/**
 * Core class
 */

class Core {
	public function __construct() {
		/**
		 * Configuration defines
		 */
		foreach($GLOBALS['base_config'] as $key => $val) {
			define($key, $val);
		}

		error_reporting(_DEBUG ? E_ALL : 0);
		session_start();

		/**
		 * Autoload libs (PSR-0)
		 */
		spl_autoload_register(function($class) {
			$class_path = './' . _LIBS_DIR . str_replace('\\', '/', $class) . '.php';
			if (file_exists($class_path)) include_once($class_path);
		});
	}
}