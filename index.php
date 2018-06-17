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

$db_file = _STORAGE_DIR . 'database/' . _DB_FILE_NAME;
$db = new Sqlite($db_file, ['debug' => _DEBUG]);


/**
 * Load base module - api or admin
 */

$request_chunks = explode('/', trim(REQUEST_URI, '/'));
if ($request_chunks[0] && is_dir(_APP_DIR . $request_chunks[0])) {
	require_once _APP_DIR . $request_chunks[0] . '/index.php';
}
else {
	require_once _APP_DIR . _DEFAULT_BASE_MODULE . '/index.php';
}