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
 * HELLO TO BROM
 * Headless Content Canagement System
 *
 * @author Bartosz Perończyk
 * =================================================================================
 */

define('BROM_START', microtime(true));
define('BROM_VERSION', '0.0.1');
define('BROM_INDEX', true);

/**
 * Initiate base
 */

require_once('base.php');
$base = new Base();
$base->init();


/**
 * Prepare connection to database
 */

$db = new Sqlite(_STORAGE_DIR . 'database/' . _DB_FILE_NAME, ['debug' => _DEBUG]);


/**
 * Init router
 */

$router = new Router();

if (_DEFAULT_CORE_MODULE == 'api') {
	$router->add_route('/admin', [
		'file' => ''
	]);
}

echo '<pre>';

// print_r($db->select()->from('collections')->all()); // db test

echo '<br>Loading: ' . round(microtime(true) - BROM_START, 4);
echo '<br>Queries: ' . count($db->get_log());

echo '</pre>';