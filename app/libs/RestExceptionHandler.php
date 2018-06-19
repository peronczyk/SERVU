<?php

class RestExceptionHandler {

	private $store;

	public function __construct(RestStore $rest_store) {
		$this->store = $rest_store;

		// Add custom handlers for all errors and exceptions
		// to allow of displaying them in restfull way
		set_error_handler([$this, 'handle_error']);
		set_exception_handler([$this, 'handle_exception']);
		register_shutdown_function([$this, 'handle_shutdown']);
	}


	/**
	 * Hendle errors
	 * Mostly usable for catching all notices
	 */

	public function handle_error($code, $message, $filename = '', $line = 0, $context = []) : void {
		$this->store->set('errors', [[
			'message'    => $message,
			'catched-by' => 'Error handler: ' . str_replace('\\', '/', __FILE__),
			'file'       => str_replace('\\', '/', $filename),
			'line'       => $line,
			'code'       => $code,
		]]);
		$this->store->output();
	}


	/**
	 * Hendle an uncaught exception
	 * Used to catch all custom exceptions thrown by `throw new Exception()`
	 */

	public function handle_exception($exception) : void {
		$this->store->set('errors', [[
			'message'    => $exception->getMessage(),
			'catched-by' => 'Exception handler: ' . str_replace('\\', '/', __FILE__),
			'file'       => str_replace('\\', '/', $exception->getFile()),
			'line'       => $exception->getLine(),
			'code'       => $exception->getCode(),
			'trace'      => _CONFIG['debug'] ? $exception->getTrace() : 'Available only in debug mode',
		]]);
		$this->store->output();
	}


	/**
	 * Handle script shutdown
	 */

	public function handle_shutdown() : void {
		// Check if there was any critical error before the shutdown
		if (!is_null($error = error_get_last()) && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
			ob_end_clean();

			$this->store->set('errors', [[
				'message'    => $error['message'],
				'catched-by' => 'Shutdown handler: ' . str_replace('\\', '/', __FILE__),
				'file'       => str_replace('\\', '/', $error['file']),
				'line'       => $error['line'],
				'code'       => $error['type'],
			]]);
			$this->store->output();
		}
	}
}