<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Definition for overriding classes.
 * This class also provides methods to list out various routes
 *
 * @package    Eden
 * @category   route
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: route.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Route_Class extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_instance = NULL;
	protected $_route = array();	//class registry
	
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
	/**
	 * Routes a class 
	 *
	 * @param *string the class route name
	 * @param *string the name of the class to route to
	 * @return Eden_Route
	 */
	public function route($route, $class) {
		Eden_Route_Error::i()
			->argument(1, 'string', 'object')	//argument 1 must be a string or object
			->argument(2, 'string', 'object');	//argument 2 must be a string or object
		
		if(is_object($route)) {
			$route = get_class($route);
		}
		
		if(is_string($class)) {
			$class = $this->getRoute($class);	
		}
		
		$this->_route[$route] = $class;
		return $this;
	}
	
	/**
	 * Returns the class that will be routed to given the route.
	 *
	 * @param *string the class route name
	 * @param string|null returns this variable if no route is found
	 * @return string|variable
	 */
	public function getRoute($route) {
		//argument 1 must be a string
		Eden_Route_Error::i()->argument(1, 'string');
		
		if(isset($this->_route[$route])) {
			return $this->_route[$route];
		}
		
		return $route;
	}
	
	/**
	 * Returns all class routes
	 *
	 * @return array
	 */
	public function getRoutes() {
		return $this->_route;
	}
	
	/**
	 * Checks to see if a name is a route
	 *
	 * @param string
	 * @return bool
	 */
	public function isRoute($route) {
		return isset($this->_route[$route]);
	}
	
	/**
	 * Calls a class considering all routes.
	 *
	 * @param *string class
	 * @param [variable..] arguments
	 * @return object
	 */
	public function call($class) {
		//argument 1 must be a string
		Eden_Route_Error::i()->argument(1, 'string'); 
		
		$args = func_get_args();
		$class = array_shift($args);
		
		return $this->callArray($class, $args);
	}
	
	/**
	 * Calls a class considering all routes.
	 *
	 * @param *string class
	 * @param array arguments
	 * @return object
	 */
	public function callArray($class, array $args = array()) {
		//argument 1 must be a string
		Eden_Route_Error::i()->argument(1, 'string');	
		
		$route = $this->getRoute($class);
		
		if(is_object($route)) {
			return $route;
		}
		
		$reflect = new ReflectionClass($route);
		
		if(method_exists($route, 'i')) {
			$declared = $reflect
				->getMethod('i')
				->getDeclaringClass()
				->getName();
			
			if($declared == $route) {	
				return Eden_Route_Method::i()->callStatic($class, 'i', $args);
			}
		}
		
		return $reflect->newInstanceArgs($args);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}