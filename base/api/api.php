<?php

define('BROM_API', true);

$rest = new Rest();

$rest->set('request_method', $_SERVER['REQUEST_METHOD']);

$router->run([
	'dependencies' => [
		'db' => $db,
		'rest' => $rest
	]
]);


/**
 * Debug info
 */

if (_DEBUG) {
	$rest->set('debug', [
		'root-uri'    => APP_ROOT_URI,
		'request-uri' => REQUEST_URI,
		'load-time'   => round(microtime(true) - BROM_START, 4),
		'queries'     => count($db->get_log()),
	]);
}

$rest->send();