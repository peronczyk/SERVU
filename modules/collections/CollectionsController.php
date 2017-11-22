<?php

class CollectionsController extends ModulesController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($params) {
		$this->create_dependecies_shortcuts($params['dependencies']);

		include('CollectionsActions.php');
		$this->actions = new CollectionsActions($params['dependencies']);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function get_list() {
		$collections_list = $this->_db->select()->from('collections')->all();
		foreach($collections_list as $key => $val) {
			$collections_list[$key]['fields'] = json_decode($val['fields']);
		}
		$this->_rest->set('collections', $collections_list);
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