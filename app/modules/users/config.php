<?php

/** --------------------------------------------------------------------------------
 * Register action defaults
 */
function register_users_action_defaults($dependencies) {
	$controller_file = _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';

	if (file_exists($controller_file)) {
		require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'users/UsersController.php';
		return new UsersController($dependencies);
	}
	else {
		throw new Exception('Controller for module "users" does not exist');
	}
}

/** --------------------------------------------------------------------------------
 * Module config
 */
return [
	'name' => 'Users',
	'icon' => 'user',
	'routes' => [
		[
			'path' => 'users/list(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				$users = register_users_action_defaults($dependencies);
				$users->getList();
			},
		],
		[
			'method' => 'POST',
			'path' => 'users/login(/)',
			'callback' => function($dependencies) {
				$users = register_users_action_defaults($dependencies);
				$users->login();
			},
		],
		[
			'path' => 'users/logout(/)',
			'callback' => function($dependencies) {
				$users = register_users_action_defaults($dependencies);
				$users->logout();
			},
		],
		[
			'method' => 'POST',
			'path' => 'users/create(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				$users = register_users_action_defaults($dependencies);
				$users->create();
			},
		],
		[
			'method' => 'POST',
			'path' => 'users/delete/:id(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies, $params) {
				$users = register_users_action_defaults($dependencies);
				$users->delete($params);
			},
		],
	],
];