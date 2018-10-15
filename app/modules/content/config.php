<?php

$helper = new ModuleConfigHelper(__DIR__, 'ContentController');

return [
	'name' => 'Content',
	'icon' => 'document',
	'routes' => [
		[
			'path'     => 'content/list(/)',
			'callback' => $helper->PassCallbackMethod('getList'),
		],
		[
			'path'     => 'content/add(/)',
			'method'   => 'POST',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('add'),
		],
	],
];