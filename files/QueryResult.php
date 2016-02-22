<?php

/**
 * Created by PhpStorm.
 * User: e
 * Date: 17-Feb-16
 * Time: 14:09
 */
class QueryResult
{
	public function __construct($attributes)
	{
		foreach($attributes as $name => $value)
		{
			$this->$name = $value;
		}
	}
}