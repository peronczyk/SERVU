<?php

/** --------------------------------------------------------------------------------
 * Register action defaults
 */
function register_files_action_defaults($dependencies) {
	$controller_file = _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'files/FilesController.php';

	if (file_exists($controller_file)) {
		require_once $controller_file;
		return new FilesController($dependencies);
	}
	else {
		throw new Exception('Controller for module "files" does not exist');
	}
}

/** --------------------------------------------------------------------------------
 * Module config
 */
return [
	'name' => 'Files',
	'icon' => 'files',
	'routes' => [
		[
			'path' => 'files/list(/)',
			'callback' => function($dependencies) {
				$files = register_files_action_defaults($dependencies);
				$files->getList();
			},
		],
		[
			'method' => 'POST',
			'path' => 'files/create-dir(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				$files = register_files_action_defaults($dependencies);
				$files->createDir();
			},
		],
		[
			'method' => 'POST',
			'path' => 'files/delete(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				$files = register_files_action_defaults($dependencies);
				$files->delete();
			},
		],
		[
			'method' => 'POST',
			'path' => 'files/upload(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => function($dependencies) {
				$files = register_files_action_defaults($dependencies);
				$files->upload();
			},
		],
	],
];