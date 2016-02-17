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

	public function spit()
	{
		return $this->getFields();
	}

}