<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Abstractly defines a layout of available methods to
 * connect to and query a database. This class also lays out 
 * query building methods that auto renders a valid query
 * the specific database will understand without actually 
 * needing to know the query language.
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: abstract.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Sql_Database extends Eden_Event {
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
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the delete query builder
	 *
	 * @return Eden_Sql_Delete
	 */ 
	public function delete($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Sql_Delete::i($table);
	}
	
	/**
	 * Returns the insert query builder
	 *
	 * @return Eden_Sql_Insert
	 */ 
	public function insert($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Sql_Insert::i($table);
	}
	
	/**
	 * Returns the select query builder
	 *
	 * @return Eden_Sql_Select
	 */ 
	public function select($select = '*') {
		//Argument 1 must be a string or array
		Eden_Sql_Error::i()->argument(1, 'string', 'array');
		
		return Eden_Sql_Select::i($select);
	}
	
	/**
	 * Returns the update query builder
	 *
	 * @return Eden_Sql_Update
	 */ 
	public function update($table = NULL) {
		//Argument 1 must be a string or null
		Eden_Sql_Error::i()->argument(1, 'string', 'null');
		
		return Eden_Sql_Update::i($table);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}