<?php

// URL visible in browser address bar
$admin_url = ROOT_URL . 'admin/';

// Physical address of admin app
$admin_dir = ROOT_URL . _APP_DIR . _ADMIN_DIR;

$app_config = [
	'siteName'   => _SITE_NAME,
	'rootUrl'    => $admin_url,
	'apiBaseUrl' => ROOT_URL . ((_DEFAULT_BASE_MODULE == 'api' ? '' : 'api/')),
];

$app_modules = $core->get_modules_list();

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