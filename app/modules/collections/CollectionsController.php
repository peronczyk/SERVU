<?php

declare(strict_types=1);

class CollectionsController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);

		require 'CollectionsActions.php';
		$this->actions = new CollectionsActions($dependencies);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function getList() {
		$collections_list = $this->_db->select()->from('collections')->all();
		foreach($collections_list as $key => $val) {
			$collections_list[$key]['fields'] = json_decode($val['fields']);
		}
		$this->_rest->set('data', $collections_list);
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