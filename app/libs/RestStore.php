<?php

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

	public function set($key, $value) {
		$this->store[$key] = $value;
	}


	/**
	 * Display JSON
	 */

	public function output() {
		header('Content-type: application/json');
		echo json_encode($this->store);
		exit;
	}
}