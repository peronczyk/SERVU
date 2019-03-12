<?php

define('SERVU_API', true);

// Initiate resto store and rest exception handler
$rest_store = new RestStore();
$rest_exception_handler = new RestExceptionHandler($rest_store, Config::$DEBUG);
$rest_exception_handler->initAll();

$container->add('rest_store', $rest_store);

// Initiate API router
$router = new Router($container);

// Define root route
$router->add([
	'path' => '(/)',
	'callback' => function() {},
]);

// Initiate modules handler and define modules routes
$modules_path = Config::$APP_DIR . Config::$MODULES_DIR;
$modules = new ModulesHandler($modules_path, Config::$MODULES_CONFIG_FILENAME);
$modules->getConfigs();
$modules->createRoutes($router);

// Run router
$router->run(REQUEST_TARGET);

// Add meta data to API output
$rest_store->set('meta', [
	'site-name'       => Config::$SITE_NAME,
	'debug-mode'      => Config::$DEBUG,
	'request-method'  => $_SERVER['REQUEST_METHOD'],
	'root-uri'        => ROOT_URI,
	'request-target'  => REQUEST_TARGET,
	'load-time'       => round(microtime(true) - APP_START, 4),
	'queries'         => $db->getQueriesNumber(),
	'access-lvl'      => $auth->getLvl(),
	'classes-loaded'  => $core->getAutoloadedClassesList(),

	// App version is visible only for logged in users
	'app-version'     => ($auth->getLvl() > Auth::LVL_USER) ? APP_VERSION : null,
	'php-version'     => ($auth->getLvl() > Auth::LVL_USER) ? phpversion() : null,
]);

// Output script execution results
$rest_store->output();