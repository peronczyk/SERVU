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
			'callback' => $helper->PassCallbackMethod('add'),
		],
	],
];