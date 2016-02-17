<?php
require('QueryResult.php');
class QueryBuilder
{
	protected $table;
	protected $action;
	protected $where;
	protected $select = '*';
	protected $limit;
	protected $wpdb;

	public function __construct($table, $method)
	{
		$this->action = $method;
		$this->table = $table;
		global $wpdb;
		$this->wpdb = &$wpdb;
	}

	/**
	 * Initiates a find query
	 *
	 * @return $this
	 */
	public function find()
	{
		$this->action = 'FIND';
		return $this;
	}

	/**
	 * Adds a where clause to the query.
	 * Params as array with key->value pairs
	 *
	 * @param $params
	 * @return $this
	 */
	public function where($params)
	{
		$this->where = $params;
		return $this;
	}

	/**
	 * If not given, query will select all columns in the table.
	 * String or array of strings
	 *
	 * @param $params
	 * @return $this
	 */
	public function select($params)
	{
		$select = '';
		if(is_array($params))
			foreach ( $params as $param) {
				$select .= $param.', ';
			}
		else $select = $params;
		$this->select = $select;
		return $this;
	}

	/**
	 * Adds a limit to the query
	 *
	 * @param $lim
	 * @return $this
	 */
	public function limit($lim)
	{
		$this->limit = $lim;
		return $this;
	}


	private function execute()
	{
		$query = $this->action.' '.$this->select.' FROM ' . $this->table . ' ';
		if($this->where != null) {
			$query .= 'WHERE ';
			foreach($this->where as $field => $value)
			{
				$query .= $field.'='.$value.' AND ';
			}
			$query = substr($query, 0, -4);
		}
		if($this->limit != 0) $query .= 'LIMIT '.$this->limit;
		return $this->wpdb->get_results($query);
	}
	public function all()
	{
		$results = $this->execute();
		$query_results = [];
		foreach($results as $result)
		{
			$query_results[] = new QueryResult($result);
		}
		return $query_results;
	}

	public function one()
	{
		$this->limit = '1';
		return new QueryResult($this->execute()[0]);
	}
}