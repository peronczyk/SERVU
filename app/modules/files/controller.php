<?php

class FilesController extends ModulesController {

	private $actions;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);

		require 'helpers.php';

		require 'actions.php';
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
		$this->require_auth(Auth::LVL_ADMIN);
		$this->require_request_method('POST');

		$result = $this->actions->remove_file(@$_POST['file']);
		$this->_rest->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Create directory
	 */

	public function create_dir() {
		$this->require_auth(Auth::LVL_ADMIN);
		$this->require_request_method('POST');

		$result = $this->actions->create_dir(@$_POST['dirname'], @$_POST['location']);
		$this->_rest->set('success', $result);
	}
}