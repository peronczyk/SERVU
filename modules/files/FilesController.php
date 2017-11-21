<?php

class FilesController {

	// Requests
	protected $request;

	// Dependencies shortcusts
	protected $rest;
	protected $db;


	/**
	 * Constructor
	 */

	public function __construct($request, $params) {
		$this->request = $request;

		$this->rest = $params['dependencies']['rest'];
		$this->db = $params['dependencies']['db'];
	}


	/**
	 * List
	 */

	public function get_list() {
		$users_list = $this->db->select()->from('files')->all();
		$this->rest->set('users_list', $users_list);
		$this->rest->set('route', 'users/list');
	}
}