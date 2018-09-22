<?php

/** --------------------------------------------------------------------------------
 * Register action defaults
 */
function register_files_action_defaults($dependencies) {
	$controller_file = _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'files/FilesController.php';

	if (file_exists($controller_file)) {
		require_once _CONFIG['app_dir'] . _CONFIG['modules_dir'] . 'files/FilesController.php';
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
	'routes' => [[
		'path' => 'files/list(/)',
		'callback' => function($dependencies) {
			$files = register_files_action_defaults($dependencies);
			$files->getList();
		},
	],

	],
];