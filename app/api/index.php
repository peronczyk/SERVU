<?php

define('SERVANT_API', true);

$rest_store = new RestStore();
$rest_exception_handler = new RestExceptionHandler($rest_store, _CONFIG['debug']);
$auth = new Auth($db);

$dependencies = new DependencyContainer();
$dependencies->add([
	'db'         => $db,
	'rest_store' => $rest_store,
	'auth'       => $auth,
]);

$router = new Router($dependencies);

$modules_dir = _CONFIG['app_dir'] . _CONFIG['modules_dir'];
$modules = new ModulesHandler(implode('/', $request_chunks), $modules_dir, _CONFIG['modules_config_filename']);
$modules->get_configs();
$modules->create_routes($router);

$router->run();


/**
 * Meta data
 */

$rest_store->set('meta', [
	'site-name'       => _CONFIG['site_name'],
	'debug-mode'      => _CONFIG['debug'],
	'request-method'  => $_SERVER['REQUEST_METHOD'],
	'root-uri'        => ROOT_URI,
	'request-uri'     => REQUEST_URI,
	'load-time'       => round(microtime(true) - APP_START, 4),
	'queries'         => count($db->get_log()),
	'access-lvl'      => $auth->get_lvl(),
	'classes-loaded'  => $core->get_autoloaded_classes(),

	// App version is visible only for logged in users
	'app-version'     => ($auth->get_lvl() > Auth::LVL_USER) ? APP_VERSION : null,
	'php-version'     => ($auth->get_lvl() > Auth::LVL_USER) ? phpversion() : null,
]);

$rest_store->output();