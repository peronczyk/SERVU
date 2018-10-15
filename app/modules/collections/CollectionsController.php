<?php

declare(strict_types=1);

final class CollectionsController {

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

	public function getList() {
		$collections_list = $this->_db->select()->from('collections')->all();

		// Decode fields JSON string in all collections
		foreach($collections_list as $key => $val) {
			$collections_list[$key]['fields'] = json_decode($val['fields']);
		}

		$this->_rest_store->set('data', $collections_list);
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
			->into('collections');

		$this->_rest_store->set('post', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection
	 * @todo
	 */

	public function delete($params) {
		if (!$params['id']) {
			throw new Exception("Param 'id' is missing.");
		}

		$result = $this->_db
			->delete()
			->from('collections')
			->where("`id` = '{$params['id']}'")
			->all();

		$this->_rest_store->set('params', $result);
	}
}