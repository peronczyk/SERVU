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

require_once('base.php');
$base = new Base();


/**
 * Prepare connection to database
 */

$db = new Sqlite(_STORAGE_DIR . 'database/' . _DB_FILE_NAME, _DEBUG);


echo '<pre>';

echo '<br>Loading: ' . round(microtime(true) - BROM_START, 4);
echo '<br>Queries: ' . count($db->get_log());

echo '</pre>';