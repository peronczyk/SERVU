<?php

declare(strict_types=1);

class RestExceptionHandler {

	private $store;
	private $debug;

	public function __construct(RestStore $rest_store, bool $debug = false) {
		$this->store = $rest_store;
		$this->debug = $debug;
	}


	/**
	 * Initiate all handlers
	 * Add custom handlers for all errors and exceptions
	 * to allow of displaying them in restfull way
	 */

	public function initAll() {
		set_error_handler([$this, 'handleError']);
		set_exception_handler([$this, 'handleException']);
		register_shutdown_function([$this, 'handleShutdown']);
	}


	/**
	 * Hendle errors
	 * Mostly usable for catching all notices
	 */

	public function handleError($code, $message, $filename = '', $line = 0, $context = []) {
		$this->store->set('errors', [[
			'message'    => $message,
			'catched-by' => 'Error handler: ' . $this->processFilePath(__FILE__),
			'file'       => $this->processFilePath($filename),
			'line'       => $line,
			'code'       => $code,
		]]);
		$this->store->output();
	}


	/**
	 * Hendle an uncaught exception
	 * Used to catch all custom exceptions thrown by `throw new Exception()`
	 */

	public function handleException($exception) {
		$this->store->set('errors', [[
			'message'    => $exception->getMessage(),
			'catched-by' => 'Exception handler: ' . $this->processFilePath(__FILE__),
			'file'       => $this->processFilePath($exception->getFile()),
			'line'       => $exception->getLine(),
			'code'       => $exception->getCode(),
			'trace'      => $this->debug ? $exception->getTrace() : 'Available only in debug mode',
		]]);
		$this->store->output();
	}


	/**
	 * Handle script shutdown
	 */

	public function handleShutdown() {
		// Check if there was any critical error before the shutdown
		if (!is_null($error = error_get_last()) && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
			ob_end_clean();

			$this->store->set('errors', [[
				'message'    => $error['message'],
				'catched-by' => 'Shutdown handler: ' . $this->processFilePath(__FILE__),
				'file'       => $this->processFilePath($error['file']),
				'line'       => $error['line'],
				'code'       => $error['type'],
			]]);
			$this->store->output();
		}
	}


	/**
	 * Process file path to prevent FPD (Full Path Disclolsure) attack
	 */

	private function processFilePath(string $file_path) : string {
		return ($this->debug)
			? str_replace('\\', '/', $file_path)
			: basename($file_path);
	}
}