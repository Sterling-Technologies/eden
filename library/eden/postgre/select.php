<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates select query string syntax
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: select.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Postgre_Select extends Eden_Sql_Select {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the string version of the query 
	 *
	 * @param  bool
	 * @return string
	 * @notes returns the query based on the registry
	 */
	public function getQuery() {
		$joins = empty($this->_joins) ? '' : implode(' ', $this->_joins);
		$where = empty($this->_where) ? '' : 'WHERE '.implode(' AND ', $this->_where);
		$sort = empty($this->_sortBy) ? '' : 'ORDER BY '.implode(', ', $this->_sortBy);
		$limit = is_null($this->_page) ? '' : 'LIMIT ' . $this->_page .' OFFSET ' .$this->_length;
		$group = empty($this->_group) ? '' : 'GROUP BY ' . implode(', ', $this->_group);
		
		$query = sprintf(
			'SELECT %s FROM %s %s %s %s %s %s;',
			$this->_select, $this->_from, $joins,
			$where, $group, $sort, $limit);
		
		return str_replace('  ', ' ', $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}