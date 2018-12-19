<?php

declare(strict_types=1);

final class ContentController {

	private $actions;

	// Dependencies
	private $_rest_store;
	private $_db;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_rest_store = $container->get('rest_store');
		$this->_db = $container->get('db');

		require 'ContentActions.php';
		$this->actions = new ContentActions($container);
	}


	/** ----------------------------------------------------------------------------
	 * Index
	 */

	public function index($request) {
		Assumpt::integer($request[0], 'id', true);
		$this->_rest_store->set('details', $this->actions->getDetails($request[0]));
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function list() {
		$content_list = [];
		$parent_id = $_GET['parent-id'] ?? null;

		$content_list = $this->actions->getChildren($parent_id);

		$this->_rest_store->set('data', $content_list);
	}


	/** ----------------------------------------------------------------------------
	 * Add content
	 */

	public function add() {
		$name          = $_POST['name'] ?? '';
		$parent_id     = $_POST['parent-id'] ?? null;
		$collection_id = $_POST['collection-id'] ?? null;

		$result = $this->actions->add($name, $parent_id, $collection_id);

		$this->_rest_store->set('success', ($result));
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection
	 * @todo
	 */

	public function delete($params) {
		$result = $this->actions->delete($params['id']);

		$this->_rest_store->set('success', ($result));
	}
}