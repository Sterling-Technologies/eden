<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/error.php';
require_once dirname(__FILE__).'/route/error.php';

/**
 * Definition for overloading methods and overriding classes.
 * This class also provides methods to list out various routes
 * and has the ability to call methods, static methods and 
 * functions passing arguments as an array.
 *
 * @package    Eden
 * @subpackage route
 * @category   framework
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: route.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Route {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_instance = NULL;
	protected $_classes = array();	//class registry
	protected $_methods = array(); 	//tracks methods for classes
	
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
	/**
	 * Routes a class 
	 *
	 * @param *string the class route name
	 * @param *string the name of the class to route to
	 * @return Eden_Route
	 */
	public function routeClass($route, $class) {
		Eden_Error_Validate::get()
			->argument(0, 'string')	//argument 1 must be a string
			->argument(1, 'string');	//argument 2 must be a string
		
		$this->_classes[$route] = $class;
		return $this;
	}
	
	/**
	 * Returns the class that will be routed to given the route.
	 *
	 * @param *string the class route name
	 * @param string|null returns this variable if no route is found
	 * @return string|variable
	 */
	public function getRouteClass($route, $default = NULL) {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		if(isset($this->_classes[$route])) {
			return $this->_classes[$route];
		}
		
		return $default;
	}
	
	/**
	 * Returns the class route name that will be routed to given the class.
	 *
	 * @param *string the name of the class
	 * @param string|null returns this variable if no route is found
	 * @return string|variable
	 */
	public function getClassRoute($class, $default = NULL) {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		foreach($this->_classes as $i => $to) {
			if($to == $class) {
				return $i;
			}
		}
		
		return $default;
	}
	
	/**
	 * Returns all class routes
	 *
	 * @return array
	 */
	public function getClassRoutes() {
		return $this->_classes;
	}
	
	/**
	 * Checks to see if a name is a route
	 *
	 * @param string
	 * @return bool
	 */
	public function isClassRoute($route) {
		return isset($this->_classes[$route]);
	}
	
	/**
	 * Routes a method.
	 *
	 * @param *string the class route name
	 * @param *string the method route name
	 * @param *string the name of the class to route to
	 * @param *string the name of the method to route to
	 * @return Eden_Route
	 */
	public function routeMethod($routeClass, $routeMethod, $class, $method = NULL) {
		Eden_Error_Validate::get()
			->argument(0, 'string')	//argument 1 must be a string
			->argument(1, 'string')	//argument 2 must be a string
			->argument(2, 'string');	//argument 3 must be a string
		
		//if the method is not a string
		if(!is_string($method)) {
			$method = $routeMethod;
		}
		
		$routeClass = $this->getRouteClass($routeClass, $routeClass);
		$class 		= $this->getRouteClass($class, $class);
		
		$this->_methods[$routeClass][$routeMethod] = array($class, $method);
		
		return $this;
	}
	
	/**
	 * Returns the class and method that will be routed to given the route.
	 *
	 * @param *string the class route name
	 * @param *string the class route method
	 * @param string|null returns this variable if no route is found
	 * @return array|variable
	 */
	public function getRouteMethod($class, $method, $default = NULL) {
		Eden_Error_Validate::get()
			->argument(0, 'string')	//argument 1 must be a string
			->argument(1, 'string');	//argument 2 must be a string
		
		$class = $this->getRouteClass($class, $class);
		
		if(isset($this->_methods[$class][$method])) {
			return $this->_methods[$class][$method];
		}
		
		return $default;
	}
	
	/**
	 * Returns the route name that will be routed to given the class and method.
	 *
	 * @param *string the name of the class
	 * @param *string the name of the method
	 * @param string|null returns this variable if no route is found
	 * @return array|variable
	 */
	public function getMethodRoute($class, $method, $default = NULL) {
		Eden_Error_Validate::get()
			->argument(0, 'string')	//argument 1 must be a string
			->argument(1, 'string');	//argument 2 must be a string
		
		$class = $this->getRouteClass($class, $class);
		
		foreach($this->_methods as $routeClass => $routeMethods) {
			foreach($routeMethods as $routeMethod => $to) {
				if($to[0] == $class && $to[1] == $method) {
					return array($routeClass, $routeMethod);
				}
			}
		}
		return $default;
	}
	
	/**
	 * Checks to see if a name is a route
	 *
	 * @param string
	 * @param string
	 * @return bool
	 */
	public function isMethodRoute($class, $method) {
		return isset($this->_methods[$class][$method]);
	}
	
	/**
	 * Returns all method routes
	 *
	 * @return array
	 */
	public function getMethodRoutes() {
		return $this->_methods;
	}
	
	/**
	 * Gets a class considering all routes.
	 *
	 * @param *string class
	 * @param [variable..] arguments
	 * @return object
	 */
	public function getClass($class) {
		$args = func_get_args();
		$class = array_shift($args);
		
		Eden_Error_Validate::get()->argument(0, 'string'); //argument 1 must be a string
		
		return $this->getClassArray($class, $args);
	}
	
	/**
	 * Gets a class considering all routes.
	 *
	 * @param *string class
	 * @param array arguments
	 * @return object
	 */
	public function getClassArray($class, array $args = array()) {
		Eden_Error_Validate::get()->argument(0, 'string');	//argument 1 must be a string
		
		return $this->callMethod($class, 'get', NULL, $args);
	}
	
	/**
	 * Calls a method considering all routes
	 *
	 * @param *string|null the class name
	 * @param *string|null the method name
	 * @param true|null|object the instance;
	 * if null then the call will be treated as a 
	 * static class; if true then an instance will 
	 * be generated
	 * @param array the arguments you want to pass 
	 * into the method
	 * @return mixed
	 */
	public function callMethod($class, $method, $instance = NULL, array $args = array()) {
		Eden_Error_Validate::get()->argument(0, 'string', 'object');		//argument 1 must be string or object
		Eden_Error_Validate::get()->argument(1, 'string');					//argument 2 must be string
		Eden_Error_Validate::get()->argument(2, 'object', 'bool', 'null');	//argument 3 must be object, bool or null
		
		if(is_object($class)) {
			$class = get_class($class);
		}
		
		//class might be a route
		//lets make sure that we are dealing with the right class
		$class = $this->getRouteClass($class, $class);
		
		//method might be a route
		//lets make sure we are dealing with the right method
		list($class, $method) = $this->getRouteMethod($class, $method, array($class, $method));
		
		//class does not exist
		if(!class_exists($class)) {
			//throw exception
			throw new Eden_Route_Error(sprintf(Eden_Route_Error::CLASS_NOT_EXISTS, $class, $method));
		}
		
		//method does not exist
		if(!method_exists($class, $method)) {
			//throw exception
			throw new Eden_Route_Error(sprintf(Eden_Route_Error::METHOD_NOT_EXISTS, $class, $method));
		}
		
		//if instance is true
		//we want to load the
		//instance for the user
		if($instance === true) {
			$instance = $this->getClass($class);
		}
		
		//if instance is not an object
		if(!is_object($instance)) {
			if(!method_exists($class, $method)) {
				//throw exception
				throw new Eden_Route_Error(sprintf(Eden_Route_Error::STATIC_ERROR, $class, $method));
			}
			
			return call_user_func_array($class.'::'.$method, $args); // As of 5.2.3
		} 
		
		//instance is an object
		//if method does not exist
		if(!method_exists($instance, $method)) {
			//throw exception
			throw new Eden_Route_Error(sprintf(Eden_Route_Error::METHOD_NOT_EXISTS, get_class($instance), $method));
		}
		
		return call_user_func_array(array(&$instance, $method), $args);
	}
	
	/**
	 * Calls a function in a controlled environment
	 *
	 * @param *string the name of the function
	 * @param array the arguments you want to pass into the method
	 * @return mixed
	 */
	public function callFunction($func, array $args = array()) {
		//if the func is not a string
		if(!is_string($func)) {
			//throw an exception
			throw new Eden_Route_Error(sprintf(Eden_Exception::NOT_STRING, 1));
		}
		
		try {
			//try to run the function using PHP call_user_func_array
			return call_user_func_array($func, $args);
		} catch(_Exception $e) {
			throw new Eden_Route_Error(sprintf(Eden_Route_Error::FUNCTION_ERROR, $func));
		}
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}