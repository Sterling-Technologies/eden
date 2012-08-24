<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/route/error.php';
require_once dirname(__FILE__).'/route/class.php';
require_once dirname(__FILE__).'/route/method.php';
require_once dirname(__FILE__).'/route/function.php';

/**
 * Definition for overloading methods and overriding classes.
 * This class also provides methods to list out various routes
 * and has the ability to call methods, static methods and 
 * functions passing arguments as an array.
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Route extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_instance = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
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
	public function getClass($class = NULL, array $args = array()) {
		$route = Eden_Route_Class::i();
		
		if(is_null($class)) {
			return $route;
		}
		
		return $route->callArray($class, $args);
	}
	
	public function getFunction($function = NULL, array $args = array()) {
		$route = Eden_Route_Function::i();
		
		if(is_null($function)) {
			return $route;
		}
		
		return $route->callArray($function, $args);
	}
	
	public function getMethod($class = NULL, $method = NULL, array $args = array()) {
		$route = Eden_Route_Method::i();
		
		if(is_null($class) || is_null($method)) {
			return $route;
		}
		
		return $route->call($class, $method, $args);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}