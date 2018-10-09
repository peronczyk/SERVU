<?php

/** --------------------------------------------------------------------------------
 * Register action defaults
 */
function register_collections_action_defaults($dependencies) {
	$controller_file = __DIR__ . '/CollectionsController.php';

	if (file_exists($controller_file)) {
		require_once $controller_file;
		return new CollectionsController($dependencies);
	}
	else {
		throw new Exception('Controller for module "collections" does not exist');
	}
}

/** --------------------------------------------------------------------------------
 * Module config
 */
return [
	'name' => 'Collections',
	'icon' => 'group',
	'routes' => [
		[
			'path' => 'collections/list(/)',
			'callback' => function($dependencies) {
				$collections = register_collections_action_defaults($dependencies);
				$collections->getList();
			},
		],
		[
			'path' => 'collections/add(/)',
			'method' => 'POST',
			'callback' => function($dependencies) {
				$collections = register_collections_action_defaults($dependencies);
				$collections->add();
			},
		],
	],
];