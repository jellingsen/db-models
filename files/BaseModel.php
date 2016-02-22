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
	public $fieldArray;
	public $primaryKey;

	protected function __construct() {
		global $wpdb;
		$this->wpdb = &$wpdb;
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
			$start = microtime(true);
			$results = $this->wpdb->get_results('SHOW columns FROM '.$this->getTable());
			$GLOBALS['DB_MODELS_DEBUG'][] = ['SHOW columns FROM '.$this->getTable(), microtime(true) - $start, false];
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
		$instance->getFields();
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
		$instance->getFields();
		if($instance->primaryKey == null) return null;
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

	protected function setFields($priKey, $fields)
	{
		$this->primaryKey = $priKey;
		array_unshift($fields, $priKey);
		$this->fieldArray = $fields;
	}
}