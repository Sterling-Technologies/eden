<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2010-2012 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Method and class logic validations
 *
 * @package    Eden
 * @category   error
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: exception.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Error_Validate {
	/* Constants
	-------------------------------*/
	//exception messages
	const INVALID_ARGUMENT = 'Argument %d in %s() was expecting %s, however a %s type was given.';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_instance = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		$class = __CLASS__;
		if(is_null(self::$_instance)) {
			self::$_instance = new $class();
		}
		
		return self::$_instance;
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function argument($index, $types) {
		$trace = debug_backtrace();
		$argument = $trace[1]['args'][$index];
		
		$args = func_get_args();
		array_shift($args);
		
		$argumentType = $this->_getType($argument);
		
		$types = array();
		$valid = false;
		foreach($args as $i => $type) {
			if(!is_string($type)) {
				break;
			}
			
			$types[] = $type;
			if(strtolower($type) == strtolower($argumentType)) {
				$valid = true;
			}
		}
		
		if(!$valid) {
			if(!isset($types[$i]) || !($types[$i] instanceof Eden_Error_Model)) {
				$e = Eden_Error_Model::get();
			} else {
				$e = $types[$i];
			}
			
			//lets formulate the method
			$method = $trace[1]['function'];
			if(isset($trace[1]['class'])) {
				$method = $trace[1]['class'].'->'.$method;
			}
			
			$types = implode(' or ', $types);
			
			$e->setMessage(self::INVALID_ARGUMENT)
				->addVariable($index + 1)
				->addVariable($method)
				->addVariable($types)
				->addVariable($argumentType)
				->setTypeLogic()
				->setTraceOffset(2)
				->render();
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getType($argument) {
		switch(true) {
			case is_array($argument):
				return 'array';
			case is_object($argument):
				return 'object';
			case is_bool($argument):
				return 'bool';
			case is_numeric($argument):
				return 'number';
			case is_string($argument):
				return 'string';
			case is_null($argument):
				return 'null';
			default:
				return 'unknown';
		}
	}
	
	/* Private Methods
	-------------------------------*/
}