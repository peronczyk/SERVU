<?php

/**
 * =================================================================================
 *  __                            _
 * / _\ ___ _ ____   ____ _ _ __ | |_
 * \ \ / _ \ '__\ \ / / _` | '_ \| __|
 * _\ \  __/ |   \ V / (_| | | | | |_
 * \__/\___|_|    \_/ \__,_|_| |_|\__|
 *
 * SERVANT SAYS HELLO
 * Headless Content Management System
 *
 * @author Bartosz Perończyk (peronczyk.com)
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
$core->init();


/**
 * Initiate dependancy container
 */

$container = new DependencyContainer();


/**
 * Initiate database handler
 */

$db_file = _CONFIG['storage_dir'] . 'database/' . _CONFIG['db_file_name'];
$db = new Sqlite($db_file, [
	'debug' => _CONFIG['debug']
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

switch (_CONFIG['default_base_module']) {
	case 'api':
		require_once _CONFIG['app_dir'] . ((REQUEST_TARGET_CHUNKS[0] == 'admin') ? '/admin' : '/api') . '/index.php';
		break;

	case 'admin':
		require_once _CONFIG['app_dir'] . ((REQUEST_TARGET_CHUNKS[0] == 'api') ? '/api' : '/admin') . '/index.php';
		break;
}