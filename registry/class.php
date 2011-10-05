<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Allows the ability to create multiple registries for different 
 * purposes. This is a better registry in memory design. What makes 
 * this registry truly unique is that it uses a pathing design 
 * similar to a file/folder structure to organize data which also 
 * in turn allows you to get a data set based on similar
 * pathing. 
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: model.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Registry_Class extends Eden_Array {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_data = array(); //data registry
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get(array $data = array()) {
		return self::_getMultiple(__CLASS__, $data);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Gets a value given the path in the registry.
	 * 
	 * @return variable
	 */
	public function getData() {
		//get the arguments
		$args = func_get_args();
		//what object are we looking into?
		//if the first argument is not an object
		//use global registry
		$data = $this->_data;
		if(isset($args[0]) && (is_array($args[0]) || is_object($args[0]))) {
			$data = array_shift($args);
		}
		
		//set the remaining length
		$length = count($args);
		
		if($length > 0) {
			$result = NULL;
			
			//foreach argument
			foreach($args as $key => $value) {
				if(!is_string($value) && !is_numeric($value)) {
					return $value;
				}
				
				//this is the last item
				if(($key+1) == $length) {
					//assign it to result
					//exit loop
					try {
						$result = NULL;
						if(is_array($data) && isset($data[$value])) {
							$result = $data[$value];
						} else if(is_object($data) && isset($data->{$value})) {
							$result = $data->{$value};
						}
					} catch(Exception $e) {
						$result = NULL;
					}
					break;
				}
				
				//the name does not exist
				if(is_array($data) && !isset($data[$value])) {
					//assign result to null
					//exit loop
					$result = NULL;
					break;
				} else if(is_object($data) && !isset($data->{$value})) {
					//assign result to null
					//exit loop
					$result = NULL;
					break;
				}
				
				//walk the object
				$data = is_array($data) ? $data[$value] : $data->{$value};
			}
			return $result;
		}
		
		//if no arguments
		//return the whole object
		return $data;
	}
	
	/**
	 * Creates the name space given the space
	 * and sets the value to that name space
	 *
	 * @return Eden_RegistryModel
	 **/
	public function setData() {
		//get the arguments
		$args = func_get_args();
		//what object are we looking into?
		//if the first argument is not an object
		//use Eve's registry
		$data = &$this->_data;
		if(is_array($args[0]) || is_object($args[0])) {
			$data = &array_shift($args);
		}
		
		//set the remaining length
		$length = count($args);
		
		if($length > 0) {		
			$last 	= NULL;
			$index 	= NULL;
			
			//foreach argument
			foreach($args as $key => $value) {
				
				//this is the last item
				if(($key+1) == $length) {
					//set it to the value
					//exit loop
					if(is_array($last)) {
						$last[$index] = $value;
					} else if(is_object($last)) {
						$last->{$index} = $value;
					}
					 
					break;
				}
				
				if(!is_string($value) && !is_numeric($value)) {
					//set it to the value
					//exit loop
					if(is_array($last)) {
						$last[$index] = $value;
					} else if(is_object($last)) {
						$last->{$index} = $value;
					}
				}
				
				//the name does not exist
				if(is_array($data) && !isset($data[$value])) {
					//create the namespace
					$data[$value] = array();
				} else if(is_object($data) && !isset($data->{$value})) {
					//create the namespace
					$data->{$value} = new stdClass();
				}
				
				//walk the object
				$last = &$data;
				$index = $value;
				if(is_array($data)) {
					$data = &$data[$value];
				} else {
					$data = &$data->{$value};
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * Unset a name space
	 * 
	 * @return Eden_RegistryModel
	 **/
	public function unsetData() {
		//get the arguments
		$args = func_get_args();
		
		//what object are we looking into?
		//if the first argument is not an object
		//use Eve's registry
		$data = &$this->_data;
		if(is_array($args[0]) || is_object($args[0])) {
			$data = &array_shift($args);
		}
		
		//set the remaining length
		$length = count($args);
		
		if($length > 0) {
			//foreach argument
			foreach($args as $key => $value) {
				if(!is_string($value) && !is_numeric($value)) {
					//delete it
					//exit loop
					if(is_array($data))
					{
						unset($data[$value]);
					} else if(is_object($data)) {
						unset($data->{$value});
					}
					
					return $this;
				}
				
				//this is the last item
				if(($key+1) == $length) {
					//delete it
					//exit loop
					if(is_array($data))
					{
						unset($data[$value]);
					} else if(is_object($data)) {
						unset($data->{$value});
					}
					
					return $this;
				}
				
				//walk the object
				if(is_array($data)) {
					$data = &$data[$value];
				} else {
					$data = &$data->{$value};
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * Checks to see if a name is taken
	 *
	 * @return bool
	 **/
	public function issetData() {
		//get the arguments
		$args = func_get_args();
		//what object are we looking into?
		//if the first argument is not an object
		//use Eve's registry
		$data = $this->_data;
		if(is_array($args[0]) || is_object($args[0])) {
			$data = array_shift($args);
		}
		
		//set the remaining length
		$length = count($args);
		
		if($length > 0) {
			//foreach argument
			foreach($args as $key => $value) {
				if(!is_string($value) && !is_numeric($value)) {
					return false;
				}
				
				//walk the object
				if(is_array($data))
				{
					if(isset($data[$value])) {
						$data = $data[$value];
					} else {
						return false;
					}
				} else {
					if(isset($data->{$value})) {
						$data = $data->{$value};
					} else {
						return false;
					}
				}
			}
			
			return true;
		}
		
		//if no arguments 
		//then return false
		return false;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}