<?php

class Router {

	// Stores array of request pieces
	public $request;

	// Stores initiated controller
	protected $controller;

	// Class options
	protected $options = [
		'controllers_dir' => '',
		'default_controller' => 'Home',
		'default_method' => 'index',

		// This array allows to use forbidden keywords in requests.
		// For example request 'users/list' will run method 'users/getlist'
		'method_names_replacement' => [
			'list' => 'getlist',
		]
	];


	/**
	 * Constructor
	 */

	public function __construct($uri, $options = []) {
		$this->request = explode('/', $uri);

		if (count($options) > 0) {
			$this->options = array_merge($this->options, $options);
		}
	}


	/**
	 * Shift request by one
	 */

	public function shift_request() {
		array_shift($this->request);
		return $this->request;
	}


	/**
	 * Get first request
	 */

	public function get_first_request() {
		if (!empty($this->request[0])) return $this->request[0];
		else return null;
	}


	/**
	 * Get last request
	 */

	public function get_last_request() {
		$request_num = count($this->request);
		if ($request_num) return $this->request[$request_num - 1];
	}


	/**
	 * Run route
	 *
	 * @param array $additional_params - array of variables that will be passed to
	 *   constructor
	 */

	public function run($additional_params = []) {

		/**
		 * Run controller
		 */

		$controller_dir = $this->get_first_request();

		if (empty($controller_dir)) {
			$controller_name = $this->options['default_controller'];
		}
		else {
			$controller_name = ucfirst($controller_dir);
			$this->shift_request();
		}

		$controller_file = $this->options['controllers_dir'] . $controller_dir . '/' . $controller_name . 'Controller.php';
		if (file_exists($controller_file)) {
			include_once($controller_file);
		}
		else {
			throw new Exception('Controller `' . $controller_name . '` file does not exist');
		}

		$controller_name = $controller_name . 'Controller';
		if (class_exists($controller_name)) {
			$this->controller = new $controller_name($this->request, $additional_params);
		}
		else {
			throw new Exception('Controller class `' . $controller_name . '` is missing in file `' . $controller_file . '`');
		}


		/**
		 * Run method
		 */

		$method_name = $this->get_first_request();
		if (empty($method_name)) {
			$method_name = $this->options['default_method'];
		}
		else {
			$method_name = str_replace(
				array_keys($this->options['method_names_replacement']),
				array_values($this->options['method_names_replacement']),
				$method_name);

			$this->shift_request();
		}

		if (method_exists($this->controller, $method_name)) {
			call_user_func_array([$this->controller, $method_name], []);
		}
		else {
			throw new Exception('Unknown method `' . $method_name . '`');
		}
	}
}