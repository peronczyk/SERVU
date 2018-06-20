<?php

declare(strict_types=1);

class Auth {

	const LVL_USER  = 0;
	const LVL_ADMIN = 1;

	// User lvl store and it's default state
	protected $lvl = self::LVL_USER;

	// Dependencies
	protected $_db;


	/**
	 * Constructor
	 */

	public function __construct(Sqlite $db) {
		$this->_db = $db; // Database dependancy

		if (isset($_SESSION['servant_auth_lvl']) && is_numeric($_SESSION['servant_auth_lvl']) && $_SESSION['servant_auth_lvl'] > self::LVL_USER) {
			$this->set_lvl($_SESSION['servant_auth_lvl']);
		}
	}


	/**
	 * Get auth lvl
	 */

	public function get_lvl() : int {
		return $this->lvl;
	}


	/**
	 * Set auth lvl
	 */

	public function set_lvl($lvl) : void {
		$_SESSION['servant_auth_lvl'] = $lvl;
		$this->lvl = $lvl;
	}


	/**
	 * Validate email
	 */

	public function email_validate($email) : bool {
		return (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) ? true : false;
	}


	/**
	 * Validate password
	 */

	public function password_validate($password) : bool {
		return strlen($password) > 6;
	}


	/**
	 * Password encode
	 */

	public function password_encode($password) : string {
		return password_hash($password, PASSWORD_BCRYPT);
	}


	/**
	 * Verify password
	 */

	public function password_verify($password, $hash) : bool {
		return password_verify($password, $hash);
	}


	/**
	 * Login
	 */

	public function login($email, $password) : bool {
		if (empty($email)) {
			throw new Exception("Email not provided");
		}

		if (empty($password)) {
			throw new Exception("Password not provided");
		}

		if (!$this->email_validate($email)) {
			throw new Exception("Provided email address is incorrect");
		}

		$user = $this->_db
			->select(['id', 'access-lvl', 'email', 'password'])
			->from('users')
			->where("email = '{$email}'")
			->all();

		if (!$user) {
			throw new Exception("User with this email addres does not exist");
		}

		if (!$this->password_verify($password, $user[0]['password'])) {
			throw new Exception("Provided password is incorrect");
		}
		else {
			$this->set_lvl($user[0]['access-lvl']);
			return true;
		}

		return false;
	}


	/**
	 * Logout
	 */

	public function logout() : bool {
		$this->set_lvl(self::LVL_USER);
		return ($this->get_lvl() === self::LVL_USER);
	}

}