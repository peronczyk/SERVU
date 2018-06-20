<?php return [
	'name' => 'Users',
	'icon' => 'users',
	'routes' => [
		[
			'path' => 'list(/)',
			'callback' => function($dependencies) {
				require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
				$controller = new UsersController($dependencies);
				$controller->get_list();
			},
			'auth_lvl' => Auth::LVL_USER
		],
		[
			'method' => 'POST',
			'path' => 'login(/)',
			'callback' => function($dependencies) {
				require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
				$controller = new UsersController($dependencies);
				$controller->login();
			},
		],
	],
];