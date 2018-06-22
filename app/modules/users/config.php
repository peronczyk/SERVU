<?php return [
	'name' => 'Users',
	'icon' => 'users',
	'routes' => [
		[
			'path' => 'list(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
				$controller = new UsersController($dependencies);
				$controller->getList();
			},
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
		[
			'path' => 'logout(/)',
			'callback' => function($dependencies) {
				require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
				$controller = new UsersController($dependencies);
				$controller->logout();
			},
		],
		[
			'method' => 'POST',
			'path' => 'create(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
				$controller = new UsersController($dependencies);
				$controller->create();
			},
		],
		[
			'method' => 'POST',
			'path' => 'remove/:id(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies, $params) {
				require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
				$controller = new UsersController($dependencies);
				$controller->remove($params);
			},
		],
	],
];