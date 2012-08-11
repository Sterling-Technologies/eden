<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates subselect query string syntax
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
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
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct(Eden_Sql_Select $parentQuery, $select = '*') {
		//Argument 2 must be a string
		Eden_Mysql_Error::i()->argument(2, 'string');
		
		$this->setParentQuery($parentQuery);
		$this->_select = is_array($select) ? implode(', ', $select) : $select;
	}
	
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
		
		return '('.substr(parent::getQuery(), 0, -1).')';
	}
	
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}