<?php

/**
 * =================================================================================
 *  ____  _____   ____  __  __
 * |  _ \|  __ \ / __ \|  \/  |
 * | |_) | |__) | |  | | \  / |
 * |  _ <|  _  /| |  | | |\/| |
 * | |_) | | \ \| |__| | |  | |
 * |____/|_|  \_\\____/|_|  |_|
 *
 * BROM SAYS HELLO
 * Headless Content Canagement System
 *
 * @author Bartosz Perończyk
 * =================================================================================
 */

define('BROM_START', microtime(true));
define('BROM_VERSION', '0.0.1');
define('BROM_INDEX', true);

/**
 * Initiate core
 */

require_once('core.php');
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
	'controllers_dir'    => _MODULES_DIR,
	'default_controller' => 'default',
]);


/**
 * Load base module
 */

$base_module = $router->get_first_request();

if (empty($base_module) || !is_dir(_BASE_DIR . $base_module)) {
	$base_module = _DEFAULT_BASE_MODULE;
}
elseif ($base_module != _DEFAULT_BASE_MODULE) {
	$router->shift_request();
}

include(_BASE_DIR . $base_module . '/index.php');