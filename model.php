<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Model extends Eden_Class implements ArrayAccess {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_data = array();
	protected $_meta = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
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
			
			if(isset($this->_data[$key])) {
				return $this->_data[$key];
			}
		} else if (strpos($name, 'set') === 0) {
			$key = preg_replace("/([A-Z])/", "_$1", $name);
			//get rid of get_
			$key = strtolower(substr($key, 4));
			
			return $this->__set($key, $args[0]);
		}
		
		return parent::__call($name, $args);
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
		}
		
		return $this;
	}
	
	/* Public Methods
	-------------------------------*/
	public function setMetaData($name, array $meta = array()) {
		$this->_meta[$name] = $meta;
		
		if(!isset($this->_data[$name])) {
			$this->_data[$name] = NULL;
		}
		
		return $this;
	}
	
	
	public function getMetaData($name = NULL, $key = NULL) {
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
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_data[] = $value;
        } else {
            $this->_data[$offset] = $value;
        }
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
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
        unset($this->_data[$offset]);
    }
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return isset($this->_data[$offset]) ? $this->_data[$offset] : null;
    }
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}