<?php

class Router {
	protected $request;
	protected $routes = [];


	/**
	 *
	 */

	protected function get_first_request() {
		if (!empty($this->request[0])) return $this->request[0];
		else return null;
	}


	/**
	 *
	 */

	protected function get_last_request() {
		$request_num = count($this->request);
		if ($request_num) return $this->request[$request_num - 1];
	}


	/**
	 * Add route
	 */

	public function add_route($arr) {
		$this->routes[] = $arr;
	}


	/**
	 * Run route
	 */

	public function run_route($request) {
		$this->request = explode('/', $request);

		foreach($routes as $route) {
			if ($route['path'] == $request) {
				include($route['file']);
			}
		}
	}
}