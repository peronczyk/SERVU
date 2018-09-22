<?php

define('SERVANT_API', true);

$rest_store = new RestStore();
$rest_exception_handler = new RestExceptionHandler($rest_store, _CONFIG['debug']);
$rest_exception_handler->initAll();

$container->add('rest_store', $rest_store);

$router = new Router($container);

$modules_path = _CONFIG['app_dir'] . _CONFIG['modules_dir'];
$modules = new ModulesHandler($modules_path, _CONFIG['modules_config_filename']);
$modules->getConfigs();
$modules->createRoutes($router);

$router->run(REQUEST_TARGET);

/**
 * Meta data
 */
$rest_store->set('meta', [
	'site-name'       => _CONFIG['site_name'],
	'debug-mode'      => _CONFIG['debug'],
	'request-method'  => $_SERVER['REQUEST_METHOD'],
	'root-uri'        => ROOT_URI,
	'request-target'  => REQUEST_TARGET,
	'load-time'       => round(microtime(true) - APP_START, 4),
	'queries'         => count($db->getLog()),
	'access-lvl'      => $auth->getLvl(),
	'classes-loaded'  => $core->getAutoloadedClassesList(),

	// App version is visible only for logged in users
	'app-version'     => ($auth->getLvl() > Auth::LVL_USER) ? APP_VERSION : null,
	'php-version'     => ($auth->getLvl() > Auth::LVL_USER) ? phpversion() : null,
]);

$rest_store->output();