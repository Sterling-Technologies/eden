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
	protected $_root = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct() {
		$this->_root = dirname(__FILE__);
	}
	
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
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets the root path
	 *
	 * @param string
	 * @return this
	 */
	public function setRoot($root) {
		Eden_Error::get()->argument(1, 'string');
		
		if(!class_exists('Eden_Path')) {
			Eden_Loader::get()->load('Eden_Path');
		}
		
		$this->_root = (string) Eden_Path::get($root);
		
		return $this;
	}
	
	/**
	 * Returns the root path
	 *
	 * @return string
	 */
	public function getRoot() {
		return $this->_root;
	}
	
	/**
	 * Sets up Autoloading
	 *
	 * @param string|array path
	 * @return this
	 */
	public function setLoader() { 
		if(!class_exists('Eden_Loader')) {
			//require autoload
			require_once dirname(__FILE__).'/eden/loader.php';
		
			//set autoload class as the autoload handler
			spl_autoload_register(array(Eden_Loader::get(), 'handler'));
		}
		
		//get paths
		$paths = func_get_args();
		
		//if no paths
		if(empty($paths)) {
			//do nothing more
			return $this;
		}
		
		//we need Eden_Path to fix the path formatting
		if(!class_exists('Eden_Path')) {
			Eden_Loader::get()->load('Eden_Path');
		}
		
		//no dupes
		$paths = array_unique($paths);
		
		//for each path 
		foreach($paths as $i => $path) {
			if(!is_string($path) && !is_null($path)) {
				continue;
			}
			
			if($path) {
				//format the path
				$path = (string) Eden_Path::get($path);
			} else {
				$path = $this->_root;
			}
			
			//if path is not a real path
			if(!is_dir($path)) {
				//append the root
				$path = $this->_root.$path;	
			}
			
			//if the path is still a real path
			if(is_dir($path)) {
				//add the root
				Eden_Loader::get()->addRoot($path);
			}
		}
		
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
		$route = Eden_Route::get();
		
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
				$route->routeMethod($method, $routePath[0], $routePath[1]);
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
	
	/**
	 * Sets the PHP timezone
	 * 
	 * @return this
	 */
	public function setTimezone($zone) {
		Eden_Error::get()->argument(1, 'string');
		
		date_default_timezone_set($zone);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}