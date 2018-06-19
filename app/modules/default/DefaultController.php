<?php

class DefaultController extends ModulesController {

	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct($dependencies) {
		$dependencies->register($this);
	}


	/** ----------------------------------------------------------------------------
	 * Default method
	 */

	public function index() {
		$this->_rest->set('nodes', ['collections', 'content', 'files', 'users']);
	}

}