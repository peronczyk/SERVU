<?php

class FilesController {

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
		$location = (!empty($_GET['location'])) ? $_GET['location'] : null;

		$files_list = $this->actions->get_files_list($location);
		$this->_rest->set('data', $files_list);
	}


	/** ----------------------------------------------------------------------------
	 * Create directory
	 */

	public function create_dir() {
		$this->require_auth(Auth::LVL_ADMIN);
		$this->require_request_method('POST');

		$dir_name = (!empty($_POST['name']))     ? $_POST['name']     : null;
		$location = (!empty($_POST['location'])) ? $_POST['location'] : null;

		$result = $this->actions->create_dir($dir_name, $location);
		$this->_rest->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Upload files
	 */

	public function upload() {
		$this->require_auth(Auth::LVL_ADMIN);
		$this->require_request_method('POST');

		$result = $this->actions->upload($files, $location);
		$this->_rest->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete file or directory
	 */

	public function delete() {
		$this->require_auth(Auth::LVL_ADMIN);
		$this->require_request_method('POST');

		$location  = (!empty($_POST['location'])) ? $_POST['location'] : null;

		$result = $this->actions->delete_file($_FILES, $location);
		$this->_rest->set('success', $result);
	}
}