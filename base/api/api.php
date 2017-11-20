<?php

$rest = new Rest();

$rest->set('request_method', $_SERVER['REQUEST_METHOD']);

$router->run([
	'deps' => [
		'rest' => $rest
	]
]);

$rest->send();