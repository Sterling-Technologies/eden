<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Sql Search
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Sql_Search extends Eden_Class {
	/* Constants
	-------------------------------*/
	const LEFT 	= 'LEFT';
	const RIGHT = 'RIGHT';
	const INNER = 'INNER';
	const OUTER = 'OUTER';
	const ASC	= 'ASC';
	const DESC	= 'DESC';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_database 	= NULL;
	protected $_table		= NULL;
	protected $_columns		= array();
	protected $_join 		= array();
	protected $_filter		= array();
	protected $_sort		= array();
	protected $_group		= array();
	protected $_start		= 0;
	protected $_range		= 0;
	
	protected $_model	 	= Eden_Sql_Database::MODEL;
	protected $_collection 	= Eden_Sql_Database::COLLECTION;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
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
				->preg_replace("/([A-Z0-9])/", $separator."$1")
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
				->preg_replace("/([A-Z0-9])/", $separator."$1")
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
			Eden_Sql_Error::i($e->getMessage())->trigger();
		}
	}
	
	public function __construct(Eden_Sql_Database $database) {
		$this->_database 	= $database;
	}
	
	/* Public Methods
	-------------------------------*/
	
	/**
	 * Adds filter
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addFilter() {
		Eden_Sql_Error::i()->argument(1, 'string');
		
		$this->_filter[] = func_get_args();
		
		return $this;
	}
	
	/**
	 * Adds Inner Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addInnerJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::INNER, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Inner Join Using
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addInnerJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::INNER, $table, $where, true);
		
		return $this;
	}
	
	/**
	 * Adds Left Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addLeftJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::LEFT, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Left Join Using
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addLeftJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::LEFT, $table, $where, true);
		
		return $this;
	}
	
	/**
	 * Adds Outer Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addOuterJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::OUTER, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Outer Join USing
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addOuterJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::OUTER, $table, $where, true);
		
		return $this;
	}
	
	/**
	 * Adds Right Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addRightJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::RIGHT, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Right Join Using
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function addRightJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::RIGHT, $table, $where, true);
		
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
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		if($order != self::DESC) {
			$order = self::ASC;
		}
		
		$this->_sort[$column] = $order;
		
		return $this;
	}
	
	/**
	 * Returns the results in a collection
	 *
	 * @return Eden_Sql_Collection
	 */
	public function getCollection() {
		$collection = $this->_collection;
		return $this->$collection()
			->setDatabase($this->_database)
			->setTable($this->_table)
			->setModel($this->_model)
			->set($this->getRows());
	}
	
	/**
	 * Returns the one result in a model
	 *
	 * @param int
	 * @return Eden_Sql_Model
	 */
	public function getModel($index = 0) {
		Eden_Sql_Error::i()->argument(1, 'int');
		return $this->getCollection()->offsetGet($index);
	}
	
	/**
	 * Returns the one result
	 *
	 * @param int|string
	 * @param string|null
	 * @return array|null
	 */
	public function getRow($index = 0, $column = NULL) {
		Eden_Sql_Error::i()
			->argument(1, 'int', 'string')
			->argument(2, 'string', 'null');
		
		if(is_string($index)) {
			$column = $index;
			$index = 0;
		}
		
		$rows = $this->getRows();
		
		if(!is_null($column) && isset($rows[$index][$column])) {
			return $rows[$index][$column];
		} else if(is_null($column) && isset($rows[$index])) {
			return $rows[$index];
		}
		
		return NULL;
	}
	
	/**
	 * Returns the array rows
	 *
	 * @return array
	 */
	public function getRows() {
		$query = $this->_getQuery();
		
		if(!empty($this->_columns)) {
			$query->select(implode(', ', $this->_columns));
		}
		
		foreach($this->_sort as $key => $value) {
			$query->sortBy($key, $value);
		}
		
		if($this->_range) {
			$query->limit($this->_start, $this->_range);
		}
		
		if(!empty($this->_group)) {
			$query->groupBy($this->_group);
		}
		
		return $this->_database->query($query, $this->_database->getBinds());
	}
	
	/**
	 * Returns the total results
	 *
	 * @return int
	 */
	public function getTotal() {
		$query 		= $this->_getQuery()->select('COUNT(*) as total');
		
		$rows = $this->_database->query($query, $this->_database->getBinds());
		
		if(!isset($rows[0]['total'])) {
			return 0;
		}
		
		return $rows[0]['total'];
	}
	
	/**
	 * Adds Inner Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function innerJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::INNER, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Inner Join Using
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function innerJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::INNER, $table, $where, true);
		
		return $this;
	}
	
	/**
	 * Adds Left Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function leftJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::LEFT, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Left Join Using
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function leftJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::LEFT, $table, $where, true);
		
		return $this;
	}
	
	/**
	 * Adds Outer Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function outerJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::OUTER, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Outer Join USing
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function outerJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::OUTER, $table, $where, true);
		
		return $this;
	}
	
	/**
	 * Adds Right Join On
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function rightJoinOn($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::RIGHT, $table, $where, false);
		
		return $this;
	}
	
	/**
	 * Adds Right Join Using
	 * 
	 * @param string
	 * @param string[,string..]
	 * @return this
	 */
	public function rightJoinUsing($table, $where) {
		Eden_Sql_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$where = func_get_args();
		$table = array_shift($where);
		
		$this->_join[] = array(self::RIGHT, $table, $where, true);
		
		return $this;
	}
	
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
	 * Sets default collection
	 *
	 * @param string
	 * @return this
	 */
	public function setCollection($collection) {
		$error = Eden_Sql_Error::i()->argument(1, 'string');
		
		if(!is_subclass_of($collection, 'Eden_Collection')) {
			$error->setMessage(Eden_Sql_Error::NOT_SUB_COLLECTION)
				->addVariable($collection)
				->trigger();
		}
		
		$this->_collection = $collection;
		return $this;
	}
	
	/**
	 * Group by clause
	 *
	 * @param string group
	 * @return this
	 * @notes adds broup by functionality
	 */
	public function setGroup($group) {
		 //Argument 1 must be a string or array
		 Eden_Sql_Error::i()->argument(1, 'string', 'array');	
			
		if(is_string($group)) {
			$group = array($group); 
		}
		
		$this->_group = $group; 
		return $this;
	}
	
	/**
	 * Sets default model
	 *
	 * @param string
	 * @return this
	 */
	public function setModel($model) {
		$error = Eden_Sql_Error::i()->argument(1, 'string');
		
		if(!is_subclass_of($model, 'Eden_Model')) {
			$error->setMessage(Eden_Sql_Error::NOT_SUB_MODEL)
				->addVariable($model)
				->trigger();
		}
		
		$this->_model = $model;
		return $this;
	}
	
	/**
	 * Sets the pagination page
	 *
	 * @param int
	 * @return this
	 */
	public function setPage($page) {
		Eden_Sql_Error::i()->argument(1, 'int');
		
		if($page < 1) {
			$page = 1;
		}
		
		$this->_start = ($page - 1) * $this->_range;
		
		return $this;
	}
	
	/**
	 * Sets the pagination range
	 *
	 * @param int
	 * @return this
	 */
	public function setRange($range) {
		Eden_Sql_Error::i()->argument(1, 'int');
		
		if($range < 0) {
			$range = 25;
		}
		
		$this->_range = $range;
		
		return $this;
	}
	
	/**
	 * Sets the pagination start
	 *
	 * @param int
	 * @return this
	 */
	public function setStart($start) {
		Eden_Sql_Error::i()->argument(1, 'int');
		
		if($start < 0) {
			$start = 0;
		}
		
		$this->_start = $start;
		
		return $this;
	}
	
	/**
	 * Sets Table
	 * 
	 * @param string
	 * @return this
	 */
	public function setTable($table) {
		Eden_Sql_Error::i()->argument(1, 'string');
		$this->_table = $table;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getQuery() {
		$query = $this->_database->select()->from($this->_table);
		
		foreach($this->_join as $join) {
			if(!is_array($join[2])) {
				$join[2] = array($join[2]);
			}
			
			$where = array_shift($join[2]);
			if(!empty($join[2])) {
				foreach($join[2] as $i => $value) {
					$join[2][$i] = $this->_database->bind($value);
				}
				
				$where = vsprintf($where, $join[2]);
			}
			
			$query->join($join[0], $join[1], $where, $join[3]);
		}
		
		
		foreach($this->_filter as $i => $filter) {
			//array('post_id=%s AND post_title IN %s', 123, array('asd'));
			$where = array_shift($filter);
			if(!empty($filter)) {
				foreach($filter as $i => $value) {
					$filter[$i] = $this->_database->bind($value);
				}
				
				$where = vsprintf($where, $filter);
			}
			
			$query->where($where);
		}
		
		return $query;
	}
	
	/* Private Methods
	-------------------------------*/
}