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

if (_DEBUG) $rest->set('load_time', round(microtime(true) - BROM_START, 4));

$rest->send();