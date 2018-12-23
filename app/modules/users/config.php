<?php

$helper = new ModuleConfigHelper(__DIR__, 'UsersController');

return [
	'name'   => 'Users',
	'icon'   => 'user',
	'routes' => [
		[
			'path'     => 'users/list(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('list'),
		],
		[
			'method'   => 'POST',
			'path'     => 'users/login(/)',
			'callback' => $helper->PassCallbackMethod('login'),
		],
		[
			'path'     => 'users/logout(/)',
			'callback' => $helper->PassCallbackMethod('logout'),
		],
		[
			'method'   => 'POST',
			'path'     => 'users/create(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('create'),
		],
		[
			'method'   => 'POST',
			'path'     => 'users/delete/:id(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('delete'),
		],
	],
];