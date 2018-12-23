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
	 * List
	 */

	public function list() {
		$parent_id = $_GET['parent-id'] ?? null;

		$content_list = $this->actions->getChildren($parent_id);

		$this->_rest_store->set('data', $content_list);
	}


	/** ----------------------------------------------------------------------------
	 * Get one content's data
	 */

	public function get($params) {
		$result = $this->actions->getContentDataById($params['id']);
		$this->_rest_store->set(Config::$API_RESULT_DATA, $result);
	}


	/** ----------------------------------------------------------------------------
	 * Add content
	 */

	public function add() {
		$result = $this->actions->addContent(
			$_POST['name'] ?? '',
			$_POST['parent-id'] ?? null,
			$_POST['collection-id'] ?? null
		);

		$this->_rest_store->set('success', ($result));
	}


	/** ----------------------------------------------------------------------------
	 * Modify existing content
	 */

	public function modify($params) {
		$result = $this->actions->updateContentDataById(
			$params['id'],
			$_POST['name'] ?? '',
			$_POST['collection-id'] ?? null
		);

		$this->_rest_store->set(Config::$API_RESULT_BOOL, $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete content
	 * @todo
	 */

	public function delete($params) {
		$result = $this->actions->delete($params['id']);

		$this->_rest_store->set('success', ($result));
	}
}