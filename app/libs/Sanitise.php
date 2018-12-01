<?php

declare(strict_types=1);

class Sanitise {

	/** ----------------------------------------------------------------------------
	 * Caller
	 */

	public static function __callStatic($method, $args) {
		// Check if sanitation method is available
		if (!method_exists(__CLASS__, $method)) {
			throw new Exception("Sanitiser: unknown sanitation method '{$method}'");
		}

		// Definitions
		$value    = $args[0] ?? null;
		$name     = $args[1] ?? null;
		$required = $args[2] ?? true;

		// This allows to pass separately an array and the key.
		// eg.: ($_POST, 'somekey')
		if (is_array($value) && isset($value[$name])) {
			$value = $value[$name];
		}

		// If value is required
		if ($required === true && empty($value)) {
			throw new Exception("Sanitiser: {$name} is required");
		}

		// Return if empty
		if (empty($value)) {
			return null;
		}

		return call_user_func_array([__CLASS__, $method], [$value]);
	}


	/** ----------------------------------------------------------------------------
	 * Integer IDs
	 * Everything that is not numeric will be changed into 0
	 */

	private static function integerId($value) {
		return (is_int($value) || ctype_digit($value))
			? intval($value)
			: 0;
	}
}