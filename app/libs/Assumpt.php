<?php

/**
 * =================================================================================
 *
 * Assumption class
 *
 * This class is used to check if the assumptions about the variable are correct.
 * Application is interrupted by returning an exception if not.
 *
 * @link      https://github.com/peronczyk/servu
 * @copyright Bartosz Perończyk <bartosz@peronczyk.com>
 *
 * =================================================================================
 */

declare(strict_types=1);

class Assumpt {
	private static $patterns = [
		'text'      => '/[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+/',
		'directory' => '/^[^\\/?%*:|"<>\.]+$/',
	];


	/** ----------------------------------------------------------------------------
	 * Universal caller
	 *
	 * @example Assumpt::integer($_POST, 'somevalue', true);
	 * @example Assumpt::email($_POST['some-email'], 'email');
	 */

	public static function __callStatic($method, $args) {
		// Definitions
		$value    = $args[0] ?? null;
		$name     = $args[1] ?? null;
		$required = $args[2] ?? true;
		$result   = null;
		$options  = null;
		$regexp   = null;

		// This allows to pass separately an array and the key.
		// eg.: ($_POST, 'somekey')
		if (is_array($value) && isset($value[$name])) {
			$value = $value[$name];
		}

		// If value is required
		if ($required === true && empty($value)) {
			self::error("Variable '{$name}' is required");
		}

		// Return if empty
		if (empty($value)) {
			return !$required;
		}

		// Choose method
		switch ($method) {
			case 'integer':
				$filter = FILTER_VALIDATE_INT;
				break;

			case 'email':
				$filter = FILTER_VALIDATE_EMAIL;
				break;

			// Simple text string
			case 'text':
				$regexp = self::$patterns['text'];
				break;

			// Directory name (not full path)
			case 'directory':
				$regexp = self::$patterns['directory'];
				break;

			case 'stringInt':
				$result = ctype_digit($value);
				break;

			case 'array':
				$result = is_array($value);
				break;

			default:
				self::error("Unknown assumption method '{$method}'");
		}

		// If validation should use regexp set options
		if ($regexp) {
			$filter = FILTER_VALIDATE_REGEXP;
			$options = ['options' => ['regexp' => $regexp]];
		}

		// Begin validation with filter_var function when there is no result from
		// any of the methods
		if ($result === null) {
			$result = filter_var($value, $filter, $options);
		}

		// Analyse results
		if (!$result) {
			self::error((!empty($name))
				? "Variable '{$name}' is not valid {$method}"
				: "One of the variables are invalid"
			);
		}
		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Assumption failed
	 */

	private static function error($message) {
		throw new Exception("Assumption failed: {$message}");
		die();
	}
}