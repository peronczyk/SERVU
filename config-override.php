<?php

/**
 * =================================================================================
 *
 * CONFIGURATION OVERRIDING FILE
 *
 * Here you can override default configuration stored 'config.php' file.
 * @example Config::$SOME_VAR = 'some value';
 *
 * =================================================================================
 */

Config::$DEBUG = preg_match('/(localhost|::1|\.dev)$/', $_SERVER['SERVER_NAME'] ?? '');
Config::$SITE_NAME = $_SERVER['SERVER_NAME'];