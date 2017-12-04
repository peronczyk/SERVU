<?php

class UsersActions {

	private $db_table_name = 'users';


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);
	}


	/** ----------------------------------------------------------------------------
	 * Get list of users
	 */

	public function get_list() {
		$result = $this->_db
			->select()
			->from($this->db_table_name)
			->all();

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Login
	 */

	public function login() {

	}
}