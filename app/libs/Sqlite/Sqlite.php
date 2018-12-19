<?php

/**
 * =================================================================================
 *
 * Simple Sqlite abstraction class
 *
 * ---------------------------------------------------------------------------------
 *
 * @category  Database Access
 * @link      https://github.com/peronczyk/servant
 * @author    Bartosz Perończyk <bartosz@peronczyk.com>
 *
 * =================================================================================
 */

declare(strict_types=1);

namespace Sqlite;

class Sqlite {
	protected $connection = false;
	protected $file;

	// Last query result
	protected $result;

	// Array that logs all performed queries objects
	protected $queries = [];

	protected $options = [
		// Decide if errors should be thrown
		'debug' => false,

		// Create database file if it does not exist
		'autocreate' => true,
	];


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(string $file, array $options = []) {
		$this->file = $file;

		if (count($options) > 0) {
			$this->options = array_merge($this->options, $options);
		}

		if (!$this->options['autocreate'] && !is_file($file)) {
			throw new Error('Database file does not exist');
		}
	}


	/** ----------------------------------------------------------------------------
	 * Connect to database file
	 * This method can be performed manually or it will be run automatically
	 * at first use of method `all()`
	 */

	public function connect() {
		$this->connection = new \PDO('sqlite:./' . $this->file);
		$this->connection->setAttribute(
			\PDO::ATTR_ERRMODE,
			$this->options['debug'] ? \PDO::ERRMODE_EXCEPTION : \PDO::ERRMODE_SILENT
		);
	}


	/** ----------------------------------------------------------------------------
	 * Perform query
	 *
	 * @param QueryBuilder $query
	 */

	public function query(QueryBuilder $query) : object {
		if (!$this->connection) {
			$this->connect();
		}

		$query_string = $query->build();

		$this->result = $this->connection->query($query_string);
		$this->queries[] = $query;

		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * Perform query and return array of elements
	 *
	 * @param QueryBuilder $query
	 * @return Array|Boolean
	 */

	public function fetchAll(QueryBuilder $query = null) {
		// Perform query if passed directly to this method
		if ($query) {
			$this->query($query);
		}

		if ($this->result) {
			$result = $this->result->fetchAll(\PDO::FETCH_ASSOC);
			$this->result = null;
			return $result;
		}
		else {
			throw new \Exception("Query needs to be performed before trying to fetch.");
		}
	}


	/** ----------------------------------------------------------------------------
	 * Perform query and return one row as associative array
	 *
	 * @param QueryBuilder $query
	 * @return Array|Boolean
	 */

	public function fetchOne(QueryBuilder $query = null) {
		// Perform query if passed directly to this method
		if ($query) {
			$this->query($query);
		}

		if ($this->result) {
			$result = $this->result->fetch(\PDO::FETCH_ASSOC);
			$this->result = null;
			return $result;
		}
		else {
			throw new \Exception("Query needs to be performed before trying to fetch.");
		}
	}


	/** ----------------------------------------------------------------------------
	 * Get queries log
	 */

	public function getQueriesLog() : array {
		return $this->queries;
	}


	/** ----------------------------------------------------------------------------
	 * Get number of queries that was made
	 */

	public function getQueriesNumber() : int {
		return count($this->queries);
	}
}