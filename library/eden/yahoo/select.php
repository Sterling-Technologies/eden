<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates select query string syntax
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Yahoo_Select extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_select 	= NULL;
	protected $_from 	= NULL;
	protected $_where 	= array();
	protected $_sortBy	= array();
	protected $_page 	= NULL;
	protected $_length	= NULL;
	
	protected static $_columns = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct() {
		self::$_columns = include(dirname(__FILE__).'/columns.php');
	}
	
	public function __toString() {
		return $this->getQuery();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Select clause
	 *
	 * @param string select
	 * @return this
	 * @notes loads select phrase into registry
	 */
	public function select($select = '*') {
		//Argument 1 must be a string or array
		Eden_Yahoo_Error::i()->argument(1, 'string', 'array');
		
		//if select is an array
		if(is_array($select)) {
			//transform into a string
			$select = implode(', ', $select);
		}
		
		$this->_select = $select;
		return $this;
	}
	
	/**
	 * From clause
	 *
	 * @param string from
	 * @return this
	 * @notes loads from phrase into registry
	 */
	public function from($from) {
		//Argument 1 must be a string
		Eden_Yahoo_Error::i()->argument(1, 'string');
		
		$this->_from = $from;
		return $this;
	}
	
	/**
	 * Where clause
	 *
	 * @param array|string where
	 * @return	this
	 * @notes loads a where phrase into registry
	 */
	public function where($where) {
		//Argument 1 must be a string or array
		Eden_Yahoo_Error::i()->argument(1, 'string', 'array');
		
		if(is_string($where)) {
			$where = array($where);
		}
		
		$this->_where = array_merge($this->_where, $where); 
		
		return $this;
	}
	
	/**
	 * Order by clause
	 *
	 * @param string field
	 * @param string order
	 * @return this
	 * @notes loads field and order into registry
	 */
	public function sortBy($field, $order = 'ASC') {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string'); 	//Argument 2 must be a string
		
		$this->_sortBy[] = $field . ' ' . $order;
		
		return $this;
	}
	
	/**
	 * Limit clause
	 *
	 * @param string|int page
	 * @param string|int length
	 * @return this
	 * @notes loads page and length into registry
	 */
	public function limit($page, $length) {
		//argument test
		Eden_Yahoo_Error::i()
			->argument(1, 'numeric')	//Argument 1 must be a number
			->argument(2, 'numeric');	//Argument 2 must be a number
		
		$this->_page = $page;
		$this->_length = $length; 

		return $this;
	}
	
	/**
	 * Returns the string version of the query 
	 *
	 * @param  bool
	 * @return string
	 * @notes returns the query based on the registry
	 */
	public function getQuery() {
		$where = empty($this->_where) ? '' : 'WHERE '.implode(' AND ', $this->_where);
		$sort = empty($this->_sortBy) ? '' : 'ORDER BY '.implode(', ', $this->_sortBy);
		$limit = is_null($this->_page) ? '' : 'LIMIT ' . $this->_page .',' .$this->_length;
		//if(empty($this->_select) || $this->_select == '*') {
			//$this->_select = implode(', ', $this->_select);
		//}
		
		$query = sprintf(
			'SELECT %s FROM %s %s %s %s;',
			$this->_select, $this->_from, 
			$where, $sort, $limit);
		
		return str_replace('  ', ' ', $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}