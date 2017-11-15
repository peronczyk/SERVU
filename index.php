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
 * Init router
 */

$router = new Router();

if (_DEFAULT_BASE_MODULE == 'api') {

}

echo '<pre>';

// print_r($db->select()->from('collections')->all()); // db test

echo '<br>Loading: ' . round(microtime(true) - BROM_START, 4);
echo '<br>Queries: ' . count($db->get_log());

echo '</pre>';