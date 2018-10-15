<?php

/** --------------------------------------------------------------------------------
 * Register action defaults
 */
function register_content_action_defaults($dependencies) {
	$controller_file = __DIR__ . '/ContentController.php';

	if (file_exists($controller_file)) {
		require_once $controller_file;
		return new ContentController($dependencies);
	}
	else {
		throw new Exception("Controller for module 'Content' does not exist");
	}
}

/** --------------------------------------------------------------------------------
 * Module config
 */
return [
	'name' => 'Content',
	'icon' => 'document',
	'routes' => [
		[
			'path' => 'content/list(/)',
			'callback' => function($dependencies) {
				$files = register_content_action_defaults($dependencies);
				$files->getList();
			},
		],
	],
];