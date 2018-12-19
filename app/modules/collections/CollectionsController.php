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

		$this->_rest_store->set(Config::$API_RESULT_DATA, $collection_list);
	}


	/** ----------------------------------------------------------------------------
	 * Get one collection's data
	 */

	public function get($params) {
		$result = $this->actions->getCollectionDataById($params['id']);
		$this->_rest_store->set(Config::$API_RESULT_DATA, $result);
	}


	/** ----------------------------------------------------------------------------
	 * Add
	 */

	public function add() {
		$result = $this->actions->addCollection(
			$_POST['name'],
			$_POST['fields']
		);

		$this->_rest_store->set(Config::$API_RESULT_BOOL, $result);
	}


	/** ----------------------------------------------------------------------------
	 * Modify existing collection
	 */

	public function modify($params) {
		$result = $this->actions->updateCollectionDataById(
			$params['id'],
			$_POST['name'],
			$_POST['fields']
		);

		$this->_rest_store->set(Config::$API_RESULT_BOOL, $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection
	 */

	public function delete($params) {
		$result = $this->actions->deleteCollectionById($params['id']);

		$this->_rest_store->set(Config::$API_RESULT_BOOL, $result);
	}
}