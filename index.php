<?php

/**
 * =================================================================================
 *  __                            _
 * / _\ ___ _ ____   ____ _ _ __ | |_
 * \ \ / _ \ '__\ \ / / _` | '_ \| __|
 * _\ \  __/ |   \ V / (_| | | | | |_
 * \__/\___|_|    \_/ \__,_|_| |_|\__|
 *
 * SERVANT SAYS HELLO
 * Headless Content Canagement System
 *
 * @author Bartosz Perończyk
 * =================================================================================
 */

declare(strict_types=1);

define('APP_START', microtime(true));
define('APP_VERSION', '0.0.1');
define('APP_INDEX', true);

/**
 * Initiate core
 */

require_once 'core.php';
$core = new Core();
$core->init();


/**
 * Prepare database object
 */

$db_file = _CONFIG['storage_dir'] . 'database/' . _CONFIG['db_file_name'];
$db = new Sqlite($db_file, ['debug' => _CONFIG['debug']]);


/**
 * Initiate dependancy container
 */

$dependencies = new DependencyContainer();
$dependencies->add([
	'core' => $core,
	'db'   => $db,
]);


/**
 * Load base module: api or admin
 */

$request_first_chunk = $core->get_first_of_processed_request();
if ($request_first_chunk != _CONFIG['default_base_module'] && in_array($request_first_chunk, ['api', 'admin'])) {
	require_once _CONFIG['app_dir'] . $request_first_chunk . '/index.php';
	$core->shift_processed_request();
}
else {
	require_once _CONFIG['app_dir'] . _CONFIG['default_base_module'] . '/index.php';
}