<?php

declare(strict_types=1);

class FilesActions {

	protected $uploads_dir;
	protected $max_depth = 8;

	private $ignored_files = ['.', '..', '.htaccess'];


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct() {
		$this->uploads_dir = _CONFIG['storage_dir'] . 'uploads/';
	}


	/** ----------------------------------------------------------------------------
	 * Get files list
	 */

	public function getFilesList($location = '') : array {

		// Validate $location
		if (!empty($location)) {
			if (preg_match('/(\.\.)/i', $location)) {
				throw new Exception("Provided `location` is invalid: `{$location}`");
			}
		}

		$files_dir = trim($this->uploads_dir . $location, '/') . '/';

		if (!is_dir($files_dir)) {
			throw new Exception("Provided `location` does not exist");
		}

		$files_list = scandir($files_dir);
		$files_data = [];

		foreach ($files_list as $key => $file_name) {
			if (!in_array($file_name, $this->ignored_files)) {
				$file_path = $files_dir . $file_name;
				$file_type = mime_content_type($file_path);

				$arr['type'] = $file_type;
				$arr['full-name'] = $file_name;

				// Entries for directories
				if ($file_type == 'directory') {
					$arr['name'] = $file_name;
					$arr['children'] = count(scandir($files_dir . $file_name)) - 2;
				}

				// Entries for files
				else {
					$extension = pathinfo($file_name, PATHINFO_EXTENSION);

					$arr['name']      = str_replace('.' . $extension, '', $file_name);
					$arr['extension'] = $extension;
					$arr['size']      = filesize($file_path);
					$arr['path']      = $file_path;
					$arr['full-path'] = ROOT_URL . $file_path;
				}

				$files_data[] = $arr;
			}
		}
		return $files_data;
	}


	/** ----------------------------------------------------------------------------
	 * Create directory
	 */

	public function createDir(string $dir_name, string $location) {
		// Check if new directory name was provided
		if (empty($dir_name)) {
			throw new Exception("Name of the directory to be created was not provided.");
		}

		$path_chunks = [];
		if ($location && strlen($location) > 0) {
			$path_chunks = explode('/', trim($location, '/'));
		}

		// Check if this directory will be too deep
		if (count($path_chunks) > $this->max_depth) {
			throw new Exception("Could not create directory because the maximum upload depth is reached.");
		}

		// Validate each path chunk
		foreach($path_chunks as $chunk) {
			if (strpbrk($chunk, "/?%*:|\"<>") !== false) {
				throw new Exception("Provided directory path is not valid because of illegal characters.");
			}
		}

		$dir_path = $this->uploads_dir . implode('/', $path_chunks) . '/' . $dir_name;

		if (file_exists($dir_path)) {
			throw new Exception("Directory with this name exists in location: {$dir_path}");
		}

		$result = @mkdir($dir_path);

		if ($result) {
			return true;
		}
		else {
			$last_error = error_get_last();
			if (is_array($last_error)) {
				throw new Exception("Directory creation failed in {$dir_path}. {$last_error['message']}");
			}
			else {
				throw new Exception("Unknown error occured while trying to create directory {$dir_path}");
			}
		}
	}


	/** ----------------------------------------------------------------------------
	 * Upload files
	 */

	public function upload(array $files, string $location) : bool {
		$files_number = count($files['name']);
		$errors = 0;

		for ($i = 0; $i < $files_number; $i++) {
			if (!move_uploaded_file(
				$files['tmp_name'][$i],
				$this->uploads_dir . $location . '/' . $files['name'][$i]
			)) {
				$errors++;
			}
		}

		return (!$errors);
	}


	/** ----------------------------------------------------------------------------
	 * Delete file or directory and it's contents
	 */

	public function delete(string $file_location) : bool {
		$file_path = ROOT_DIR . '/' . $this->uploads_dir . $file_location;
		$errors = 0;
		$type = 'file';

		if (!file_exists($file_path)) {
			throw new Exception("File or directory `{$file_location}` does not exist in specified location of configured uploads directory.");
		}


		/**
		 * Recursive deletion of directory contents. Code below is taken from:
		 * @link https://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it
		 */
		if (is_dir($file_path)) {
			$type = 'directory';
			$it = new RecursiveDirectoryIterator($file_path, RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

			foreach($files as $file) {
				if ($file->isDir()) {
					if (!@rmdir($file->getRealPath())) $errors++;
				}
				else {
					if (!@unlink($file->getRealPath())) $errors++;
				}
			}

			if (!@rmdir($file_path)) $errors++;
		}
		else {
			if (!@unlink($file_path)) $errors++;
		}

		if ($errors > 0) {
			$last_error = error_get_last();
			if (is_array($last_error)) {
				throw new Exception("Error occured while trying to remove {$type} `{$file_path}`: {$last_error['message']}.");
			}
			else {
				throw new Exception("Unknown error occured while trying to remove {$type} `{$file_path}`");
			}
			return false;
		}

		return true;
	}
}