<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Base class for data type classes
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
abstract class Eden_Type_Abstract extends Eden_Class {
	/* Constants
	-------------------------------*/
	const PRE		= 'pre';
	const POST 		= 'post';
	const REFERENCE = 'reference';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_data 		= NULL;
	protected $_original 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/	
	public function __call($name, $args) {
		$type = $this->_getMethodType($name);
		
		//if no type
		if(!$type) {
			//we don't process anything else
			try {
				//call the parent
				return parent::__call($name, $args);
			} catch(Eden_Error $e) {
				Eden_Type_Error::i($e->getMessage())->trigger();
			}
		}
		
		//case different types
		switch($type) {
			case self::PRE:
				//if pre, we add it first into the args
				array_unshift($args, $this->_data);
				break;
			case self::POST:
				//if post, we add it last into the args
				array_push($args, $this->_data);
				break;
			case self::REFERENCE:
				//if reference, we add it first 
				//into the args and call it
				call_user_func_array($name, array_merge(array(&$this->_data), $args));
				return $this;
		}
		
		//call the method
		$result = call_user_func_array($name, $args);
		
		//if the result is a string
		if(is_string($result)) {
			//if this class is a string type
			if($this instanceof Eden_Type_String) {
				//set value
				$this->_data = $result;
				return $this;	
			}
			
			//return string class
			return Eden_Type_String::i($result);
		} 
		
		//if the result is an array
		if(is_array($result)) {
			//if this class is a array type
			if($this instanceof Eden_Type_Array) {
				//set value
				$this->_data = $result;
				return $this;
			}
			
			//return array class
			return Eden_Type_Array::i($result);
		}
		
		return $result;
	}
	
	public function __construct($data) {
		$this->_original = $this->_data = $data;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the value
	 *
	 * @param bool whether to get the modified or original version
	 * @return string
	 */
	public function get($modified = true) {
		//argument 1 must be a bool
		Eden_Type_Error::i()->argument(1, 'bool');
		
		return $modified ? $this->_data : $this->_original;
	}
	
	/**
	 * Reverts changes back to the original
	 *
	 * @return this
	 */
	public function revert() {
		$this->_data = $this->_original;
		return $this;
	}
	
	/**
	 * Sets data
	 *
	 * @return this
	 */
	public function set($value) {
		$this->_data = $value;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	abstract protected function _getMethodType(&$name);
	
	/* Private Methods
	-------------------------------*/
}