<?php

/**
 * Default configuration array.
 * All keys will be turned to constants.
 * This configuration can be overwritten by file 'config.php' placed in main
 * directory, which returns array with variables that you want to change.
 *
 * Remember that each of the setting names starts with underscore "_".
 */

$default_config = [

	// Force displaying all errors, warnings and notices
	'_DEBUG' => preg_match('/(localhost|::1|\.dev)$/', @$_SERVER['SERVER_NAME']),

	// Primary module, that will be displayed to user when he enters root app path
	'_DEFAULT_CORE_MODULE' => 'api',

	// Directories
	'_CORE_DIR' => 'core/',
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
	public function init() {
		$this->load_configuration();

		error_reporting(_DEBUG ? E_ALL : 0);
		session_start();

		$this->define_paths();
		$this->define_autoloader();
	}

	/**
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


	/**
	 * App paths definitions required to proper rooting
	 */

	public function define_paths() {

		/**
		 * PROTOCOL (http or https)
		 */

		define('APP_PROTOCOL', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http');


		/**
		 * ROOT URI
		 * This path represents browser address of index.php
		 * Everything after that address is a request.
		 */

		$root_uri = $_SERVER['SERVER_NAME'];
		$script_dirname = dirname($_SERVER['SCRIPT_NAME']);
		if ($script_dirname != '/') $root_uri .= $script_dirname;

		define('APP_ROOT_URI', $root_uri);


		/**
		 * REQUEST URI
		 * Complicated part starts here.
		 */

		// Remove query string and multiple slashes
		$request_uri = explode('?', $_SERVER['REQUEST_URI'])[0];
		$request_uri = preg_replace('#/+#', '/', $request_uri);

		$request_uri_arr = explode('/', trim($request_uri, '/'));
		$root_uri_arr = explode('/', $root_uri);


		/**
		 * Remove common part of ROOT_URI and REQUEST_URI to get clean request.
		 */

		$common_part_end = false;
		foreach($root_uri_arr as $key => $root_uri_chunk) {
			if ($root_uri_chunk == $request_uri_arr[0]) {
				$check = true;
				$n = 0;

				// Now check if rest of the elements are the same
				for ($i = $key; isset($root_uri_arr[$i]); $i++) {
					if ($root_uri_arr[$i] != $request_uri_arr[$n]) {
						$check = false;
						break;
					}
					$n++;
				}
				if ($check) {
					$common_part_end = $n;
					break;
				}
			}
		}

		if ($common_part_end) {
			$request_uri = implode('/', array_slice($request_uri_arr, $common_part_end));

			echo $request_uri;
		}

		define('REQUEST_URI', $request_uri);
	}


	/**
	 * Autoload libs (PSR-0)
	 */

	public function define_autoloader() {
		spl_autoload_register(function($class) {
			$class_path = './' . _LIBS_DIR . str_replace('\\', '/', $class) . '.php';
			if (file_exists($class_path)) include_once($class_path);
		});
	}
}