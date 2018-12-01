<?php

declare(strict_types=1);

class Assumpt {
	private static $patterns = [
		'text' => '/[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+/',
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
		$options  = null;
		$regexp   = null;

		// This allows to pass separately an array and the key.
		// eg.: ($_POST, 'somekey')
		if (is_array($value) && isset($value[$name])) {
			$value = $value[$name];
		}

		// If value is required
		if ($required === true && empty($value)) {
			throw new Exception("Assumption failed: {$name} is required");
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

			case 'text':
				$regexp = self::$patterns['text'];
				break;

			default:
				self::error("Unknown validation type '{$type}'");
		}

		// If validation should use regexp set options
		if ($regexp) {
			$filter = FILTER_VALIDATE_REGEXP;
			$options = ['options' => ['regexp' => $regexp]];
		}

		// Begin validation
		$result = filter_var($value, $filter, $options);

		// Analyse results
		if (!$result) {
			self::error((!empty($name))
				? "{$name} is invalid"
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