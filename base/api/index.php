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
	'site-name'       => _SITE_NAME,
	'debug-mode'      => _DEBUG,
	'request-method'  => $_SERVER['REQUEST_METHOD'],
	'root-uri'        => APP_ROOT_URI,
	'request-uri'     => REQUEST_URI,
	'load-time'       => round(microtime(true) - BROM_START, 4),
	'queries'         => count($db->get_log()),
	'access-lvl'      => $auth->get_lvl(),

	// App version is visible only for logged in users
	'app-version'     => ($auth->get_lvl() > Auth::LVL_USER) ? BROM_VERSION : null,
]);

$rest->send();