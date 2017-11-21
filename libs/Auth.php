<?php

class Auth {

	// Dependencies
	protected $db;

	protected $lvl = 0;


	/**
	 * Constructor
	 */

	public function __construct($db) {
		$this->db = $db;
	}


	/**
	 * Get auth lvl
	 */

	public function get() {
		return $this->lvl;
	}


	/**
	 * Set auth lvl
	 */

	public function set($lvl) {
		$this->lvl = $lvl;
	}
}