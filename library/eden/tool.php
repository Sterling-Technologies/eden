<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Every other random method that can't be grouped as a class
 *
 * @package    Eden
 * @subpackage tool
 * @category   tool
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: tool.php 3 2010-01-06 01:16:54Z blanquera $
 */
class Eden_Tool extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_uid = 0;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a unique token that can be used for anything
	 *
	 * @return int
	 */
	public function uid() {
		$this->_uid++;
		return $this->_uid;
	}
	
	/**
	 * Returns the data type given the variable
	 *
	 * @param *mixed data
	 * @param string data type to compare to
	 * @return string|bool
	 */
	public function type( $obj, $value = false) {
		$value = is_string($value) ? array($value) : $value;
		
		switch(true) {
			case is_array($obj):
				$obj = 'array';
				break;
			case is_object($obj):
				$obj = 'object';
				break;
			case is_bool($obj):
				$obj = 'bool';
				break;
			case is_numeric($obj):
				$obj = 'number';
				break;
			case is_string($obj):
				$obj = 'string';
				break;
			case is_null($obj):
				$obj = 'null';
				break;
			default:
				$obj = 'unknown';
				break;
		}
		return $value ? in_array($obj, $value) : $obj;
	}
	
	/**
	 * Outputs anything
	 *
	 * @param *variable any data
	 * @return Eden_Tool
	 */
	public function output($variable) {
		if($variable === true) {
			$variable = '*TRUE*';
		} else if($variable === false) {
			$variable = '*FALSE*';
		} else if(is_null($variable)) {
			$variable = '*NULL*';
		}
		
		echo '<pre>'.print_r($variable, true).'</pre>';
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}