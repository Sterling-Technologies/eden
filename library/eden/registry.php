<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/type.php';

/**
 * This class allows the reference of a global registry. This
 * is a better registry in memory design. What makes this
 * registry truly unique is that it uses a pathing design 
 * similar to a file/folder structure to organize data which also 
 * in turn allows you to get a data set based on similar
 * pathing. 
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Registry extends Eden_Type_Array {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($data = array()) {
		//if there is more arguments or data is not an array
		if(func_num_args() > 1 || !is_array($data)) {
			//just get the args
			$data = func_get_args();
		}
		
		foreach($data as $key => $value) {
			if(!is_array($value)) {
				continue;
			}
			
			$class = get_class($this);
			
			$data[$key] = $this->$class($value);
		}
		
		parent::__construct($data);
	}
	
	public function __toString() {
		return json_encode($this->getArray());
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Gets a value given the path in the registry.
	 * 
	 * @return mixed
	 */
	public function get($modified = true) {
		$args = func_get_args();
		
		if(count($args) == 0) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if($key === false) {
			if(count($args) == 0) {
				return $this->getArray();
			}
			
			$modified = $key;
			$key = array_shift($args);
			array_unshift($args, $modified);
		}
		
		if(!isset($this->_data[$key])) {
			return NULL;
		}
		
		if(count($args) == 0) {
			return $this->_data[$key];
		}
		
		if($this->_data[$key] instanceof Eden_Registry) {
			return call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
		}
		
		return NULL;
	}
	
	/**
	 * Returns the raw array recursively
	 *
	 * @return array
	 */
	public function getArray($modified = true) {
		$array = array();
		foreach($this->_data as $key => $data) {
			if($data instanceof Eden_Registry) {
				$array[$key] = $data->getArray($modified);
				continue;
			}
			
			$array[$key] = $data;
		}
		
		return $array;
	}
	
	/**
	 * Checks to see if a key is set
	 *
	 * @return bool
	 */
	public function isKey() {
		$args = func_get_args();
		
		if(count($args) == 0) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if(!isset($this->_data[$key])) {
			return false;
		}
		
		if(count($args) == 0) {
			return true;
		}
		
		if($this->_data[$key] instanceof Eden_Registry) {
			return call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
		}
		
		return false;
	}
	
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        if(!isset($this->_data[$offset])) {
			return NULL;
		}
		
		if($this->_data[$offset] instanceof Eden_Registry) {
			return $this->_data[$offset]->getArray();
		}
		
		return $this->_data[$offset];
    }
	
	/**
	 * Removes a key and everything associated with it
	 * 
	 * @return Eden_Registry
	 */
	public function remove() {
		$args = func_get_args();
		
		if(count($args) == 0) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if(!isset($this->_data[$key])) {
			return $this;
		}
		
		if(count($args) == 0) {
			unset($this->_data[$key]);
			return $this;
		}
		
		if($this->_data[$key] instanceof Eden_Registry) {
			return call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
		}
		
		return $this;
	}
	
	/**
	 * Creates the name space given the space
	 * and sets the value to that name space
	 *
	 * @return Eden_Registry
	 */
	public function set($value) {
		$args = func_get_args();
		
		if(count($args) < 2) {
			return $this;
		}
		
		$key = array_shift($args);
		
		if(count($args) == 1) {
			if(is_array($args[0])) {
				$args[0] = self::i($args[0]);
			}
			
			$this->_data[$key] = $args[0];
			
			return $this;
		}
		
		if(!isset($this->_data[$key]) || !($this->_data[$key] instanceof Eden_Registry)) {
			$this->_data[$key] = self::i();
		}
		
		call_user_func_array(array($this->_data[$key], __FUNCTION__), $args);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}