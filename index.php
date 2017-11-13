<?php

/**
 * Hello to BROM, headless content management system.
 */

define('BROM_START', microtime(true));


/**
 * Initiate core
 */

require_once('core.php');
$core = new Core();


/**
 * Prepare connection to database
 */

$db = new Sqlite(_STORAGE_DIR . 'database/' . _DB_FILE_NAME, _DEBUG);

echo '<pre>';

echo '<br>Loading: ' . round(microtime(true) - BROM_START, 4);
echo '<br>Queries: ' . count($db->get_log());

echo '</pre>';