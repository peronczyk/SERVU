<?php

declare(strict_types=1);

use Sqlite\QueryBuilder as Query;

class ContentActions {

	const DB_TABLE_NAME = 'content';

	// Dependencies
	private $_db;


	/** ----------------------------------------------------------------------------
	 * Constructor
	 */

	public function __construct(DependencyContainer $container) {
		$this->_db = $container->get('db');
	}


	/** ----------------------------------------------------------------------------
	 * Get one content details
	 */

	public function getContentDataById($id) {
		$result = $this->_db->fetchOne(
			(new Query)
				->selectFrom(self::DB_TABLE_NAME)
				->where("`id` = {$id}")
		);

		return $result ?? null;
	}


	/** ----------------------------------------------------------------------------
	 * Get number of children
	 *
	 * @return Int
	 */

	public function getNumberOfChildren($parent_id) : int {

		$result = $this->_db->fetchOne(
			(new Query)
				->countIn(self::DB_TABLE_NAME)
				->where("`parent-id` = {$parent_id}")
		);

		return (int) $result['count'] ?? 0;
	}


	/** ----------------------------------------------------------------------------
	 * Get children of defined parent
	 *
	 * @param Integer $parent_id - default parent is root (0)
	 */

	public function getChildren($parent_id = 0) : array {
		$parent_id = Sanitise::integerId($parent_id, 'parent-id', false);

		$result = $this->_db->fetchAll(
			(new Query)
				->selectFrom(self::DB_TABLE_NAME)
				->where("`parent-id` = {$parent_id}")
				->orderBy('order')
		);

		// Add number of children
		foreach ($result as $key => $val) {
			$result[$key]['children'] = $this->getNumberOfChildren($val['id']);
		}

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Add new content
	 *
	 * @todo fields-values
	 */

	public function addContent($name, $parent_id, $collection_id) : bool {
		Assumpt::text($name, 'name', true);

		$parent_id     = Sanitise::integerId($parent_id, 'parent-id');
		$collection_id = Sanitise::integerId($collection_id, 'collection-id', true);

		$result = $this->_db->fetchOne(
			(new Query)
				->insertInto(self::DB_TABLE_NAME)
				->values([
					'name'          => $name,
					'parent-id'     => $parent_id,
					'collection-id' => $collection_id,
					'fields-values' => '@TODO',
				])
		);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Modify content data
	 *
	 * @param String $content_id - integer stored as string
	 */

	public function updateContentDataById($content_id, $name, $collection_id) : bool {
		Assumpt::stringInt($content_id, 'content_id');
		Assumpt::stringInt($collection_id, 'collection_id');
		Assumpt::text($name, 'name');

		$result = $this->_db->fetchOne(
			(new Query)
				->update(self::DB_TABLE_NAME)
				->values([
					'name'          => $name,
					'collection-id' => $collection_id,
					'fields-values' => '@TODO-modified',
				])
				->where("`id` = '{$content_id}'")
		);

		return $result;
	}


	/** ----------------------------------------------------------------------------
	 * Delete content
	 *
	 * @return Bool
	 */

	public function delete($id) : bool {
		Assumpt::stringInt($id, 'id');

		$result = $this->_db->fetchOne(
			(new Query)
				->deleteFrom(self::DB_TABLE_NAME)
				->where("`id` = '{$id}'")
		);

		return $result;
	}
}