<?php

class Controller {

	protected $dependencies;


	/**
	 * Constructor
	 */

	public function __construct($params) {
		$this->dependencies = $params['dependencies'];

		// Create properties that are shortcuts to dependencies
		foreach ($params['dependencies'] as $key => $val) {
			$this->{$key} = $val;
		}
	}

}