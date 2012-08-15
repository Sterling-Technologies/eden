<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Facebook Search
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Search extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ASC	= 'ASC';
	const DESC	= 'DESC';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_database 	= NULL;
	protected $_table		= NULL;
	protected $_columns		= array();
	protected $_filter		= array();
	protected $_sort		= array();
	protected $_start		= 0;
	protected $_range		= 0;
	
	protected $_group		= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct(Eden_Yahoo_Fql $database) {
		$this->_database 	= $database;
	}
	
	public function __call($name, $args) {
		if(strpos($name, 'filterBy') === 0) {
			//filterByUserName('Chris', '-')
			$separator = '_';
			if(isset($args[1]) && is_scalar($args[1])) {
				$separator = (string) $args[1];
			}
			
			$key = Eden_Type_String::i($name)
				->substr(8)
				->preg_replace("/([A-Z])/", $separator."$1")
				->substr(strlen($separator))
				->strtolower()
				->get();
			
			if(!isset($args[0])) {
				$args[0] = NULL;
			}
			
			$key = $key.'=%s';
				
			$this->addFilter($key, $args[0]);
			
			return $this;
		}
		
		if(strpos($name, 'sortBy') === 0) {
			//filterByUserName('Chris', '-')
			$separator = '_';
			if(isset($args[1]) && is_scalar($args[1])) {
				$separator = (string) $args[1];
			}
			
			$key = Eden_Type_String::i($name)
				->substr(6)
				->preg_replace("/([A-Z])/", $separator."$1")
				->substr(strlen($separator))
				->strtolower()
				->get();
			
			if(!isset($args[0])) {
				$args[0] = self::ASC;
			}
				
			$this->addSort($key, $args[0]);
			
			return $this;
		}
		
		try {
			return parent::__call($name, $args);
		} catch(Eden_Error $e) {
			Eden_Yahoo_Error::i($e->getMessage())->trigger();
		}
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets Columns
	 * 
	 * @param string[,string..]|array
	 * @return this
	 */
	public function setColumns($columns) {
		if(!is_array($columns)) {
			$columns = func_get_args();
		}
		
		$this->_columns = $columns;
		
		return $this;
	}
	
	/**
	 * Sets Table
	 * 
	 * @param string
	 * @return this
	 */
	public function setTable($table) {
		Eden_Yahoo_Error::i()->argument(1, 'string');
		$this->_table = $table;
		return $this;
	}
	
	/**
	 * Adds filter
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addFilter() {
		Eden_Yahoo_Error::i()->argument(1, 'string');
		
		$this->_filter[] = func_get_args();
		
		return $this;
	}
	
	/**
	 * Adds sort
	 * 
	 * @param string
	 * @param string
	 * @return this
	 */
	public function addSort($column, $order = self::ASC) {
		Eden_Yahoo_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		if($order != self::DESC) {
			$order = self::ASC;
		}
		
		$this->_sort[$column] = $order;
		
		return $this;
	}
	
	/**
	 * Sets the pagination start
	 *
	 * @param int
	 * @return this
	 */
	public function setStart($start) {
		Eden_Yahoo_Error::i()->argument(1, 'int');
		
		if($start < 0) {
			$start = 0;
		}
		
		$this->_start = $start;
		
		return $this;
	}
	
	/**
	 * Sets the pagination range
	 *
	 * @param int
	 * @return this
	 */
	public function setRange($range) {
		Eden_Yahoo_Error::i()->argument(1, 'int');
		
		if($range < 0) {
			$range = 25;
		}
		
		$this->_range = $range;
		
		return $this;
	}
	
	/**
	 * Sets the pagination page
	 *
	 * @param int
	 * @return this
	 */
	public function setPage($page) {
		Eden_Yahoo_Error::i()->argument(1, 'int');
		
		if($page < 1) {
			$page = 1;
		}
		
		$this->_start = ($page - 1) * $this->_range;
		
		return $this;
	}
	
	/**
	 * Stores this search and resets class.
	 * Useful for multiple queries.
	 *
	 * @param scalar
	 * @return this
	 */
	public function group($key) {
		Eden_Yahoo_Error::i()->argument(1, 'scalar');
		if(is_null($this->_table)) {
			return $this;
		}
		
		$this->_group[$key] = array(
			'table' 	=> $this->_table,
			'columns' 	=> $this->_columns,
			'filter' 	=> $this->_filter,
			'sort' 		=> $this->_sort,
			'start' 	=> $this->_start,
			'range' 	=> $this->_range);
		
		$this->_table	= NULL;
		$this->_columns	= array();
		$this->_filter	= array();
		$this->_sort	= array();
		$this->_start	= 0;
		$this->_range	= 0;
		
		return $this;
	}
	
	/**
	 * Returns the results in a collection
	 *
	 * @return Eden_Facebook_Collection
	 */
	public function getCollection($key = 'last') {
		$rows = $this->getRows($key);
		
		if(count($this->_group) == 1) {
			return Eden_Collection::i($rows);
		}
		
		foreach($rows as $key => $collection) {
			$rows[$key] = Eden_Collection::i($collection['fql_result_set']);
		}
		
		return $rows;
	}
	
	/**
	 * Returns the array rows
	 *
	 * @return array
	 */
	public function getRows($key = 'last') {
		$this->group($key);
		
		if(empty($this->_group)) {
			return array();
		}
		
		$group = array();
		foreach($this->_group as $key => $query) {
			$this->_table	= $query['table'];
			$this->_columns	= $query['columns'];
			$this->_filter	= $query['filter'];
			$this->_sort	= $query['sort'];
			$this->_start	= $query['start'];
			$this->_range	= $query['range'];
			
			$query = $this->_getQuery();
		
			if(!empty($this->_columns)) {
				$query->select(implode(', ', $this->_columns));
			}
			
			foreach($this->_sort as $name => $value) {
				$query->sortBy($name, $value);
			}
			
			if($this->_range) {
				$query->limit($this->_start, $this->_range);
			}
			
			$group[$key] = $query;
		}
		
		$query = $group;
		
		if(count($query) == 1) {
			$query = $group[$key];
		}
		
		$results = $this->_database->query($query);
		return $results;
	}
	
	/**
	 * Returns the total results
	 *
	 * @return int
	 */
	public function getTotal() {
		$query 	= $this->_getQuery()->select('COUNT(*) as total');
		
		$rows = $this->_database->query($query);
		
		if(!isset($rows[0]['total'])) {
			return 0;
		}
		
		return $rows[0]['total'];
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getQuery() {
		$query = $this->_database->select()->from($this->_table);
		
		foreach($this->_filter as $i => $filter) {
			//array('post_id=%s AND post_title IN %s', 123, array('asd'));
			$where = array_shift($filter);
			if(!empty($filter)) {
				$where = vsprintf($where, $filter);
			}
			
			$query->where($where);
		}
		
		return $query;
	}
	
	/* Private Methods
	-------------------------------*/
}