<?php

class ModulesController {

	private $dependencies;


	/**
	 *
	 */

	protected function require_auth($lvl) {

	}


	/**
	 *
	 */

	protected function create_dependecies_shortcuts($dependencies) {
		$this->dependencies = $dependencies;

		// Create properties that are shortcuts to passed dependencies
		foreach ($dependencies as $key => $dependency) {
			$dependency_name = '_' . $key;
			if (isset($this->{$dependency_name})) {
				throw new Exception("Could not create dependency shortcut `{$key}` because property `_{$key}` is already used.");
			}
			else {
				$this->{$dependency_name} = $dependency;
			}
		}
	}
}