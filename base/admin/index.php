<?php

$admin_url = APP_ROOT_URL . 'admin/';
$admin_dir = APP_ROOT_URL . 'base/admin/';

$app_config = [
	'rootUrl' => $admin_url,
	'apiBaseUrl' => APP_ROOT_URL . ((_DEFAULT_BASE_MODULE == 'api' ? '' : 'api/')),
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

	<script src="<?= $admin_dir ?>dist/app.js" async></script>
</body>

</html>