<?php

define('BROM_API', true);

$rest = new Rest();

$auth = new Auth($db);

$dependencies = new DependencyContainer();
$dependencies->add([
	'db'   => $db,
	'rest' => $rest,
	'auth' => $auth,
]);

$router->run($dependencies);


/**
 * Meta data
 */

$rest->set('meta', [
	'debug-mode'      => _DEBUG,
	'request-method'  => $_SERVER['REQUEST_METHOD'],
	'root-uri'        => APP_ROOT_URI,
	'request-uri'     => REQUEST_URI,
	'load-time'       => round(microtime(true) - BROM_START, 4),
	'queries'         => count($db->get_log()),
	'access-lvl'      => $auth->get_lvl(),
]);

$rest->send();