<?php

declare(strict_types=1);

use Sqlite\QueryBuilder as Query;

class UsersActions {

	const DB_TABLE_NAME = 'users';

	// Dependencies
	private $_db;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_db = $container->get('db');
	}


	/** ----------------------------------------------------------------------------
	 * Get list of users
	 */

	public function getList() {
		$result = $this->_db->fetchAll(
			(new Query)
				->selectFrom(self::DB_TABLE_NAME)
		);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Create user
	 */

	public function createUser($email, $password_hash, $lvl = Auth::LVL_USER) {
		if ($this->userExists($email)) {
			throw new Exception('User with this email address already exist.');
		}

		$result = $this->_db->fetchOne(
			(new Query)
				->insertInto(self::DB_TABLE_NAME)
				->values([
					'email'      => $email,
					'password'   => $password_hash,
					'access-lvl' => $lvl
				])
		);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Check if user with specified email address exists
	 */

	public function userExists($email) {
		$result = $this->_db->fetchOne(
			(new Query)
				->countIn(self::DB_TABLE_NAME)
				->where("email = '{$email}'")
		);

		return ((int) $result['count'] > 0);
	}
}