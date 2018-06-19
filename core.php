<?php

/**
 * =================================================================================
 *
 * Servant
 * Class : Core
 *
 * =================================================================================
 */

/**
 * DEFAULT CONFIGURATION
 *
 * All keys will be turned to constants.
 * This configuration can be overwritten by file 'config.php' placed in main
 * directory, which should return array with variables that you want to change.
 */

define('DEFAULT_APP_CONFIG', [
	// This variable will be added to meta section of all api request. It also will
	// be displayed on front page of admin panel
	'site_name' => $_SERVER['SERVER_NAME'],

	// Force displaying all errors, warnings and notices
	// by default this mode is turned on when working on localhost
	'debug' => preg_match('/(localhost|::1|\.dev)$/', @$_SERVER['SERVER_NAME']),

	// Send security headers and remove ones that can potentially expose
	// vulnerabilities. Learn more: https://securityheaders.io
	'secure_headers' => true,

	// Force HTTPS
	'force_https' => true,

	// Primary module, that will be displayed to user when he enters root app path
	'default_base_module' => 'api',

	// Storage directory
	// It contains SQLite database and uploaded files
	'storage_dir' => 'storage/',

	// App directory
	'app_dir' => 'app/',

	// Subdirectories of app directory
	'admin_dir' => 'admin/',
	'api_dir' => 'api/',
	'libs_dir' => 'libs/',
	'modules_dir' => 'modules/',

	// Each of the modules config filename
	'modules_config_filename' => 'config.php',

	// Database file name. You can change this file name to something more complex
	// if you want to be more sure no one will access it from browser.
	'db_file_name' => 'db.sqlite',
]);


/**
 * CORE CLASS
 */

class Core {

	private $autoloaded_classes = [];


	/** ----------------------------------------------------------------------------
	 * Init Core
	 */

	public function init() : void {
		$this->load_configuration();

		if (_CONFIG['debug']) {
			$this->force_display_php_errors();
		}

		$this->start_session();
		$this->define_paths();
		$this->define_autoloader();

		if (_CONFIG['secure_headers']) {
			$this->secure_headers();
		}

		if (_CONFIG['force_https']) {
			$this->force_https();
		}
	}

	/** ----------------------------------------------------------------------------
	 * Configuration defines
	 */

	private function load_configuration() : bool {
		if (file_exists('config.php')) {
			$overwrite = include_once 'config.php';
			define('_CONFIG', array_merge(DEFAULT_APP_CONFIG, $overwrite));
			return true;
		}
		else {
			define('_CONFIG', DEFAULT_APP_CONFIG);
			return false;
		}
	}


	/** ----------------------------------------------------------------------------
	 * Force display PHP errors
	 */

	public function force_display_php_errors() : void {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}


	/**
	 * Start session
	 */

	private function start_session() : void {
		// Force to use the HTTP-Only and Secure flags when sending the session
		// identifier cookie, which prevents a successful XSS attack from stealing
		// users' cookies and forces them to only be sent over HTTPS, respectively.
		session_start([
			'cookie_httponly' => true,
			'cookie_secure' => true
		]);
	}


	/** ----------------------------------------------------------------------------
	 * App paths definitions required to proper rooting
	 */

	private function define_paths() : void {

		/**
		 * PROTOCOL (http or https)
		 */

		define('PROTOCOL', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http');


		/**
		 * ROOT URI
		 * This path represents browser location of index.php
		 * Everything after that address is a request.
		 */

		$root_uri = $_SERVER['SERVER_NAME'];
		$script_dirname = dirname($_SERVER['SCRIPT_NAME']);
		if ($script_dirname != '/') {
			$root_uri .= $script_dirname;
		}

		define('ROOT_URI', $root_uri . '/');


		/**
		 * ROOT URL
		 */

		define('ROOT_URL', PROTOCOL . '://' . ROOT_URI);


		/**
		 * REQUEST URI
		 * app_request is created by Mod Rewrite configured in .htaccess file
		 */

		define('REQUEST_URI', @$_GET['app_request']);
	}


	/** ----------------------------------------------------------------------------
	 * Send security headers and remove ones that can potentially expose
	 * vulnerabilities. Learn more: https://securityheaders.io
	 */

	private function secure_headers() : void {
		// Enables XSS filtering. Rather than sanitizing the page,
		// the browser will prevent rendering of the page if an attack is detected.
		header('X-XSS-Protection: 1; mode=block');

		// Prevent loading page in frames - secures from clickjacking
		header('X-Frame-Options: DENY');

		// This opts-out of MIME type sniffing - is a way to say that the webmasters
		// knew what they were doing.
		// Learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types#MIME_sniffing
		header('X-Content-Type-Options: nosniff');

		// Remove header that informs about PHP version
		header_remove('X-Powered-By');
	}


	/** ----------------------------------------------------------------------------
	 * Force using of HTTPS
	 */

	private function force_https() : void {
		// The HTTP Strict-Transport-Security response header (HSTS) lets a web site
		// tell browsers that it should only be accessed using HTTPS,
		// instead of using HTTP.
		header('Strict-Transport-Security: max-age=31536000; preload');
	}


	/** ----------------------------------------------------------------------------
	 * Autoload libs (PSR-0)
	 */

	public function define_autoloader() : void {
		spl_autoload_register(function($class) {
			$class_path = __DIR__ . '/' . _CONFIG['app_dir'] . _CONFIG['libs_dir'] . str_replace('\\', '/', $class) . '.php';
			if (file_exists($class_path)) {
				include_once $class_path;
				array_push($this->autoloaded_classes, $class);
			}
		});
	}


	/** ----------------------------------------------------------------------------
	 * Get modules list
	 */

	public function get_modules_list() : array {
		$directories = scandir(_CONFIG['app_dir'] . _CONFIG['modules_dir']);
		$modules = [];
		$index = 0;

		foreach($directories as $key => $dir) {
			if ($dir == '.' || $dir == '..' || $dir == 'default') continue;

			$module_config_file = _CONFIG['app_dir'] . _CONFIG['modules_dir'] . $dir . '/_config.php';

			if (is_file($module_config_file)) {
				$modules[$index] = include_once $module_config_file;
				$modules[$index]['node'] = $dir;
				$index++;
			}
		}

		return $modules;
	}


	/**
	 * Get list of autoloaded classes
	 */

	public function get_autoloaded_classes() : array {
		return $this->autoloaded_classes;
	}
}