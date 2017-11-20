<?php

class UsersController {

	// Requests
	protected $request;

	// Dependencies shortcusts
	protected $rest;


	/**
	 * Constructor
	 */

	public function __construct($request, $params) {
		$this->request = $request;

		if (!$params['deps']['rest']) {
			throw new Exception('Required dependency is missing: `rest`');
		}

		$this->rest = $params['deps']['rest'];
	}


	/**
	 * Index
	 */

	public function index() {
		$this->rest->set('route', 'users/index');
	}
}