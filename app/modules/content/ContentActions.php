<?php

declare(strict_types=1);

class ContentActions {

	private $db_table_name = 'content';

	// Dependencies
	private $_db;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_db = $container->get('db');
	}


	/** ----------------------------------------------------------------------------
	 * Get one content details
	 */

	public function getDetails($id) {
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

	public function getNumberOfChildren($parent_id) {
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

	public function getChildren($parent_id = 0) {
		$result = $this->_db
			->select()
			->from($this->db_table_name)
			->where("`parent-id` = {$parent_id}")
			->orderBy('order')
			->all();

		// Add number of children
		foreach ($result as $key => $val) {
			$result[$key]['children'] = $this->getNumberOfChildren($val['id']);
		}

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Add new content
	 *
	 * @todo fields-values
	 */

	public function add() {
		return $this->_db
			->insert([
				'name'          => $_POST['content-name'],
				'parent-id'     => $_POST['parent-id'] ?? 0,
				'collection-id' => $_POST['collection-id'],
				'fields-values' => '@TODO',
			])
			->into('content');
	}
}