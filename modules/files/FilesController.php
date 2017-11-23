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
		$path = null;
		if (!empty($_GET['path'])) {
			if (!preg_match('/(\.\.)/i', $_GET['path'])) {
				$path = $_GET['path'];
			}
			else {
				throw new Exception("Parameter `path` have wrong value: `{$_GET['path']}`");
			}
		}
		$files_list = $this->actions->get_files_list($path);
		$this->_rest->set('files-list', $files_list);
	}
}