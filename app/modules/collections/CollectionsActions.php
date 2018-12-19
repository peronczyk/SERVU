<?php

declare(strict_types=1);

use Sqlite\QueryBuilder as Query;

class CollectionsActions {

	const DB_TABLE_NAME = 'collections';

	// Dependencies
	private $_db;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_db = $container->get('db');
	}


	/** ----------------------------------------------------------------------------
	 * Get collection list
	 */

	public function getCollectionList() : array {
		$result = $this->_db->fetchAll(
			(new Query)
				->selectFrom(self::DB_TABLE_NAME)
		);

		// Decode field's JSON string in all collections
		foreach($result as $key => $val) {
			$result[$key]['id'] = intval($result[$key]['id']);
			$result[$key]['fields'] = json_decode($val['fields']);
		}

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Get one collection details
	 */

	public function getCollectionDataById($collection_id) : array {
		Assumpt::stringInt($collection_id, 'id');

		$collection_id = intval($collection_id);

		$result = $this->_db->fetchOne(
			(new Query)
				->selectFrom(self::DB_TABLE_NAME)
				->where("`id` = '{$collection_id}'")
		);

		if ($result) {
			$result['fields'] = json_decode($result['fields']);
			unset($result['id']);
		}
		else {
			$result = null;
		}

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Add new collection
	 */

	public function addCollection(string $name, array $fields) : bool {
		Assumpt::text($name, 'name');
		Assumpt::array($fields, 'fields');

		$result = $this->_db->fetchOne(
			(new Query)
				->insertInto(self::DB_TABLE_NAME)
				->values([
					'name'   => $name,
					'fields' => json_encode($fields),
				])
		);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Modify collection data
	 *
	 * @param String $collection_id - integer stored as string
	 */

	public function updateCollectionDataById($collection_id, $name, $fields) : bool {
		Assumpt::stringInt($collection_id, 'id');
		Assumpt::text($name, 'name');
		Assumpt::array($fields, 'fields');

		$result = $this->_db->fetchOne(
			(new Query)
				->update(self::DB_TABLE_NAME)
				->values([
					'name'   => $name,
					//'fields' => json_encode($fields),
				])
				->where("`id` = '{$collection_id}'")
		);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection by ID
	 */

	public function deleteCollectionById($collection_id) : bool {
		Assumpt::stringInt($collection_id, 'id');

		$result = $this->_db->fetchOne(
			(new Query)
				->deleteFrom(self::DB_TABLE_NAME)
				->where("`id` = '{$collection_id}'")
		);

		return $result;
	}
}