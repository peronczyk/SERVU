<?php

class FilesController extends ModulesController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);

		require 'helpers.php';

		require 'FilesActions.php';
		$this->actions = new FilesActions($dependencies);
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
				throw new Exception("Parameter `path` have not acceptable value: `{$_GET['path']}`");
			}
		}
		$files_list = $this->actions->get_files_list($path);
		$this->_rest->set('data', $files_list);
	}


	/** ----------------------------------------------------------------------------
	 * Remove file
	 */

	public function remove() {
		if (!$this->require_auth(Auth::LVL_ADMIN)) return false;
		if (empty($_GET['file'])) {
			throw new Exception('You need to specify which file you want to remove by adding query param `file`.');
		}

		$this->_rest->set('file-remove-status', $this->actions->remove_file($_GET['file']));
	}
}