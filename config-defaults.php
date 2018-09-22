<?php

/**
 * DEFAULT CONFIGURATION
 *
 * This configuration can be overwritten by file 'config.php' placed in main
 * directory, which should return array with variables that you want to change.
 */

return [
	// This variable will be added to meta section of all api request. It also will
	// be displayed on front page of admin panel
	'site_name' => $_SERVER['SERVER_NAME'],

	// Force displaying all errors, warnings and notices
	// by default this mode is turned on when working on localhost
	'debug' => preg_match('/(localhost|::1|\.dev)$/', $_SERVER['SERVER_NAME'] ?? ''),

	// Send security headers and remove ones that can potentially expose
	// vulnerabilities. Learn more: https://securityheaders.io
	'secure_headers' => true,

	// Force use of HTTPS
	'force_https' => true,

	// Primary module, that will be displayed to user when he enters root app path
	// Allowed options: 'api', 'admin'.
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
];