<?php

define('SERVANT_API', true);

$router = new Router();
$rest_store = new RestStore();
$rest_exception_handler = new RestExceptionHandler($rest_store);
$auth = new Auth($db);

$dependencies = new DependencyContainer();
$dependencies->add([
	'db'         => $db,
	'rest_store' => $rest_store,
	'auth'       => $auth,
]);

$router->run($dependencies);


/**
 * Meta data
 */

$rest_store->set('meta', [
	'site-name'       => _SITE_NAME,
	'debug-mode'      => _DEBUG,
	'request-method'  => $_SERVER['REQUEST_METHOD'],
	'root-uri'        => ROOT_URI,
	'request-uri'     => REQUEST_URI,
	'load-time'       => round(microtime(true) - APP_START, 4),
	'queries'         => count($db->get_log()),
	'access-lvl'      => $auth->get_lvl(),

	// App version is visible only for logged in users
	'app-version'     => ($auth->get_lvl() > Auth::LVL_USER) ? APP_VERSION : null,
	'php-version'     => ($auth->get_lvl() > Auth::LVL_USER) ? phpversion() : null,
]);

$rest_store->output();