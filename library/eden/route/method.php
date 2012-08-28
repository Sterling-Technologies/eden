<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Definition for overloading methods.
 * This class also provides methods to list out various routes
 * and has the ability to call methods, static methods and 
 * functions passing arguments as an array.
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Route_Method extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_instance = NULL;
	protected $_route = array();	//method registry
	
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
	 * Calls a method considering all routes
	 *
	 * @param *string|object the class name
	 * @param *string the method name
	 * @param array the arguments you want to pass into the method
	 * @return mixed
	 */
	public function call($class, $method, array $args = array()) {
		//argument test
		Eden_Route_Error::i()
			->argument(1, 'string', 'object')			//argument 1 must be string or object
			->argument(2, 'string');					//argument 2 must be string
		
		$instance = NULL;
		if(is_object($class)) {
			$instance = $class;
			$class = get_class($class);
		}
		
		$classRoute 	= Eden_Route_Class::i();
		$isClassRoute 	= $classRoute->isRoute($class);
		$isMethodRoute	= $this->isRoute($class, $method);
		
		//method might be a route
		//lets make sure we are dealing with the right method
		//this also checks class as well
		list($class, $method) = $this->getRoute($class, $method);
		
		//class does not exist
		if(!is_object($class) && !class_exists($class)) {
			//throw exception
			Eden_Route_Error::i()
				->setMessage(Eden_Route_Error::CLASS_NOT_EXISTS)
				->addVariable($class)
				->addVariable($method)
				->trigger();
		}
		
		//method does not exist
		if(!$isClassRoute && !$isMethodRoute && !method_exists($class, $method)) {
			//throw exception
			Eden_Route_Error::i()
				->setMessage(Eden_Route_Error::METHOD_NOT_EXISTS)
				->addVariable($class)
				->addVariable($method)
				->trigger();
		}
		
		//if there is a route or no instance
		if($isClassRoute || !$instance) {
			$instance = $classRoute->call($class);
		}
		
		return call_user_func_array(array(&$instance, $method), $args);
	}
	
	/**
	 * Calls a static method considering all routes
	 *
	 * @param *string|object the class name
	 * @param *string the method name
	 * @param array the arguments you want to pass into the method
	 * @return mixed
	 */
	public function callStatic($class, $method, array $args = array()) {
		//argument test
		Eden_Route_Error::i()
			->argument(1, 'string', 'object')			//argument 1 must be string or object
			->argument(2, 'string');					//argument 2 must be string
		
		if(is_object($class)) {
			$class = get_class($class);
		}
		
		$isClassRoute 	= Eden_Route_Class::i()->isRoute($class);
		$isMethodRoute	= $this->isRoute($class, $method);
		
		//method might be a route
		//lets make sure we are dealing with the right method
		//this also checks class as well
		list($class, $method) = $this->getRoute($class, $method);
		
		//class does not exist
		if(!is_object($class) && !class_exists($class)) {
			//throw exception
			Eden_Route_Error::i()
				->setMessage(Eden_Route_Error::CLASS_NOT_EXISTS)
				->addVariable($class)
				->addVariable($method)
				->trigger();
		}
		
		//method does not exist
		if(!$isClassRoute && !$isMethodRoute && !method_exists($class, $method)) {
			//throw exception
			Eden_Route_Error::i()
				->setMessage(Eden_Route_Error::METHOD_NOT_EXISTS)
				->addVariable($class)
				->addVariable($method)
				->trigger();
		}
		
		if(is_object($class)) {
			$class = get_class($class);
		}
		
		return call_user_func_array($class.'::'.$method, $args); // As of 5.2.3
	}
	
	/**
	 * Returns the class and method that will be routed to given the route.
	 *
	 * @param *string the class route name
	 * @param *string the class route method
	 * @param string|null returns this variable if no route is found
	 * @return array|variable
	 */
	public function getRoute($class, $method) {
		Eden_Route_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		if($this->isRoute(NULL, $method)) {
			return $this->_route[NULL][strtolower($method)];
		}
		
		$class = Eden_Route_Class::i()->getRoute($class);
		
		if($this->isRoute($class, $method)) {
			return $this->_route[strtolower($class)][strtolower($method)];
		}
		
		return array($class, $method);
	}
	
	/**
	 * Returns all method routes
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
	 * @param string
	 * @return bool
	 */
	public function isRoute($class, $method) {
		if(is_string($class)) {
			$class = strtolower($class);
		}
		
		return isset($this->_route[$class][strtolower($method)]);
	}
	
	/**
	 * Unsets the route
	 *
	 * @param *string the class route name
	 * @return string|variable
	 */
	public function release($class, $method) {
		if($this->isRoute($class, $method)) {
			unset($this->_route[strtolower($class)][strtolower($method)]);
		}
		
		return $this;
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
	public function route($source, $alias, $class, $method = NULL) {
		//argument test
		Eden_Route_Error::i()
			->argument(1, 'string', 'object', 'null')	//argument 1 must be a string, object or null
			->argument(2, 'string')						//argument 2 must be a string
			->argument(3, 'string', 'object')			//argument 3 must be a string or object
			->argument(4, 'string');					//argument 4 must be a string
		
		if(is_object($source)) {
			$source = get_class($source);
		}
		
		//if the method is not a string
		if(!is_string($method)) {
			$method = $alias;
		}
		
		$route = Eden_Route_Class::i();
		if(!is_null($source)) {
			$source = $route->getRoute($source);
			$source = strtolower($source);
		}
		
		if(is_string($class)) {
			$class = $route->getRoute($class);
		}
		
		$this->_route[$source][strtolower($alias)] = array($class, $method);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}