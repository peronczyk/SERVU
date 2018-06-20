<?php

declare(strict_types=1);

class DependencyContainer {

	protected $dependencies = [];
	protected $prefix = '_';


	/**
	 * Add
	 */

	public function add($name, $dependency = null) : object {
		if (is_array($name)) {
			$this->dependencies = array_merge($this->dependencies, $name);
		}
		elseif ($dependency) {
			$dependencies[$name] = $dependency;
		}
		else {
			throw new Exception("There is no dependency provided in method 'add' in DependencyContainer");
		}

		return $this;
	}


	/**
	 * Dependencies registrator
	 *
	 * @param object $object
	 */

	public function register(object $object) : void {
		foreach ($this->dependencies as $name => $dependency) {
			$name = $this->prefix . $name;

			if (isset($object->{$name})) {
				throw new Exception("Could not create dependency shortcut `{$name}` because property `{$this->prefix}{$name}` is already used.");
			}
			else {
				$object->{$name} = $dependency;
			}
		}
	}
}