<?php

/**
 * =================================================================================
 *
 * Servant
 * Class : Core
 *
 * =================================================================================
 */

declare(strict_types=1);

class Core {

	private $libs_dir;

	// Stores list of classes that was autoloaded.
	private $autoloaded_classes = [];


	/** ----------------------------------------------------------------------------
	 * Init Core
	 */

	public function init() {
		if (Config::$DEBUG) {
			$this->forceDisplayPhpErrors();
		}

		$this->startSession();
		$this->definePaths();

		if (Config::$SECURE_HEADERS) {
			$this->sendSecureHeaders();
		}

		if (Config::$FORCE_HTTPS) {
			$this->forceHttps();
		}
	}

	/** ----------------------------------------------------------------------------
	 * Load configuration class and file that can override config values.
	 *
	 * @return bool - true if overwriting config file exist
	 */

	public function loadConfiguration(string $defaults_file, string $override_file = null) : bool {
		if (!file_exists($defaults_file)) {
			throw new Exception("Default configuration file is missing");
		}

		require_once $defaults_file;

		if (!class_exists('Config')) {
			throw new Exception("Configuration file does not contain 'Config' class.");
		}

		if ($override_file && file_exists($override_file)) {
			require_once $override_file;
			return true;
		}
		else {
			return false;
		}
	}


	/** ----------------------------------------------------------------------------
	 * Force display PHP errors
	 */

	public function forceDisplayPhpErrors() {
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
	}


	/** ----------------------------------------------------------------------------
	 * Start session
	 */

	private function startSession() {
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

	private function definePaths() {

		// Request protocol (http or https)
		define('REQUEST_PROTOCOL', (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http');

		// ROOT URI
		// This path represents browser location of index.php
		// Everything after that address is a request.
		$root_uri = $_SERVER['SERVER_NAME'];
		$script_dirname = dirname($_SERVER['SCRIPT_NAME']);
		if ($script_dirname != '/') {
			$root_uri .= $script_dirname;
		}
		define('ROOT_URI', $root_uri . '/');

		/**
		 * Root URL
		 * @example https://somewebsite.com/yourapp/
		 */
		define('ROOT_URL', REQUEST_PROTOCOL . '://' . ROOT_URI);

		/**
		 * Root phisical directory path
		 * Physical path of app root file
		 */
		define('ROOT_DIR', __DIR__);

		/**
		 * Request target that is created by Mod Rewrite
		 * configured in .htaccess file
		 * @var String
		 * @example 'users/get/1/'
		 */
		define('REQUEST_TARGET', $_GET['app_request'] ?? '');

		/**
		 * Request target divided into chunks
		 * @var Array
		 * @example ['users', 'get', '1']
		 */
		define('REQUEST_TARGET_CHUNKS', explode('/', trim(REQUEST_TARGET, '/')));
	}


	/** ----------------------------------------------------------------------------
	 * Send security headers and remove ones that can potentially expose
	 * vulnerabilities. Learn more: https://securityheaders.io
	 */

	private function sendSecureHeaders() {
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

	private function forceHttps() {
		// The HTTP Strict-Transport-Security response header (HSTS) lets a web site
		// tell browsers that it should only be accessed using HTTPS,
		// instead of using HTTP.
		header('Strict-Transport-Security: max-age=31536000; preload');
	}


	/** ----------------------------------------------------------------------------
	 * Autoload libs (PSR-0)
	 */

	public function defineAutoloader($libs_dir) {
		if (!is_dir($libs_dir)) {
			throw new Exception("Provided PHP libraries directory does not exist.");
		}

		$this->libs_dir = $libs_dir;

		spl_autoload_register(function($class_name) {
			$class_path = $this->libs_dir . str_replace('\\', '/', $class_name) . '.php';

			if (file_exists($class_path)) {
				include_once $class_path;
				array_push($this->autoloaded_classes, $class_name);
			}
		});
	}


	/** ----------------------------------------------------------------------------
	 * Get list of autoloaded classes
	 */

	public function getAutoloadedClassesList() : array {
		return $this->autoloaded_classes;
	}
}