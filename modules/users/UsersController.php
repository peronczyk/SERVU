<?php

class UsersController extends ModulesController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($params) {
		$this->create_dependecies_shortcuts($params['dependencies']);

		include('UsersActions.php');
		$this->actions = new UsersActions($params['dependencies']);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function get_list() {
		$users_list = $this->_db->select()->from('users')->all();
		$this->_rest->set('users-list', $users_list);
	}


	/** ----------------------------------------------------------------------------
	 * Add user
	 */

	public function add() {
		/** @todo */
	}


	/** ----------------------------------------------------------------------------
	 * Remove user
	 */

	public function remove() {
		/** @todo */
	}
}