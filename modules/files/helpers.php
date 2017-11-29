<?php

if (!function_exists('mime_content_type')) {

	function mime_content_type($filename) {
		$mime_types = [

			// Text
			'txt'  => 'text/plain',
			'htm'  => 'text/html',
			'html' => 'text/html',
			'css'  => 'text/css',
			'js'   => 'application/javascript',
			'json' => 'application/json',
			'xml'  => 'application/xml',

			// Images
			'png'  => 'image/png',
			'jpeg' => 'image/jpeg',
			'jpg'  => 'image/jpeg',
			'gif'  => 'image/gif',
			'tiff' => 'image/tiff',
			'tif'  => 'image/tiff',
			'svg'  => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// Archives
			'zip'  => 'application/zip',
			'rar'  => 'application/x-rar-compressed',
			'7z'   => 'application/x-7z-compressed',

			// Audio/Video
			'mp3'  => 'audio/mpeg',
			'mp4'  => 'video/mp4v-es',
			'mov'  => 'video/quicktime',

			// Adobe
			'pdf'  => 'application/pdf',
			'psd'  => 'image/vnd.adobe.photoshop',
			'ai'   => 'application/postscript',
			'eps'  => 'application/postscript',

			// MS Office
			'doc'  => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'rtf'  => 'application/rtf',
			'xls'  => 'application/vnd.ms-excel',
			'ppt'  => 'application/vnd.ms-powerpoint',

			// Open Office
			'odt'  => 'application/vnd.oasis.opendocument.text',
			'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
		];

		$ext = pathinfo($filename, PATHINFO_EXTENSION);

		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		}
		elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = finfo_file($finfo, $filename);
			finfo_close($finfo);
			return $mimetype;
		}
		else {
			return 'directory';
		}
	}
}