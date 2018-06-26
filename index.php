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
 * Initiate dependancy container
 */

$container = new DependencyContainer();
$container->add('core', $core);


/**
 * Prepare database object
 */

$db_file = _CONFIG['storage_dir'] . 'database/' . _CONFIG['db_file_name'];
$db = new Sqlite($db_file, ['debug' => _CONFIG['debug']]);
$container->add('db', $db);


/**
 * Initiate authentication object
 */

$auth = new Auth($container);
$container->add('auth', $auth);


/**
 * Initiate router and add base routes
 */

$router = new Router($container);
$router->addRequirement('auth_lvl', '>=', $auth->getLvl());

switch (_CONFIG['default_base_module']) {
	case 'api':
		$router->add(['path' => '(/)', 'callback' => function() {
			die('API');
		}]);

		$router->add(['path' => 'admin(/)', 'callback' => function() {
			die('ADMIN');
		}]);

		break;
}

$router->run(REQUEST_TARGET);