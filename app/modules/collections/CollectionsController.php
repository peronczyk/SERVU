<?php

declare(strict_types=1);

final class CollectionsController {
	const DB_TABLE_NAME = 'collections';

	private $actions;

	// Dependencies
	private $_db;
	private $_rest_store;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_db         = $container->get('db');
		$this->_rest_store = $container->get('rest_store');

		require 'CollectionsActions.php';
		$this->actions = new CollectionsActions($container);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function list() {
		$collections_list = $this->_db
			->select()
			->from(self::DB_TABLE_NAME)
			->all();

		// Decode field's JSON string in all collections
		foreach($collections_list as $key => $val) {
			$collections_list[$key]['fields'] = json_decode($val['fields']);
		}

		$this->_rest_store->set('data', $collections_list);
	}


	/** ----------------------------------------------------------------------------
	 * Get one collection's data
	 */

	public function get($params) {
		if (!isset($params['id'])) {
			throw new Exception("Param 'id' is missing.");
		}

		$result = $this->_db
			->select()
			->from(self::DB_TABLE_NAME)
			->where("`id` = '{$params['id']}'")
			->all();

		if (is_array($result) && count($result) > 0) {
			$result = $result[0];
			$result['fields'] = json_decode($result['fields']);
		}
		else {
			$result = null;
		}

		$this->_rest_store->set('data', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Add
	 */

	public function add() {
		$result = $this->_db
			->insert([
				'name'   => $_POST['collection-name'],
				'fields' => json_encode($_POST['field-list']),
			])
			->into(self::DB_TABLE_NAME);

		$this->_rest_store->set('post', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection
	 * @todo
	 */

	public function delete($params) {
		if (!isset($params['id'])) {
			throw new Exception("Param 'id' is missing.");
		}

		$result = $this->_db
			->delete()
			->from(self::DB_TABLE_NAME)
			->where("`id` = '{$params['id']}'")
			->all();

		$this->_rest_store->set('params', $result);
	}
}