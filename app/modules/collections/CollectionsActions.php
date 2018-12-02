<?php

declare(strict_types=1);

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

	public function getCollectionList() {
		$collection_list = $this->_db
			->select()
			->from(self::DB_TABLE_NAME)
			->all();

		// Decode field's JSON string in all collections
		foreach($collection_list as $key => $val) {
			$collection_list[$key]['fields'] = json_decode($val['fields']);
		}

		return $collection_list;
	}


	/** ----------------------------------------------------------------------------
	 * Get one collection details
	 */

	public function getCollectionDataById(int $collection_id) {
		$result = $this->_db
			->select()
			->from(self::DB_TABLE_NAME)
			->where("`id` = '{$collection_id}'")
			->one();

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

	public function addCollection(string $name, array $fields) {
		$result = $this->_db
			->insert([
				'name'   => $name,
				'fields' => json_encode($fields),
			])
			->into(self::DB_TABLE_NAME);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Modify collection data
	 */

	public function updateCollectionDataById(int $collection_id, array $fields) {
		$result = $this->_db
			->update(self::DB_TABLE_NAME)
			->values([
				'name'   => $name,
				'fields' => json_encode($fields),
			])
			->where("`id` = '{$collection_id}'")
			->one();

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Delete collection by ID
	 */

	public function deleteCollectionById(int $collection_id) {
		$result = $this->_db
			->delete()
			->from(self::DB_TABLE_NAME)
			->where("`id` = '{$collection_id}'")
			->one();

		return $result;
	}
}