<?php

$module_controller_file = _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';

return [
	'name' => 'Users',
	'icon' => 'users',
	'routes' => [
		[
			'path' => 'list/',
			'callback' => function($dependencies) {
				require_once $module_controller_file;
				$controller = new UsersController($dependencies);
				$controller->get_list();
			},
			'options' => [
				'auth_lvl' => Auth::LVL_ADMIN
			]
		],
		[
			'method' => 'POST',
			'path' => 'login/',
			'callback' => function($dependencies) {
				require_once $module_controller_file;
				$controller = new UsersController($dependencies);
				$controller->login();
			},
		],
		[
			'method' => 'GET',
			'path' => 'test/:number',
			'callback' => function($dependencies) {
				die('TEST OK');
			},
		],
	],
];