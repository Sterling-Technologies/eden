<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/type/error.php';
require_once dirname(__FILE__).'/type/abstract.php';
require_once dirname(__FILE__).'/type/array.php';
require_once dirname(__FILE__).'/type/string.php';

/**
 * Controller for Data Types
 *
 * @package    Eden
 * @category   type
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Type extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($type = NULL) {
		if(func_num_args() > 1) {
			$type = func_get_args();
		}
		
		if(is_array($type)) {
			return Eden_Type_Array::i($type);
		} 
		
		if(is_string($type)) {
			return Eden_Type_String::i($type);
		}
		
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the array class
	 *
	 * @param array|mixed[,mixed..]
	 * @return Eden_Type_Array
	 */
	public function getArray($array) {
		$args = func_get_args();
		if(count($args) > 1 || !is_array($array)) {
			$array = $args;
		} 
		
		return Eden_Type_Array::i($array);
	}
	
	/**
	 * Returns the string class
	 *
	 * @param string
	 * @return Eden_Type_String
	 */
	public function getString($string) {
		return Eden_Type_String::i($string);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}