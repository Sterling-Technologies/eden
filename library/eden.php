<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once 'eden/event.php';

/**
 * The starting point of every framework call.
 *
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: framework.php 9 2010-01-12 15:42:40Z blanquera $
 */
function eden() {
	//return the results
	return Eden::get();
}

/**
 * Defines the starting point of every framework call.
 * Starts laying out how classes and methods are handled.
 *
 * @package    Eden
 * @category   framework	
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: framework.php 9 2010-01-12 15:42:40Z blanquera $
 */
class Eden extends Eden_Event {
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
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __call($name, $args) {
		//first try to call the parent call
		try {
			return parent::__call($name, $args);
		//this means something in the route went wrong
		} catch(Eden_Route_Exception $e) {
			//now try to call parent with the eden prefix
			return parent::__call('Eden_'.$name, $args);
		}
	}
	
	public function __construct() {
		if(!class_exists('Eden_Loader')) {
			//require autoload
			require_once dirname(__FILE__).'/eden/loader.php';
		
			//set autoload class as the autoload handler
			spl_autoload_register(array(Eden_Loader::get(), 'handler'));
		}
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Adds a root path to search in when a class does not exist.
	 * Being as specific as possible will reduce the time it takes
	 * to find the class.
	 *
	 * @param string|array path
	 * @return Eden_Framework
	 */
	public function addRoot($path) { 
		Eden_Error::get()->argument(1, 'string');
		Eden_Loader::get()->addRoot($path);
		return $this;
	}
	
	/**
	 * Sets class routes
	 *
	 * @param string|array routes
	 * @return Eden_Framework
	 */
	public function setClasses($routes) {
		Eden_Error::get()->argument(1, 'string', 'array');
		$route = Eden_Route::get();
		
		if(is_string($routes)) {
			$routes = include($routes);
		}
		
		foreach($routes as $alias => $class) {
			$route->routeClass($alias, $class);
		}
		
		return $this;
	}
	
	/**
	 * Sets method routes
	 *
	 * @param string|array routes
	 * @return Eden_Framework
	 */
	public function setMethods($routes) {
		Eden_Error::get()->argument(1, 'string', 'array');
		
		if(is_string($routes)) {
			$routes = include($routes);
		}
		
		//walk the routes
		foreach($routes as $method => $routePath) {
			//if the path is a string
			if(is_string($routePath)) {
				//turn it into an array
				$routePath = array($routePath);
			}
			
			//if the path is an array and it's not empty
			if(is_array($routePath) && !empty($routePath)) {
				//if the size is 1
				if(count($routePath) == 1) {
					//they mean the methods have the same name
					$routePath[] = $method;
				}
				
				//route the method
				$this->routeMethod($method, $routePath[0], $routePath[1]);
			}
		}
		
		return $this;
	}
	
	/**
	 * Starts a session
	 *
	 * @return this
	 */
	public function startSession() {
		//get the session class
		Eden_Session::get()->start();
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}