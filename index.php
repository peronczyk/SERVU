<?php

/**
 * Hello to BROM, headless content management system.
 */

define('BROM_START', microtime(true));

require_once('core.php');
$core = new Core();

$db = new Sqlite();


echo '<br>' . round(microtime(true) - BROM_START, 4);