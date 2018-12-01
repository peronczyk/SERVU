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

		// List children of specified parent
		if (!empty($parent_id)) {
			if (is_numeric($parent_id) || ctype_digit($parent_id)) {
				$content_list = $this->actions->getChildren(intval($parent_id));
			}
			else {
				throw new Exception('Requested content parent id has bad format');
			}
		}

		// Default: list children of root
		else {
			$content_list = $this->actions->getChildren();
		}

		$this->_rest_store->set('data', $content_list);
	}


	/** ----------------------------------------------------------------------------
	 * Add content
	 */

	public function add() {
		Assumpt::text($_POST, 'name', true);

		$name          = $_POST['name'];
		$parent_id     = Sanitise::integerId($_POST, 'parent-id');
		$collection_id = Sanitise::integerId($_POST, 'collection-id', true);

		$result = $this->actions->add($name, $parent_id, $collection_id);

		$this->_rest_store->set('success', ($result) ? true : false);
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection
	 * @todo
	 */

	public function delete($params) {
		Assumpt::integerId($params, 'id', true);

		$result = $this->_db
			->delete()
			->from('content')
			->where("`id` = '{$params['id']}'")
			->all();

		$this->_rest_store->set('success', ($result) ? true : false);
	}
}