<?php

declare(strict_types=1);

class ContentActions {

	private $db_table_name = 'content';


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);
	}


	/** ----------------------------------------------------------------------------
	 * Get one content details
	 */

	public function get_details($id) {
		$result = $this->_db
			->select()
			->from($this->db_table_name)
			->where("`id` = {$id}")
			->all();

		return $result[0] ?: null;
	}


	/** ----------------------------------------------------------------------------
	 * Get number of children
	 */

	public function get_number_of_children($parent_id) {
		$count_children = $this->_db
			->count()
			->from($this->db_table_name)
			->where("`parent-id` = {$parent_id}")
			->all();

		return (int)$count_children[0]['count'] ?: 0;
	}


	/** ----------------------------------------------------------------------------
	 * Get children of defined parent
	 *
	 * @param int $parent_id - default parent is root (0)
	 */

	public function get_children($parent_id = 0) {
		$result = $this->_db
			->select()
			->from($this->db_table_name)
			->where("`parent-id` = {$parent_id}")
			->order_by('order')
			->all();

		// Add number of children
		foreach ($result as $key => $val) {
			$result[$key]['children'] = $this->get_number_of_children($val['id']);
		}

		return $result;
	}
}