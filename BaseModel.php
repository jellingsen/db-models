<?php

/**
 * Created by PhpStorm.
 * User: e
 * Date: 16-Feb-16
 * Time: 18:55
 */
class BaseModel
{
	protected $wpdb;
	private $fieldArray;

	protected function __construct() {
		global $wpdb;
		$this->wpdb = &$wpdb;
	}

	/**
	 * Returns the fields in the database table
	 *
	 * @return array
	 */
	protected function getFieldsFromDB()
	{
		if($this->fieldArray == null)
		{
			$results = $this->wpdb->get_results('SHOW columns FROM '.$this->wpdb->prefix.static::tableName());
			foreach($results as $field)
			{
				$this->fieldArray[] = $field->Field;
			}
		}
		return $this->fieldArray;
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
		if($this->fields() !== null)
			return $this->fields();
		else return $this->getFieldsFromDB();
	}

}