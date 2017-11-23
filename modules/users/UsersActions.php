<?php

class UsersActions {

	private $dependencies;
	private $db_table_name = 'users';


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$this->dependencies = $dependencies;
	}


	/** ----------------------------------------------------------------------------
	 * Get list of users
	 */

	public function get_list() {
		$result = $this->dependencies['db']
			->select()
			->from($this->db_table_name)
			->all();

		return $result;
	}
}