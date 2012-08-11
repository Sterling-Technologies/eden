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
class Eden_Postgre_Create extends Eden_Sql_Query {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_name		= NULL;
	protected $_fields 		= array();
	protected $_primaryKeys = array();
	protected $_oids		= false;
	
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
		Eden_Mysql_Error::i()->argument(1, 'string');
		
		$this->_fields[$name] = $attributes;
		return $this;
	}
	
	/**
	 * Adds a primary key
	 *
	 * @param string name
	 * @return this
	 */
	public function addPrimaryKey($name) {
		//Argument 1 must be a string
		Eden_Mysql_Error::i()->argument(1, 'string');
		
		$this->_primaryKeys[] = $name;
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
				if(isset($attr['list']) && $attr['list']) {
					$field[count($field)-1].='[]';
				}
			}
			
			if(isset($attr['attribute'])) {
				$field[] = $attr['attribute'];
			}
			
			if(isset($attr['unique']) && $attr['unique']) {
				$field[] = 'UNIQUE';
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
		
		$oids = $this->_oids ? 'WITH OIDS':NULL;
		$fields = !empty($fields) ? implode(', ', $fields) : '';
		$primary = !empty($this->_primaryKeys) ? ', PRIMARY KEY ("'.implode('", ""', $this->_primaryKeys).'")' : '';
		return sprintf('CREATE TABLE %s (%s%s) %s', $table, $fields, $primary, $oids);
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
	 * Sets the name of the table you wish to create
	 *
	 * @param string name
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string
		Eden_Mysql_Error::i()->argument(1, 'string');
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * Sets a list of primary keys to the table
	 *
	 * @param array primaryKeys
	 * @return this
	 */
	public function setPrimaryKeys(array $primaryKeys) {
		$this->_primaryKeys = $primaryKeys;
		return $this;
	}
	
	public function withOids($oids) {
		//Argument 1 must be a boolean
		Eden_Mysql_Error::i()->argument(1, 'bool');
		
		$this->_oids = $oids;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}