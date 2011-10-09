<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/array.php';
require_once dirname(__FILE__).'/model/error.php';

/**
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Model extends Eden_Array {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get(array $data = array()) {
		return self::_getMultiple(__CLASS__);
	}
	
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
			throw new Eden_Model_Error($e->getMessage());
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
		Eden_Model_Error::get()
			->setMessage(Eden_Model_Error::SET_INVALID)
			->addVariable($name)->trigger();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Loads data into the model
	 *
	 * @param array
	 * @return this
	 */
	public function load(array $data) {
		//for each data
		foreach($data as $name => $value) {
			//if this is not set in the meta data
			if(!isset($this->_meta[$name])) {
				//throw an error
				Eden_Model_Error::get()
					->setMessage(Eden_Model_Error::SET_INVALID)
					->addVariable($name)->trigger();
			}
			
			$this->_data[$name] = $value;
		}
		
		return $this;
	}
	
	/**
	 * Sets meta data about the given property
	 *
	 * @param string
	 * @param array
	 * @return this
	 */
	public function setMetaData($name, $meta = array(), $value = NULL) {
		//argument test
		Eden_Model_Error::get()
			->argument(1, 'string')				//argument 1 must be a string
			->argument(2, 'string', 'array')		//argument 2 must be a string or array
			->argument(3, 'string', 'null');	//argument 3 must be a string or null
		
		if(is_array($meta)) {
			$this->_meta[$name] = $meta;
			return $this;
		}
		
		$this->_meta[$name][$meta] = $value;
		
		return $this;
	}
	
	/**
	 * Returns meta data
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getMetaData($name = NULL, $key = NULL) {
		//argument test
		Eden_Model_Error::get()
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
			Eden_Model_Error::get()
				->setMessage(Eden_Model_Error::SET_INVALID)
				->addVariable($offset)->trigger();
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

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}