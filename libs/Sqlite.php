<?php

/**
 * Simple Sqlite abstraction class
 */

class Sqlite {
	protected $connection = false;
	protected $file;
	protected $debug;

	protected $command;
	protected $fields;
	protected $conditions;
	protected $table;

	protected $result;

	protected $log = [];


	/**
	 * Constructor
	 */

	public function __construct($file, $debug = false) {
		if (is_file($file)) {
			$this->file = $file;
			$this->debug = $debug;
		}
		else {
			throw new Error('Database file does not exist');
		}
	}

	/**
	 * Connect to database file
	 * This method can be performed manually or it will be run automatically
	 * at first use of method `all()`
	 * @param string $file - path to sqlite file
	 */

	public function connect() {
		$this->connection = new PDO('sqlite:./' . $this->file);
		$this->connection->setAttribute(
			PDO::ATTR_ERRMODE,
			$this->debug ? PDO::ERRMODE_EXCEPTION : PDO::ERRMODE_SILENT
		);
	}


	/**
	 * SELECT
	 * @param string|array $fields
	 */

	public function select($fields = '*') {
		$this->command = 'select';
		$this->fields = $fields;
		return $this;
	}

	/**
	 * FROM
	 * @param string $table
	 */

	public function from($table) {
		$this->table = $table;
		return $this;
	}


	/**
	 * WHERE
	 */

	public function where($conditions) {
		$this->conditions = $conditions;
		return $this;
	}


	/**
	 * Perform query and return array of elements
	 */

	public function all() {
		// Autoconnect to DB if there is no connection
		if (!$this->connection) $this->connect();

		// Perform query and fetch data
		$this->result = $this->connection->query($this->prepare_query());
		return $this->result->fetchAll(PDO::FETCH_ASSOC);
	}


	/**
	 * Prepare query
	 */

	protected function prepare_query() {
		switch ($this->command) {
			case 'select':
				$fields = '';
				if (is_array($this->fields)) {
					$fields_num = count($this->fields) - 1;
					foreach($this->fields as $i => $field) {
						$fields .= "`{$field}`";
						if ($i < $fields_num) $fields .= ", ";
					}
				}
				else $fields = $this->fields;
				$query = "SELECT {$fields} FROM `{$this->table}`";
				break;
		}

		$this->log[] = $query;
		return $query;
	}


	/**
	 * Get queries log
	 */

	public function get_log() {
		return $this->log;
	}
}