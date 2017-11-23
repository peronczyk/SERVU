<?php

class UsersController extends ModulesController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);

		include('UsersActions.php');
		$this->actions = new UsersActions($dependencies);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function get_list() {
		$users_list = $this->actions->get_list();
		$this->_rest->set('users-list', $users_list);
	}


	/** ----------------------------------------------------------------------------
	 * Add user
	 */

	public function add() {
		$this->require_auth(1);
	}


	/** ----------------------------------------------------------------------------
	 * Remove user
	 */

	public function remove() {
		/** @todo */
	}
}