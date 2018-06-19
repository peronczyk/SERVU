<?php

class ContentController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);

		require 'ContentActions.php';
		$this->actions = new ContentActions($dependencies);
	}


	/** ----------------------------------------------------------------------------
	 * Index
	 */

	public function index($request) {
		if (is_numeric($request[0])) {
			$this->_rest->set('details', $this->actions->get_details($request[0]));
		}
		else {
			throw new Exception('Requested content id should be numeric');
		}
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function get_list() {
		$content_list = [];

		// List children of specified parent
		if (!empty($_GET['parent-id'])) {
			if (!is_numeric($_GET['parent-id'])) {
				throw new Exception('Requested content parent id has bad format');
			}
			else {
				$content_list = $this->actions->get_children($_GET['parent-id']);
			}
		}

		// Default: list children of root
		else {
			$content_list = $this->actions->get_children();
		}

		$this->_rest->set('data', $content_list);
	}
}