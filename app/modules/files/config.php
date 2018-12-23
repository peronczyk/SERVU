<?php

$helper = new ModuleConfigHelper(__DIR__, 'FilesController');

return [
	'name'   => 'Files',
	'icon'   => 'files',
	'routes' => [
		[
			'path'     => 'files/list(/)',
			'callback' => $helper->PassCallbackMethod('list'),
		],
		[
			'method'   => 'POST',
			'path'     => 'files/create-dir(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('createDir'),
		],
		[
			'method'   => 'POST',
			'path'     => 'files/delete(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('delete'),
		],
		[
			'method'   => 'POST',
			'path'     => 'files/upload(/)',
			'auth_lvl' => Auth::LVL_ADMIN,
			'callback' => $helper->PassCallbackMethod('upload'),
		],
	],
];