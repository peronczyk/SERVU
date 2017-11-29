<?php

class FilesActions {

	protected $uploads_dir;

	private $ignored_files = ['.', '..', '.htaccess'];


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);

		$this->uploads_dir = _STORAGE_DIR . 'uploads/';
	}


	/** ----------------------------------------------------------------------------
	 * Get files list
	 */

	public function get_files_list($sub_dir = '') {
		$files_dir = $this->uploads_dir . $sub_dir;

		if (!is_dir($files_dir)) {
			return false;
		}

		$files_list = scandir($files_dir);
		$files_data = [];

		foreach ($files_list as $key => $file_name) {
			if (!in_array($file_name, $this->ignored_files)) {
				$file_path = $files_dir . $file_name;
				$file_type = mime_content_type($file_path);

				$arr = [
					'name' => $file_name,
					'type' => $file_type,
				];

				if ($file_type == 'directory') {
					$arr['children'] = count(scandir($files_dir . $file_name)) - 2;
				}
				else {
					$arr['path'] = $file_path;
					$arr['full-path'] = APP_ROOT_URL . $file_path;
					$arr['extension'] = pathinfo($file_name, PATHINFO_EXTENSION);
				}

				$files_data[] = $arr;
			}
		}
		return $files_data;
	}
}