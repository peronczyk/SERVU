<?php

declare(strict_types=1);

class Auth {

	const LVL_USER  = 0;
	const LVL_ADMIN = 1;

	// User lvl and it's default state
	protected $lvl = self::LVL_USER;

	// Dependencies
	protected $_db;


	/**
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_db = $container->get('db');

		if (isset($_SESSION['servant_auth_lvl']) && is_numeric($_SESSION['servant_auth_lvl']) && $_SESSION['servant_auth_lvl'] > self::LVL_USER) {
			$this->setLvl($_SESSION['servant_auth_lvl']);
		}
	}


	/**
	 * Get auth lvl
	 */

	public function getLvl() : int {
		return $this->lvl;
	}


	/**
	 * Set auth lvl
	 */

	public function setLvl($lvl) {
		$_SESSION['servant_auth_lvl'] = $lvl;
		$this->lvl = $lvl;
	}


	/**
	 * Validate email
	 */

	public function emailValidate($email) : bool {
		return (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) ? true : false;
	}


	/**
	 * Validate password
	 */

	public function passwordValidate($password) : bool {
		return strlen($password) > 6;
	}


	/**
	 * Password encode
	 */

	public function passwordEncode($password) : string {
		return password_hash($password, PASSWORD_BCRYPT);
	}


	/**
	 * Verify password
	 */

	public function passwordVerify($password, $hash) : bool {
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

		if (!$this->emailValidate($email)) {
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

		if (!$this->passwordVerify($password, $user[0]['password'])) {
			throw new Exception("Provided password is incorrect");
		}
		else {
			$this->setLvl($user[0]['access-lvl']);
			return true;
		}

		return false;
	}


	/**
	 * Logout
	 */

	public function logout() : bool {
		$this->setLvl(self::LVL_USER);
		return ($this->getLvl() === self::LVL_USER);
	}

}