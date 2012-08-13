<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/eden/event.php';

/**
 * The starting point of every framework call.
 *
 * @author     Christian Blanquera cblanquera@openovate.com
 */
function eden() {
	$class = Eden::i();
	if(func_num_args() == 0) {
		return $class;
	}
	
	$args = func_get_args();
	return $class->__invoke($args);
}

/**
 * Defines the starting point of every framework call.
 * Starts laying out how classes and methods are handled.
 *
 * @package    Eden
 * @category   framework	
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden extends Eden_Event {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_root = NULL;
	protected static $_active = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __construct() {
		if(!self::$_active) {
			self::$_active = $this;
		}
		
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
		Eden_Error::i()->argument(1, 'string');
		
		if(!class_exists('Eden_Path')) {
			Eden_Loader::i()->load('Eden_Path');
		}
		
		$this->_root = (string) Eden_Path::i($root);
		
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
	 * Get Active Application
	 *
	 * @return Eden
	 */
	public function getActiveApp() {
		return self::$_active;
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
		}
		
		//set autoload class as the autoload handler
		spl_autoload_register(array(Eden_Loader::i(), 'handler'));
		
		//we need Eden_Path to fix the path formatting
		if(!class_exists('Eden_Path')) {
			Eden_Loader::i()->addRoot(dirname(__FILE__))->load('Eden_Path');
		}
		
		//get paths
		$paths = func_get_args();
		
		//if no paths
		if(empty($paths)) {
			//do nothing more
			return $this;
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
				$path = (string) Eden_Path::i($path);
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
				Eden_Loader::i()->addRoot($path);
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
	public function routeClasses($routes) {
		Eden_Error::i()->argument(1, 'string', 'array', 'bool');
		$route = Eden_Route::i()->getClass();
		
		if($routes === true) {
			$route->route('Cache', 		'Eden_Cache')
				->route('Registry', 	'Eden_Registry')
				->route('Model', 		'Eden_Model')
				->route('Collection', 	'Eden_Collection')
				->route('Cookie', 		'Eden_Cookie')
				->route('Session', 		'Eden_Session')
				->route('Template', 	'Eden_Template')
				->route('Curl', 		'Eden_Curl')
				->route('Event', 		'Eden_Event')
				->route('Path', 		'Eden_Path')
				->route('File', 		'Eden_File')
				->route('Folder', 		'Eden_Folder')
				->route('Image', 		'Eden_Image')
				->route('Mysql', 		'Eden_Mysql')
				->route('Type', 		'Eden_Type');
			
			return $this;
		}
		
		if(is_string($routes)) {
			$routes = include($routes);
		}
		
		foreach($routes as $alias => $class) {
			$route->route($alias, $class);
		}
		
		return $this;
	}
	
	/**
	 * Sets method routes
	 *
	 * @param string|array routes
	 * @return Eden_Framework
	 */
	public function routeMethods($routes) {
		Eden_Error::i()->argument(1, 'string', 'array', 'bool');
		$route = Eden_Route::i()->getMethod();
		
		if(is_bool($routes)) {
			$route->route(NULL, 'output', 'Eden_Debug');
			return $this;
		}
		
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
				$route->route($method, $routePath[0], $routePath[1]);
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
		Eden_Session::i()->start();
		
		return $this;
	}
	
	/**
	 * Sets the PHP timezone
	 * 
	 * @return this
	 */
	public function setTimezone($zone) {
		Eden_Error::i()->argument(1, 'string');
		
		date_default_timezone_set($zone);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}