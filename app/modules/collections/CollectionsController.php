<?php

declare(strict_types=1);

final class CollectionsController {

	private $actions;

	// Dependencies
	private $_rest_store;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_rest_store = $container->get('rest_store');

		require 'CollectionsActions.php';
		$this->actions = new CollectionsActions($container);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function list() {
		$collection_list = $this->actions->getCollectionList();

		$this->_rest_store->set('data', $collection_list);
	}


	/** ----------------------------------------------------------------------------
	 * Get one collection's data
	 */

	public function get($params) {
		Assumpt::stringInt($params, 'id');
		$collection_id = intval($params['id']);

		$result = $this->actions->getCollectionDataById($collection_id);

		$this->_rest_store->set('data', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Add
	 */

	public function add() {
		Assumpt::text($_POST, 'name', true);

		$result = $this->actions->addCollection(
			$_POST['name'],
			$_POST['fields']
		);

		$this->_rest_store->set('post', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Modify existing collection
	 */

	public function modify() {

	}


	/** ----------------------------------------------------------------------------
	 * Delete collection
	 */

	public function delete($params) {
		Assumpt::stringInt($params, 'id');
		$collection_id = intval($params['id']);

		$result = $this->actions->deleteCollectionById($collection_id);

		$this->_rest_store->set('params', $result);
	}
}