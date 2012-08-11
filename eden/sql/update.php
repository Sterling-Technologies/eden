<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates update query string syntax
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Sql_Update extends Eden_Sql_Delete {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_set = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
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
		
		$set = array();
		foreach($this->_set as $key => $value) {
			$set[] = "{$key} = {$value}";
		}
		
		return 'UPDATE '. $this->_table . ' SET ' . implode(', ', $set) . ' WHERE '. implode(' AND ', $this->_where).';';
	}
	
	/**
	 * Set clause that assigns a given field name to a given value.
	 *
	 * @param string
	 * @param string
	 * @return this
	 * @notes loads a set into registry
	 */
	public function set($key, $value) {
		//argument test
		Eden_Sql_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'scalar', 'null');	//Argument 2 must be scalar or null
		
		if(is_null($value)) {
			$value = 'NULL';
		} else if(is_bool($value)) {
			$value = $value ? 1 : 0;
		}
		
		$this->_set[$key] = $value;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}