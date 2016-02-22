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
	protected $cache;
	protected $cacheTime = 12 * HOUR_IN_SECONDS;
	protected $order;

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


	public function orderBy($string)
	{
		$this->order = $string;
		return $this;
	}

	public function cache($identifier)
	{
		$this->cache = $identifier;
		return $this;
	}


	private function execute()
	{
		if(isset($this->cache))
		{
			if ( false === ( $value = get_transient( $this->cache ) ) ) {
				if(defined('DB_MODELS_DEBUG')) $start = microtime(true);
				$results = $this->wpdb->get_results($this->getQuery());
				set_transient($this->cache, $results, $this->cacheTime );
				if(defined('DB_MODELS_DEBUG')) $this->add_debug($this->getQuery(), microtime(true) - $start, false);
				return $results;
			}
			else {
				if(defined('DB_MODELS_DEBUG')) $this->add_debug($this->getQuery(), 0, true);
				return get_transient($this->cache);
			}
		}
		else {
			if(defined('DB_MODELS_DEBUG')) $start = microtime(true);
			$result = $this->wpdb->get_results($this->getQuery());
			if(defined('DB_MODELS_DEBUG')) $this->add_debug($this->getQuery(), microtime(true) - $start, false);
			return $result;
		}
	}

	private function getQuery()
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
		if(isset($this->order)) $query .= ' ORDER BY '.$this->order;
		if($this->limit != 0) $query .= ' LIMIT '.$this->limit;

		return $query;
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

	private function add_debug($query, $time, $cached)
	{
		$GLOBALS['DB_MODELS_DEBUG'][] = [$query, $time, $cached];
	}
}