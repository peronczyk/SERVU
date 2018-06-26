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
		foreach($collections_list as $key => $val) {
			$collections_list[$key]['fields'] = json_decode($val['fields']);
		}
		$this->_rest_store->set('data', $collections_list);
	}


	/** ----------------------------------------------------------------------------
	 * Add
	 */

	public function add() {
		/** @todo */
	}


	/** ----------------------------------------------------------------------------
	 * Remove
	 */

	public function remove() {
		/** @todo */
	}
}