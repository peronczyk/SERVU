<?php

// Check if admin JS app files exists
if (!file_exists(__DIR__ . '/dist/app.js')) {
	throw new Exception("Administration panel application is missing. Probably it was not builded properly. To do this you should follow instructions available in admin panel readme.md file located in `app/admin/` directory.");
}

// URL visible in browser address bar
$admin_url = ROOT_URL . 'admin/';

// Physical address of admin app
$admin_dir = ROOT_URL . _CONFIG['app_dir'] . _CONFIG['admin_dir'];

$app_config = [
	'siteName'   => _CONFIG['site_name'],
	'rootUrl'    => $admin_url,
	'apiBaseUrl' => ROOT_URL . ((_CONFIG['default_base_module'] == 'api' ? '' : 'api/')),
];

$modules_path = _CONFIG['app_dir'] . _CONFIG['modules_dir'];
$modules = new ModulesHandler($container, $modules_path, _CONFIG['modules_config_filename']);
$app_modules = $modules->getConfigs();

?><!DOCTYPE html>
<html lang="en">

<head>
	<base href="<?= $admin_url ?>">

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Administration Panel</title>

	<script>
		window.appConfig  = <?= json_encode($app_config); ?>;
		window.appModules = <?= json_encode($app_modules); ?>;
	</script>

	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,700,300,400italic,700italic">
</head>

<body>
	<noscript>
		<div style="margin:80px; font-family:sans-serif;">
			<h1>Administration Panel<br>requires <u>JavaScript</u> to be <u>enabled</u>!</h1>
			<a href="https://www.google.pl/search?q=how+to+enable+javascript">How to enable JavaScript?</a>
		</div>
	</noscript>

	<div id="app"></div>

	<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" style="display:none;">
		<style type="text/css">
			.logo-top {fill: #21e074; }
			.logo-bottom {fill: #fff; }
		</style>
		<symbol id="logo-servant" viewBox="0 0 50 50">
			<polygon class="logo-top" points="43,25 18,25 18,0"/>
			<polygon class="logo-bottom" points="5,25 30,25 30,50"/>
		</symbol>
	</svg>

	<script src="<?= $admin_dir ?>dist/app.js" async></script>
</body>

</html>