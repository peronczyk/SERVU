<?php

/**
 * =================================================================================
 *
 * DEFAULT CONFIGURATION
 *
 * This configuration can be overwritten by file 'config-override.php'
 * placed in main directory.
 * It is strongly recommended to avoid modyfying this file.
 *
 * =================================================================================
 */

class Config {
	/**
	 * This variable will be added to meta section of all api request. It also will
	 * be displayed on front page of admin panel
	 * @var String
	 */
	static $SITE_NAME = null;

	/**
	 * Force displaying all errors, warnings and notices
	 * by default this mode is turned on when working on localhost
	 * @var Boolean
	 */
	static $DEBUG = false;

	/**
	 * Send security headers and remove ones that can potentially expose
	 * vulnerabilities. Learn more: https://securityheaders.io
	 * @var Boolean
	 */
	static $SECURE_HEADERS = true;

	/**
	 * Force use of HTTPS
	 * @var Boolean
	 */
	static $FORCE_HTTPS = true;

	/**
	 * Primary module, that will be displayed to user when he enters root app path.
	 * @var String - 'api' or 'admin'
	 */
	static $DEFAULT_BASE_MODULE = 'api';

	/**
	 * Storage directory. It contains SQLite database and uploaded files.
	 * @var String
	 */
	static $STORAGE_DIR = 'storage/';

	/**
	 * App directory
	 * @var String
	 */
	static $APP_DIR = 'app/';

	/**
	 * Admin subdirectory of app
	 * @var String
	 */
	static $ADMIN_DIR = 'admin/';

	/**
	 * API subdirectory of app
	 * @var String
	 */
	static $API_DIR = 'api/';

	/**
	 * PHP libraries subdirectory of app
	 * @var String
	 */
	static $LIBS_DIR = 'libs/';

	/**
	 * Modules subdirectory of app
	 * @var String
	 */
	static $MODULES_DIR = 'modules/';

	/**
	 * Each of the modules config filename
	 * @var String
	 */
	static $MODULES_CONFIG_FILENAME = 'config.php';

	/**
	 * Database file name. You can change this file name to something more complex
	 * if you want to be more sure no one will access it from browser.
	 * @var String
	 */
	static $DB_FILE_NAME = 'db.sqlite';

	/**
	 * Api entry that represents boolean result
	 * @var String
	 */
	static $API_RESULT_BOOL = 'result';

	/**
	 * Api entry that represents data result, eg.: array of objects
	 * @var String
	 */
	static $API_RESULT_DATA = 'data';
}