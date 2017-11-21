<?php

class ContentController extends Controller {

	/**
	 * List
	 */

	public function get_list() {
		$parent_id = 0;

		if (!empty($_GET['parent-id'])) {
			if (is_numeric($_GET['parent-id'])) {
				$parent_id = (int)$_GET['parent-id'];
			}
			else {
				throw new Exception('Requested content parent id has bad format: `' . $_GET['parent-id'] . '` [' . gettype($_GET['parent-id']) . ']');
			}
		}

		$content_list = $this->db->select()->where("`parent-id` = {$parent_id}")->from('content')->all();
		$this->rest->set('content-list', $content_list);
	}
}