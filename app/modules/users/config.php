<?php return [
	'name' => 'Users',
	'icon' => 'users',
	'routes' => [
		[
			'method' => 'GET',
			'path' => 'list/',
			'callback' => function($dependencies) {
				ModulesHandler::run_module();
			},
			'options' => [
				'auth_lvl' => Auth::LVL_ADMIN
			]
		],
	],
];