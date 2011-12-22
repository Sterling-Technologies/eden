<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
abstract class Eden_Mysql_Model_Abstract extends Eden_Class implements ArrayAccess, Iterator {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = NULL;
	protected $_meta 	= array();
	protected $_data	= array();
	
	protected $_database 	= NULL;
	protected $_table 		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __call($name, $args) {
		//if the method starts with get
		if(strpos($name, 'get') === 0) {
			$key = preg_replace("/([A-Z])/", "_$1", $name);
			//get rid of get_
			$key = strtolower(substr($key, 4));
			
			if(isset($this->_meta[$key])) {
				return $this->_data[$key];
			}
		} else if (strpos($name, 'set') === 0) {
			$key = preg_replace("/([A-Z])/", "_$1", $name);
			//get rid of get_
			$key = strtolower(substr($key, 4));
			
			return $this->__set($key, $args[0]);
		}
		
		try {
			return parent::__call($name, $args);
		} catch(Eden_Type_Error $e) {
			throw new Eden_Mysql_Error($e->getMessage());
		}
	}
	
	public function __get($name) {
		if(isset($this->_data[$name])) {
			return $this->_data[$name];
		}
		
		return NULL;
	}
	
	public function __set($name, $value) {
		if(isset($this->_meta[$name])) {	
			$this->_data[$name] = $value;
			return $this;
		}
		
		//throw an error
		Eden_Mysql_Error::get()
			->setMessage(Eden_Mysql_Error::SET_INVALID)
			->addVariable($name)
			->addVariable($this->_table)
			->trigger();
	}
	
	public function __toString() {
		return json_encode($this->_data);
	}
	
	/* Public Methods
	-------------------------------*/
	abstract public function save();
	
	/**
	 * Returns meta data
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getMetaData($name = NULL, $key = NULL) {
		//argument test
		Eden_Mysql_Error::get()
			->argument(1, 'string', 'null')	//argument 1 must be a string or null
			->argument(2, 'string', 'null');	//argument 2 must be a string or null
		
		if(!is_null($name) && isset($this->_meta[$name])) {		
			if(!is_null($key) && isset($this->_meta[$name][$key])) {
				return $this->_meta[$name][$key];
			}
			return $this->_meta[$name];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Sets data using the ArrayAccess interface
	 * We overloaded this to not allow creating new
	 * columns.
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
        //if this is not set in the meta data
		if(!isset($this->_meta[$offset])) {
			//throw an error
			Eden_Mysql_Error::get()
				->setMessage(Eden_Mysql_Error::SET_INVALID)
				->addVariable($offset)
				->addVariable($this->_table)
				->trigger();
		}
        
		$this->_data[$offset] = $value;
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 * We overloaded this because an attributes 
	 * must never be removed. Instead we set it to 
	 * null. 
	 *
	 * @param number
	 * @return void
	 */
	public function offsetUnset($offset) {
		//if it is set in the meta
		if(isset($this->_meta[$offset])) {
			//set it to null
			$this->_data[$offset] = NULL;
		}
    }
	
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
        reset($this->_data);
    }

	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
        return current($this->_data);
    }

	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
        return key($this->_data);
    }

	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
        next($this->_data);
    }

	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
        return isset($this->_data[$this->key()]);
    }
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return isset($this->_data[$offset]);
    }
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return isset($this->_data[$offset]) ? $this->_data[$offset] : NULL;
    }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

