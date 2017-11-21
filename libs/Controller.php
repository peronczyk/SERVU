<?php

class Controller {

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

}