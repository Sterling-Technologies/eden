<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates subselect query string syntax
 *
 * @package    Eden
 * @subpackage database
 * @category   database
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: subselect.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Mysql_Subselect extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_parentQuery;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i(Eden_Sql_Select $parentQuery, $select = '*') {
		return self::_getMultiple(__CLASS__, $parentQuery, $select);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct(Eden_Sql_Select $parentQuery, $select = '*') {
		//Argument 2 must be a string
		Eden_Mysql_Error::i()->argument(2, 'string');
		
		$this->setParentQuery($parentQuery);
		$this->_select = is_array($select) ? implode(', ', $select) : $select;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets the parent Query
	 *
	 * @param object usually the parent query object
	 * @return this
	 */
	public function setParentQuery(Eden_Sql_Select $parentQuery) {
		$this->_parentQuery = $parentQuery;
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
		
		return '('.substr(parent::getQuery(), 0, -1).')';
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}