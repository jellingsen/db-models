<?php

/**
 * Created by PhpStorm.
 * User: e
 * Date: 16-Feb-16
 * Time: 18:59
 */
require('/../files' . DIRECTORY_SEPARATOR. 'BaseModel.php');

class Users extends BaseModel
{
	public function __construct()
	{
		parent::__construct();
	}

	/*
	 * Database Table name (Prefix is added automatically!)
	 */
	static function tableName()
	{
		return 'users';
	}

	/**
	 * List all the fields in the table to improve performance.
	 * BaseModel will ask the database for them if not provided.
	 * return ['attribute1', 'attribute2', ..., 'attributeN']
	 *
	 * @return array
	 */
	static function fields()
	{
		return [
			'ID', 'user_login', 'user_pass', 'user_nickname',
			'user_email', 'user_url', 'user_registered',
			'user_activation_key', 'user_status', 'display_name'
		];
	}

	public function spit()
	{
		return $this->getFields();
	}
}