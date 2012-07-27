<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Generates create table query string syntax
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Sqlite_Create extends Eden_Sql_Query {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_name		= NULL;
	protected $_comments 	= NULL;
	protected $_fields 		= array();
	protected $_keys 		= array();
	protected $_uniqueKeys 	= array();
	protected $_primaryKeys = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($name = NULL) {
		if(is_string($name)) {
			$this->setName($name);
		}
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Adds a field in the table
	 *
	 * @param string name
	 * @param array attributes
	 * @return this
	 */
	public function addField($name, array $attributes) {
		//Argument 1 must be a string
		Eden_Sqlite_Error::i()->argument(1, 'string');
		
		$this->_fields[$name] = $attributes;
		return $this;
	}
	
	/**
	 * Adds an index key
	 *
	 * @param string name
	 * @param array fields
	 * @return this
	 */
	public function addForeignKey($name, $table, $key) {
		//argument test
		Eden_Sqlite_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		$this->_keys[$name] = array($table, $key);
		return $this;
	}
	
	/**
	 * Adds a unique key
	 *
	 * @param string name
	 * @param array fields
	 * @return this
	 */
	public function addUniqueKey($name, array $fields) {
		//Argument 1 must be a string
		Eden_Sqlite_Error::i()->argument(1, 'string');
		
		$this->_uniqueKeys[$name] = $fields;
		return $this;
	}
	
	/**
	 * Returns the string version of the query 
	 *
	 * @param  bool
	 * @return string
	 * @notes returns the query based on the registry
	 */
	public function getQuery($unbind = false) {	
		$table = '"'.$this->_name.'"';
		
		$fields = array();
		foreach($this->_fields as $name => $attr) {
			$field = array('"'.$name.'"');
			if(isset($attr['type'])) {	
				$field[] = isset($attr['length']) ? $attr['type'] . '('.$attr['length'].')' : $attr['type'];
			}
			
			if(isset($attr['primary'])) {
				$field[] = 'PRIMARY KEY';
			}
			
			if(isset($attr['attribute'])) {
				$field[] = $attr['attribute'];
			}
			
			if(isset($attr['null'])) {
				if($attr['null'] == false) {
					$field[] = 'NOT NULL';
				} else {
					$field[] = 'DEFAULT NULL';
				}
			}
			
			if(isset($attr['default'])&& $attr['default'] !== false) {
				if(!isset($attr['null']) || $attr['null'] == false) {
					if(is_string($attr['default'])) {
						$field[] = 'DEFAULT \''.$attr['default'] . '\'';
					} else if(is_numeric($attr['default'])) {
						$field[] = 'DEFAULT '.$attr['default'];
					}
				}
			}
			
			$fields[] = implode(' ', $field);
		}
		
		$fields = !empty($fields) ? implode(', ', $fields) : '';
		
		$uniques = array();
		foreach($this->_uniqueKeys as $key => $value) {
			$uniques[] = 'UNIQUE "'. $key .'" ("'.implode('", "', $value).'")';
		}
		
		$uniques = !empty($uniques) ? ', ' . implode(", \n", $uniques) : '';
		
		$keys = array();
		foreach($this->_keys as $key => $value) {
			$keys[] = 'FOREIGN KEY "'. $key .'" REFERENCES '.$value[0].'('.$value[1].')';
		}
		
		$keys = !empty($keys) ? ', ' . implode(", \n", $keys) : '';
		
		return sprintf(
			'CREATE TABLE %s (%s%s%s)',
			$table, $fields, $unique, $keys);
	}
	
	/**
	 * Sets comments
	 *
	 * @param string comments
	 * @return this
	 */
	public function setComments($comments) {
		//Argument 1 must be a string
		Eden_Sqlite_Error::i()->argument(1, 'string');
		
		$this->_comments = $comments;
		return $this;
	}
	
	/**
	 * Sets a list of fields to the table
	 *
	 * @param array fields
	 * @return this
	 */
	public function setFields(array $fields) {
		$this->_fields = $fields;
		return $this;
	}
	
	/**
	 * Sets a list of keys to the table
	 *
	 * @param array keys
	 * @return this
	 */
	public function setForiegnKeys(array $keys) {
		$this->_keys = $keys;
		return $this;
	}
	
	/**
	 * Sets the name of the table you wish to create
	 *
	 * @param string name
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string
		Eden_Sqlite_Error::i()->argument(1, 'string');
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * Sets a list of unique keys to the table
	 *
	 * @param array uniqueKeys
	 * @return this
	 */
	public function setUniqueKeys(array $uniqueKeys) {
		$this->_uniqueKeys = $uniqueKeys;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}