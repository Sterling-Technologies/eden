<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates utility query strings
 *
 * @package    Eden
 * @subpackage database
 * @category   database
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: utility.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Postgre_Utility extends Eden_Sql_Query
{
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	public function setSchema($schema)  {
		$this->_query = 'SET search_path TO '.$schema;
		return $this;
	}
	
	/**
	 * Query for truncating a table
	 *
	 * @param string the name of the table
	 * @return this
	 */
	public function truncate($table) {
		//Argument 1 must be a string
		Eden_Postgre_Error::i()->argument(1, 'string');
		
		$this->_query = 'TRUNCATE "' . $table .'"';
		return $this;
	}
	
	/**
	 * Query for dropping a table
	 *
	 * @param string the name of the table
	 * @return this
	 */
	public function dropTable($table) {
		//Argument 1 must be a string
		Eden_Postgre_Error::i()->argument(1, 'string');
		
		$this->_query = 'DROP TABLE "' . $table .'"';
		return $this;
	}
	
	/**
	 * Query for renaming a table
	 *
	 * @param string the name of the table
	 * @param string the new name of the table
	 * @return this
	 */
	public function renameTable($table, $name) {
		//Argument 1 must be a string, 2 must be string
		Eden_Postgre_Error::i()->argument(1, 'string')->argument(2, 'string');
		
		$this->_query = 'RENAME TABLE "' . $table . '" TO "' . $name . '"';
		return $this;
	}
	
	/**
	 * Returns the string version of the query 
	 *
	 * @return string
	 */
	public function getQuery() {
		return $this->_query.';';
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}