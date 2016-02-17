<?php

/**
 * Created by PhpStorm.
 * User: e
 * Date: 17-Feb-16
 * Time: 14:09
 */
class QueryResult
{
	public $asd = 'asd';
	public function __construct($attributes)
	{
		foreach($attributes as $name => $value)
		{
			$this->bind($name, $value);
		}
	}
	
	/**
	 * Creates a class variable
	 *
	 * @param $name
	 * @param $value
	 */
	private function bind($name, $value) {
		$this->$name = $value;
	}
}