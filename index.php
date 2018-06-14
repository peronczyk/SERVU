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
 * Headless Content Canagement System
 *
 * @author Bartosz Perończyk
 * =================================================================================
 */

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
 * Prepare database object
 */

$db_file = _STORAGE_DIR . 'database/' . _DB_FILE_NAME;
$db = new Sqlite($db_file, ['debug' => _DEBUG]);


/**
 * Initiate router
 */

$router = new Router(REQUEST_URI, [
	'controllers_dir'    => _APP_DIR . _MODULES_DIR,
	'default_controller' => 'default',
]);


/**
 * Load base module
 */

$base_module = $router->get_first_request();

if (empty($base_module) || !is_dir(_APP_DIR . $base_module)) {
	$base_module = _DEFAULT_BASE_MODULE;
}
elseif ($base_module != _DEFAULT_BASE_MODULE) {
	$router->shift_request();
}

require_once _APP_DIR . $base_module . '/index.php';