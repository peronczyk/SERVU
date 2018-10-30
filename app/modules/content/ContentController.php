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
		if (is_numeric($request[0])) {
			$this->_rest_store->set('details', $this->actions->getDetails($request[0]));
		}
		else {
			throw new Exception('Requested content id should be numeric');
		}
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function getList() {
		$content_list = [];

		// List children of specified parent
		if (!empty($_GET['parent-id'])) {
			if (!is_numeric($_GET['parent-id'])) {
				throw new Exception('Requested content parent id has bad format');
			}
			else {
				$content_list = $this->actions->getChildren($_GET['parent-id']);
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
		$result = $this->actions->add();

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
			->from('content')
			->where("`id` = '{$params['id']}'")
			->all();

		$this->_rest_store->set('params', $result);
	}
}