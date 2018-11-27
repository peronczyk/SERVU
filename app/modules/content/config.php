<?php

$helper = new ModuleConfigHelper(__DIR__, 'ContentController');

return [
	'name' => 'Content',
	'icon' => 'document',
	'routes' => [
		[
			'path'     => 'content/list(/)',
			'callback' => $helper->PassCallbackMethod('list'),
		],
		[
			'path'     => 'content/add(/)',
			'method'   => Router::POST,
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('add'),
		],
		[
			'path'     => 'content/delete/:id(/)',
			'method'   => Router::POST,
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('delete'),
		],
	],
];