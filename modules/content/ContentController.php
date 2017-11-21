<?php

class ContentController extends Controller {

	/**
	 * List
	 */

	public function getlist() {
		$content_list = $this->db->select()->from('content')->all();
		$this->rest->set('users-list', $content_list);
		$this->rest->set('bla', '');
	}
}