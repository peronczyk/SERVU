<?php

declare(strict_types=1);

final class FilesController {

	private $actions;

	// Dependencies
	private $_rest_store;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_rest_store = $container->get('rest_store');

		require 'files_helpers.php';

		require 'FilesActions.php';
		$this->actions = new FilesActions($container);
	}


	/** ----------------------------------------------------------------------------
	 * List
	 */

	public function list() {
		$location = $_GET['location'] ?? null;

		$files_list = $this->actions->getFilesList($location);
		$this->_rest_store->set('data', $files_list);
	}


	/** ----------------------------------------------------------------------------
	 * Create directory
	 */

	public function createDir() {
		Assumpt::directory($_POST, 'name');

		$location = $_POST['location'] ?? null;

		$result = $this->actions->createDir($_POST['name'], $location);
		$this->_rest_store->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Upload files
	 */

	public function upload() {
		$files    = $_FILES['files']   ?? null;
		$location = $_POST['location'] ?? null;

		$result = $this->actions->upload($files, $location);
		$this->_rest_store->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete file or directory
	 */

	public function delete() {
		$file_location = $_POST['file'] ?? null;

		$result = $this->actions->delete($file_location);
		$this->_rest_store->set('success', $result);
	}
}