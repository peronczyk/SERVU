<?php

class CollectionsController extends Controller {

	/**
	 * List
	 */

	public function getlist() {
		$collections_list = $this->db->select()->from('collections')->all();
		foreach($collections_list as $key => $val) {
			$collections_list[$key]['fields'] = json_decode($val['fields']);
		}
		$this->rest->set('collections', $collections_list);
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