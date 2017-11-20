<?php

class Rest {

	protected $store = [];


	/**
	 * Constructor
	 */

	public function __construct() {
		set_exception_handler(function($exception) {
			$this->store = [
				'message' => $exception->getMessage(),
			];
			$this->send();
		});
	}


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

	public function send() {
		header('Content-type: application/json');
		echo json_encode($this->store);
	}
}