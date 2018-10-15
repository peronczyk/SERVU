<?php

$helper = new ModuleConfigHelper(__DIR__, 'CollectionsController');

return [
	'name' => 'Collections',
	'icon' => 'group',
	'routes' => [
		[
			'path'     => 'collections/list(/)',
			'callback' => $helper->PassCallbackMethod('getList'),
		],
		[
			'path'     => 'collections/add(/)',
			'method'   => 'POST',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('add'),
		],
		[
			'path'     => 'collections/delete/:id(/)',
			'method'   => 'POST',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('delete'),
		],
	],
];