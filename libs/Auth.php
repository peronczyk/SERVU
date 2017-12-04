<?php

class Auth {

	const LVL_USER  = 0;
	const LVL_ADMIN = 1;

	// Dependencies
	protected $_db;

	protected $lvl = 1;


	/**
	 * Constructor
	 */

	public function __construct($db) {
		$this->_db = $db;

		if (isset($_SESSION['brom_auth_lvl']) && is_numeric($_SESSION['brom_auth_lvl']) && $_SESSION['brom_auth_lvl'] > self::LVL_USER) {
			$this->set($_SESSION['brom_auth_lvl']);
		}
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
		$_SESSION['brom_auth_lvl'] = $lvl;
		$this->lvl = $lvl;
	}
}