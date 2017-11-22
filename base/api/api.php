<?php

define('BROM_API', true);

$rest = new Rest();

$auth = new Auth($db);

$router->run([
	'dependencies' => [
		'db'   => $db,
		'rest' => $rest,
		'auth' => $auth,
	]
]);


/**
 * Debug info
 */

if (_API_DISPLAY_INFO) {
	$rest->set('app-info', [
		'debug-mode'      => _DEBUG,
		'request-method'  => $_SERVER['REQUEST_METHOD'],
		'root-uri'        => APP_ROOT_URI,
		'request-uri'     => REQUEST_URI,
		'load-time'       => round(microtime(true) - BROM_START, 4),
		'queries'         => count($db->get_log()),
		'auth-lvl'        => $auth->get(),
	]);
}

$rest->send();