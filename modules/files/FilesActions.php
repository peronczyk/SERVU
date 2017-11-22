<?php

class FilesActions {

	protected $uploads_dir;

	private $ignored_files = ['.', '..', '.htaccess'];


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct() {
		$this->uploads_dir = _STORAGE_DIR . 'uploads/';
	}


	/** ----------------------------------------------------------------------------
	 * Get files list
	 */

	public function get_files_list($sub_dir = '') {
		$files = scandir($this->uploads_dir . $sub_dir);
		foreach ($files as $key => $file_name) {
			if (in_array($file_name, $this->ignored_files)) {
				unset($files[$key]);
			}
		}
		return array_values($files);
	}
}