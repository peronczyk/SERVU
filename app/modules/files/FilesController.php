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

	public function getList() {
		$location = $_GET['location'] ?? null;

		$files_list = $this->actions->getFilesList($location);
		$this->_rest_store->set('data', $files_list);
	}


	/** ----------------------------------------------------------------------------
	 * Create directory
	 */

	public function createDir() {
		$dir_name = $_POST['name']     ?? null;
		$location = $_POST['location'] ?? null;

		$result = $this->actions->createDir($dir_name, $location);
		$this->_rest_store->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Upload files
	 */

	public function uploadFile() {
		$result = $this->actions->upload($files, $location);
		$this->_rest_store->set('success', $result);
	}


	/** ----------------------------------------------------------------------------
	 * Delete file or directory
	 */

	public function deleteFile() {
		$location = (!empty($_POST['location'])) ? $_POST['location'] : null;

		$result = $this->actions->deleteFile($_FILES, $location);
		$this->_rest_store->set('success', $result);
	}
}