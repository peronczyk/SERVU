<?php

$helper = new ModuleConfigHelper(__DIR__, 'CollectionsController');

return [
	'name' => 'Collections',
	'icon' => 'group',
	'routes' => [
		[
			'path'     => 'collections/list(/)',
			'callback' => $helper->PassCallbackMethod('list'),
		],
		[
			'path'     => 'collections/add(/)',
			'method'   => Router::POST,
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('add'),
		],
		[
			'path'     => 'collections/modify/:id(/)',
			'method'   => Router::POST,
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('modify'),
		],
		[
			'path'     => 'collections/delete/:id(/)',
			'method'   => Router::POST,
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('delete'),
		],
		[
			'path'     => 'collections/get/:id(/)',
			'callback' => $helper->PassCallbackMethod('get'),
		],
	],
];