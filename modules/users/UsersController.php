<?php

class UsersController extends Controller {


	/**
	 * List
	 */

	public function get_list() {
		$users_list = $this->db->select()->from('users')->all();
		$this->rest->set('users-list', $users_list);
		$this->rest->set('route', 'users/list');
	}


	/**
	 * Add
	 */

	public function add() {}


	/**
	 * Remove
	 */

	public function remove() {}
}