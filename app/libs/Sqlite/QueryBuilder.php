<?php

/**
 * =================================================================================
 *
 * Simple Sqlite query builder
 *
 * ---------------------------------------------------------------------------------
 *
 * EXAMPLES:
 *
 * Fetch row/rows from table:
 * @example (new QueryBuilder)->selectFrom(<table>);
 * @example (new QueryBuilder)->selectFrom(<table>)->orderBy(<order>, <dir>);
 * @example (new QueryBuilder)->selectFrom(<table>)->fields(<arr>)->where(<confitions>);
 *
 * Insert row into table
 * @example (new QueryBuilder)->insertInto(<table>)->values(<arr>);
 *
 * Update values in the table
 * @example (new QueryBuilder)->update(<table>)->values(<arr>)->where(<conditions>)
 *
 * Delete row/rows in the table
 * @example (new QueryBuilder)->deleteFrom(<table>)->where(<conditions>)
 *
 * Count rows
 * @example (new QueryBuilder)->countIn(<table>)->where(<conditions>)
 *
 * ---------------------------------------------------------------------------------
 *
 * @category  Database Access
 * @link      https://github.com/peronczyk/servu
 * @author    Bartosz Perończyk <bartosz@peronczyk.com>
 *
 * =================================================================================
 */

declare(strict_types=1);

namespace Sqlite;

class QueryBuilder {

	/**
	 * Query types
	 */
	const SELECT = 'SELECT';
	const INSERT = 'INSERT';
	const UPDATE = 'UPDATE';
	const DELETE = 'DELETE';
	const DROP   = 'DROP';

	/**
	 * Order dirs
	 */
	const ASC = 'ASC';
	const DESC = 'DESC';

	/**
	 * Database table name.
	 * @var String
	 */
	protected $table;

	/**
	 * Defines which SQL query type should be used.
	 * @var String
	 */
	protected $query_type;

	/**
	 * Array of row fields that should be fetched with 'SELECT' query.
	 * @var Array
	 */
	protected $fields;

	/**
	 * Array of values that should be inserted or updated
	 * with 'INSERT' or 'UPDATE' query.
	 * @var Array
	 */
	protected $values;

	/**
	 * SQL condition string that will be put right after 'WHERE' statement.
	 * @var String
	 */
	protected $conditions;

	/**
	 * Order by SQL statement.
	 * @var String
	 */
	protected $order_by;

	/**
	 * Order direction - ascending or descending.
	 * @var String
	 */
	protected $order_dir = self::ASC;


	/** ----------------------------------------------------------------------------
	 * Select from the table
	 * @param String $table - sqlite table name
	 */

	public function selectFrom(string $table) : object {
		$this->table = $table;
		$this->query_type = self::SELECT;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * Insert into the table
	 * @param String $table - sqlite table name
	 */

	public function insertInto(string $table) : object {
		$this->table = $table;
		$this->query_type = self::INSERT;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * Update data in the table
	 * @param String $table - sqlite table name
	 */

	public function update(string $table) : object {
		$this->table = $table;
		$this->query_type = self::UPDATE;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * Delete rows from the table
	 * @param String $table - sqlite table name
	 */

	public function deleteFrom(string $table) : object {
		$this->table = $table;
		$this->query_type = self::DELETE;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * Count rows of the table
	 * @param String $table - sqlite table name
	 */

	public function countIn(string $table) : object {
		$this->table = $table;
		$this->query_type = self::SELECT;
		$this->fields = ['COUNT(*) as count'];
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * @param Array $values
	 */

	public function values(array $values) : object {
		$this->values = $values;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 *
	 */

	public function fields($fields = '*') : object {
		$this->fields = $fields;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 *
	 */

	public function where(string $conditions) : object {
		$this->conditions = $conditions;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 *
	 */

	public function orderBy(string $order, string $dir = self::ASC) : object {
		$this->order_by  = $order;
		$this->order_dir = $dir;
		return $this;
	}


	/** ----------------------------------------------------------------------------
	 * Hub method for creating queries
	 */

	public function build() : string {
		switch ($this->query_type) {
			case self::SELECT:
				$query = $this->buildSelect();
				break;

			case self::INSERT:
				$query = $this->buildInsert();
				break;

			case self::UPDATE:
				$query = $this->buildUpdate();
				break;

			case self::DELETE:
				$query = $this->buildDelete();
				break;

			default:
				throw new Exception("Unknown query type '{$this->query_type}'");
		}

		return $query;
	}


	/** ----------------------------------------------------------------------------
	 * Select data from database
	 */

	private function buildSelect() : string {
		$fields = '';

		if (is_array($this->fields)) {
			$fields_num = count($this->fields) - 1;
			foreach($this->fields as $i => $field) {
				$fields .= "{$field}";
				if ($i < $fields_num) $fields .= ", ";
			}
		}
		elseif ($this->fields) {
			$fields = $this->fields;
		}
		else {
			$fields = '*';
		}

		$query = "SELECT {$fields} FROM `{$this->table}`";

		if (!empty($this->conditions)) {
			$query .= " WHERE {$this->conditions}";
		}

		if (!empty($this->order_by)) {
			$query .= " ORDER BY `{$this->order_by}` {$this->order_dir}";
		}

		return $query;
	}


	/** ----------------------------------------------------------------------------
	 * Insert data into database table
	 */

	private function buildInsert() : string {
		$columns = "'" . implode("', '", array_keys($this->values)) . "'";
		$values  = "'" . implode("', '", array_values($this->values)) . "'";

		return "INSERT INTO {$this->table}({$columns}) VALUES({$values});";
	}


	/** ----------------------------------------------------------------------------
	 * Update data in database table
	 */

	public function buildUpdate() : string {
		if (count($this->values) < 1) {
			throw new Exceptions("There is no data set to insert. Please use method 'values' to add data.");
		}
		if (empty($this->conditions)) {
			throw new Exception("Conditions are required to perform UPDATE operation. Use method 'where()' to add conditions.");
		}

		$changes = [];
		foreach($this->values as $col => $val) {
			$changes[] = "`{$col}` = '{$val}'";
		}
		$changes = implode(', ', $changes);

		return "UPDATE {$this->table} SET {$changes} WHERE {$this->conditions}";
	}


	/** ----------------------------------------------------------------------------
	 * Delete rows from database table
	 */

	private function buildDelete() : string {
		if (empty($this->conditions)) {
			throw new Exception("Conditions are required to perform DELETE operation. Use method 'where()' to add conditions.");
		}

		return "DELETE FROM {$this->table} WHERE {$this->conditions}";
	}
}