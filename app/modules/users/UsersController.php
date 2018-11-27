<?php

declare(strict_types=1);

final class UsersController {

	private $actions;

	// Dependencies
	private $_auth;
	private $_rest_store;
	private $_db;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_auth = $container->get('auth');
		$this->_rest_store = $container->get('rest_store');
		$this->_db = $container->get('db');

		require 'UsersActions.php';
		$this->actions = new UsersActions($container);
	}


	/** ----------------------------------------------------------------------------
	 * Login
	 */

	public function login() {
		$login_status = $this->_auth->login(
			$_POST['email']    ?? null,
			$_POST['password'] ?? null
		);
		$this->_rest_store->set('status', $login_status);
	}


	/** ----------------------------------------------------------------------------
	 * Logout
	 */

	public function logout() {
		$logout_status = $this->_auth->logout();
		$this->_rest_store->set('status', $logout_status);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function list() {
		$users_list = $this->actions->getList();
		$this->_rest_store->set('data', $users_list);
	}


	/** ----------------------------------------------------------------------------
	 * Create user
	 */

	public function create() {
		if (empty($_POST['email'])) {
			throw new Exception("Email not provided");
		}

		if (empty($_POST['password'])) {
			throw new Exception("Password not provided");
		}

		if (!$this->_auth->emailValidate($_POST['email'])) {
			throw new Exception("Provided email address is incorrect");
		}

		if (!$this->_auth->passwordValidate($_POST['password'])) {
			throw new Exception("Provided password does not meet the requirements");
		}

		$result = $this->actions->createUser(
			$_POST['email'],
			$this->_auth->passwordEncode($_POST['password']),
			Auth::LVL_ADMIN
		);

		if (!$result) {
			throw new Exception("Unknown error occured while adding new user");
		}
		else {
			$this->_rest_store->set('status', true);
		}
	}


	/** ----------------------------------------------------------------------------
	 * Delete user
	 */

	public function delete($params) {
		if (!isset($params['id'])) {
			throw new Exception("Param 'id' is missing.");
		}

		$users_number = count($this->actions->getList());
		if ($users_number === 1) {
			throw new Exception("You can't delete the only account.");
		}

		$result = $this->_db
			->delete()
			->from('users')
			->where("`id` = '{$params['id']}'")
			->all();

		$this->_rest_store->set('params', $result);
	}
}