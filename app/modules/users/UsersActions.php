<?php

declare(strict_types=1);

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

	public function getList() {
		$result = $this->_db
			->select()
			->from($this->db_table_name)
			->all();

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Create user
	 */

	public function createUser($email, $password_hash, $lvl = Auth::LVL_USER) {
		if ($this->userExists($email)) {
			throw new Exception('User with this email address already exist.');
		}

		$result = $this->_db
			->insert([
				'email'      => $email,
				'password'   => $password_hash,
				'access-lvl' => $lvl
			])
			->into($this->db_table_name);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Check if user with specified email address exists
	 */

	public function userExists($email) {
		$result = $this->_db
			->count()
			->from($this->db_table_name)
			->where("email = '{$email}'")
			->all();

		return ($result > 0);
	}
}