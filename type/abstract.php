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
abstract class Eden_Type_Abstract extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_methods = array();
	
	protected $_data = NULL;
	protected $_original = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($data) {
		$this->_original = $this->_data = $data;
	}
	
	public function __call($name, $args) {
		$method = $this->_getPreMethod($name);
		
		//if this is a pre method
		if($method) {
			//add the string as first arg
			array_unshift($args, $this->_data);
		} else {
			$method = $this->_getPostMethod($name);
			
			//if this is a post method
			if($method) {
				//add string at the end of the arguments
				array_push($args, $this->_data);
			} else {
				$method = $this->_getReferenceMethod($name);
				//if this is a reference method	
				if($method) {
					//call the method
					$name($this->_data);
					return $this;
				}
			}
		}
		
		//if this is a method
		if($method) {
			//call the method
			$result = call_user_func_array($method, $args);
			
			//if the result is a string
			if(is_string($result)) {
				//if this class is a string type
				if($this instanceof Eden_String) {
					//set value
					$this->_data = $result;
					return $this;	
				}
				
				//return string class
				return Eden_String::get($result);
			} 
			
			//if the result is an array
			if(is_array($result)) {
				//if this class is a array type
				if($this instanceof Eden_Array) {
					//set value
					$this->_data = $result;
					return $this;
				}
				
				//return array class
				return Eden_Array::get($result);
			}
			
			return $result;
		}
		
		//we don't process anything else
		try {
			//call the parent
			return parent::__call($name, $args);
		} catch(Eden_Error_Class $e) {
			throw new Eden_Type_Error($e->getMessage());
		}
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the string
	 *
	 * @param bool whether to get the modified or original version
	 * @return string
	 */
	public function getValue($modified = true) {
		if($modified instanceof Eden_Type_Boolean) {
			$modified = $modified->getValue();
		} else {
			//argument 1 must be a bool
			Eden_Error_Validate::get()->argument(0, 'bool');
		}
		
		return $modified ? $this->_data : $this->_original;
	}
	
	/* Protected Methods
	-------------------------------*/
	abstract protected function _getPreMethod($name);
	
	abstract protected function _getPostMethod($name);
	
	abstract protected function _getReferenceMethod($name);
	
	/* Private Methods
	-------------------------------*/
}