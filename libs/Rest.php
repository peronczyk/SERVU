<?php

class Rest {

	// Storage for data that will be returned to API
	protected $store = [];


	/**
	 * Constructor
	 */

	public function __construct() {
		set_exception_handler(function($exception) {
			$this->store = [
				'error' => [
					'message' => $exception->getMessage(),
					'file'    => $exception->getFile(),
					'line'    => $exception->getLine(),
					'code'    => $exception->getCode(),
					'trace'   => _DEBUG ? $exception->getTrace() : 'Available in debug mode'
				]
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