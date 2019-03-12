<?php

/**
 * =================================================================================
 *  __
 * / _\ ___ _ ____   __   _
 * \ \ / _ \ '__\ \ / /| | |
 * _\ \  __/ |   \ V / (_| |
 * \__/\___|_|    \_/ \__,_|
 *
 * SERVU SAYS HELLO
 * Headless Content Management System
 *
 * ---------------------------------------------------------------------------------
 *
 * @author    Bartosz Perończyk (peronczyk.com)
 * @link      https://github.com/peronczyk/servu
 *
 * =================================================================================
 */

declare(strict_types=1);

define('APP_START', microtime(true));
define('APP_VERSION', '0.0.1');
define('APP_INDEX', true);


/**
 * Initiate core
 */

require_once 'core.php';
$core = new Core();
$core->loadConfiguration(
	__DIR__ . '/config.php',
	__DIR__ . '/config-override.php'
);
$core->init();
$core->defineAutoloader(__DIR__ . '/' . Config::$APP_DIR . Config::$LIBS_DIR);


/**
 * Initiate dependancy container
 */

$container = new DependencyContainer();


/**
 * Initiate database handler
 */

$db_file = Config::$STORAGE_DIR . 'database/' . Config::$DB_FILE_NAME;
$db = new Sqlite\Sqlite($db_file, [
	'debug' => Config::$DEBUG
]);
$container->add('db', $db);


/**
 * Initiate authentication object
 */

$auth = new Auth($container);
$container->add('auth', $auth);


/**
 * Load base madule
 */

switch (Config::$DEFAULT_BASE_MODULE) {
	case 'api':
		require_once __DIR__ . '/' . Config::$APP_DIR . ((REQUEST_TARGET_CHUNKS[0] == 'admin') ? '/admin' : '/api') . '/index.php';
		break;

	case 'admin':
		require_once __DIR__ . '/' . Config::$APP_DIR . ((REQUEST_TARGET_CHUNKS[0] == 'api') ? '/api' : '/admin') . '/index.php';
		break;
}