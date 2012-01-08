<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
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
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: javascript.php 1 2010-01-02 23:06:36Z blanquera $
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
	public static function get($type = NULL) {
		if(func_num_args() > 1) {
			$type = func_get_args();
		}
		
		if(is_array($type)) {
			return Eden_Type_Array::get($type);
		} 
		
		if(is_string($type)) {
			return Eden_Type_String::get($type);
		}
		
		if(is_object($type)) {
			return Eden_Type_Object::get($type);
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
		
		return Eden_Type_Array::get($array);
	}
	
	/**
	 * Returns the string class
	 *
	 * @param string
	 * @return Eden_Type_String
	 */
	public function getString($string) {
		return Eden_Type_String::get($string);
	}
	
	/**
	 * Returns the object class
	 *
	 * @param object
	 * @return Eden_Type_Object
	 */
	public function getObject($object) {
		return Eden_Type_Object::get($object);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}