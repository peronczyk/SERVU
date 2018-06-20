<?php

declare(strict_types=1);

class RestStore {

	// Storage for data that will be
	protected $store = [];


	/**
	 * Get store state
	 */

	public function get() {
		return $this->store;
	}


	/**
	 * Set store variable
	 */

	public function set($key, $value) : object {
		$this->store[$key] = $value;
		return $this;
	}


	/**
	 * Display JSON
	 */

	public function output() : void {
		header('Content-type: application/json');
		echo json_encode($this->store);
		exit;
	}
}