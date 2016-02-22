<?php

/**
 * Example Model
 * Copy this base code for all your tables, and update tableName()
 */
require('/../files' . DIRECTORY_SEPARATOR. 'BaseModel.php');

class Options extends BaseModel
{
	public function __construct()
	{
		parent::__construct();

		// Optional performance enhancing function $this->setFields(primary_key, [attributes])
		$this->setFields('options_id', ['option_name','option_value','autoload']);
	}

	/**
	 * Database Table name (Prefix is added automatically!)
	 */
	static function tableName()
	{
		return 'options';
	}



}