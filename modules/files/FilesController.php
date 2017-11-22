<?php

class FilesController extends ModulesController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($params) {
		$this->create_dependecies_shortcuts($params['dependencies']);

		include('FilesActions.php');
		$this->actions = new FilesActions($params['dependencies']);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function get_list() {
		$files_list = $this->actions->get_files_list();
		$this->_rest->set('files-list', $files_list);
	}
}