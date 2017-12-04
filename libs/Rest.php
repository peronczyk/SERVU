<?php

class Rest {

	// Storage for data that will be returned to API
	protected $store = [];

	// Stores all throwable errors
	protected $error_list = [];


	/**
	 * Constructor
	 */

	public function __construct() {
		set_exception_handler(function($exception) {
			$this->store = [
				'errors' => [[
					'message'    => $exception->getMessage(),
					'error-info' => 'This error was catched automatically by exception handler in ' . str_replace('\\', '/', __FILE__),
					'file'       => str_replace('\\', '/', $exception->getFile()),
					'line'       => $exception->getLine(),
					'code'       => $exception->getCode(),
					'trace'      => $exception->getTrace(),
				]]
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


	/**
	 * Add one error or array of errors to error list
	 *
	 * @param string|array $error_id
	 * @param string $error_value
	 */

	public function add_error($error_id, $error_value = null) {
		if (is_array($error_id)) {
			$this->error_list = array_merge($this->error_list, $error_id);
		}
		else {
			$error_list[$error_id] = $error_value;
		}
	}


	/**
	 * Throw error
	 */

	public function throw_error($error_id, $file = null, $line = null) {
		$this->store = [
			'errors' => [[
				'message' => $this->error_list[$error_id] ?: $error_id,
				'file' => $file,
				'line' => $line,
			]]
		];
		$this->send();
	}
}