<?php

/**
 * Created by PhpStorm.
 * User: e
 * Date: 16-Feb-16
 * Time: 18:55
 */
require('QueryBuilder.php');

class BaseModel
{
	protected $wpdb;
	private $fieldArray;
	public $primaryKey;

	protected function __construct() {
		global $wpdb;
		$this->wpdb = &$wpdb;
		$this->getFields();
	}

	/**
	 * Returns database table name
	 *
	 * @return string
	 */
	protected function getTable()
	{
		return $this->wpdb->prefix.static::tableName();
	}

	/**
	 * Placeholder in case the function is removed from child model
	 *
	 * @return null
	 */
	protected static function fields()
	{
		return null;
	}

	/**
	 * Returns all fields in the table
	 *
	 * @return array|null
	 */
	protected function getFields()
	{
		if($this->fieldArray == null)
		{
			$results = $this->wpdb->get_results('SHOW columns FROM '.$this->getTable());
			foreach($results as $field)
			{
				if(strtolower($field->Key) == 'pri') $this->primaryKey = $field->Field;
				$this->fieldArray[] = $field->Field;
			}
		}
		return $this->fieldArray;
	}

	/**
	 * Initiates a find query
	 *
	 * @return $this
	 */
	public static function find()
	{
		$instance = self::createInstance();
		return new QueryBuilder($instance->getTable(), 'SELECT');
	}

	/**
	 * Initiates a find by PK query
	 *
	 * @param $pk
	 * @param $select
	 * @return QueryBuilder
	 */
	public static function findByPk($pk, $select = null)
	{
		$instance = self::createInstance();
		if($instance->primaryKey == null) return 'nopk';
		$query = new QueryBuilder($instance->getTable(), 'SELECT');
		if($select != null) $query->select($select);
		$query->where([$instance->primaryKey => $pk]);
		return $query->one();
	}
	private function createInstance()
	{
		$class = get_called_class();
		return new $class;
	}
}