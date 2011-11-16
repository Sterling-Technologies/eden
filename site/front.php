<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/../library/eden.php';

/**
 * The starting point of every application call. If you are only
 * using the framework you can rename this function to whatever you
 * like.
 *
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: application.php 21 2010-01-06 01:19:17Z blanquera $
 */
function front() {
	return Front::get();
}

/**
 * Defines the starting point of every site call.
 * Starts laying out how classes and methods are handled.
 *
 * @package    Eden
 * @category   site
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: application.php 9 2010-01-12 15:42:40Z blanquera $
 */
class Front extends Eden {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_database 	= NULL;
	protected $_cache		= NULL;
	protected $_registry	= NULL;
	protected $_pages 		= array();
	
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
		parent::__construct();
		
		//require registry
		$this->_registry = Eden_Loader::get()
			->load('Eden_Registry')
			->Eden_Registry();
	}
	
	/* Public R/R Methods
	-------------------------------*/
	/**
	 * Lets the framework handle exceptions.
	 * This is useful in the case that you 
	 * use this framework on a server with
	 * no xdebug installed.
	 *
	 * @param string|null the error type to report
	 * @param bool|null true will turn debug on
	 * @return this
	 */
	public function setDebug($reporting = NULL, $default = NULL) {
		Eden_Error::get()->argument(1, 'int', 'null')->argument(2, 'bool', 'null');
		
		Eden_Loader::get()
			->load('Eden_Template')
			->Eden_Error_Event()
			->when(!is_null($reporting))
			->setReporting($reporting)
			->endWhen()
			->when($default === true)
			->setErrorHandler()
			->setExceptionHandler()
			->listen('error', $this, 'outputError')
			->listen('exception', $this, 'outputError')
			->endWhen()
			->when($default === false)
			->releaseErrorHandler()
			->releaseExceptionHandler()
			->unlisten('error', $this, 'outputError')
			->unlisten('exception', $this, 'outputError')
			->endWhen();
		
		return $this;
	}
	
	/**
	 * Sets the application absolute paths
	 * for later referencing
	 * 
	 * @return this
	 */
	public function setPaths(array $paths = array()) {
		//this is the default paths
		$root = dirname(__FILE__);
		
		$default = array(
			'root' 			=> $root,
			'model'			=> $root.'/model',
			'web'			=> $root.'/web', 
			'assets'		=> $root.'/web/assets',
			'cache'			=> $root.'/front/cache',
			'config'		=> $root.'/front/config',
			'template'		=> $root.'/front/template');
		
		//foreach default path
		foreach($default as $key => $path) {
			$this->_registry->setData('path', $key, $path);
		}
		
		//for each path
		foreach($paths as $key => $path) {
			//make them absolute
			$path = (string) Eden_Path::get($path)->absolute();
			//set it
			$this->_registry->setData('path', $key, $path);
		}
		
		return $this;
	}
	
	/**
	 * Sets page aliases
	 *
	 * @return this
	 */
	public function setPages($pages, $absolute = false) {
		Front_Error::get()
			->argument(1, 'string', 'array')
			->argument(2, 'bool');
			
		if(is_string($pages)) {
			if(!$absolute) {
				$pages = $this->_registry->getData('path', 'config').'/'.$pages;
			}
			
			$pages = include($pages);
		}
		
		$this->_pages = $pages;
		return $this;
	}
	
	/**
	 * Sets request
	 *
	 * @param EdenRegistry|null the request object
	 * @return this
	 */
	public function setRequest(Eden_Registry $request = NULL) {
		//if no request
		if(is_null($request)) {
			//set the request
			$request = $this->_registry;
		}
		
		$path = '/';
		if(isset($_GET['request_path'])) {
			$path = $_GET['request_path'];
			unset($_GET['request_path']);
		}
		
		//determine a request path
		$path = str_replace('favicon.ico', '/', $path);
		
		//fix the request path
		$path = (string) Eden_Path::get($path);
		
		//get the path array
		$pathArray = explode('/',  $path);
		
			
		//determine the page suggestions
		$suggestions = array();
		//for each of the page pattern to paths			
		foreach($this->_pages as $pagePattern => $pagePath) {
			//we need to replace % with .*
			//so for example /page/%/edit is the same as /page/.*/edit
			$pattern = '%'.str_replace('%', '.*', $pagePattern).'%';
			//if the path matches the response path key
			if(preg_match($pattern, $path)) {
				//add the path and the length to the suggestions
				//we do this because we need to sort the suggestions
				//by relavancy
				$suggestions[strlen($pagePattern)][] = array($pagePattern, $pagePath);
			}
		}
		
		//by default the page is the home page
		$page = NULL;
		//when given a path like /page/1/edit
		//and a pattern like /page/%/edit
		//we can determine one of the path variables is 1
		//make a place holder for path variables
		//which we will find later
		$variables 	= array();
		//to do that we need suggestions
		//so if we have suggestions
		if(!empty($suggestions)) {
			//sort suggestions by length because the more detailed the
			//page link the more probable this is the page they actually want
			krsort($suggestions);
			
			//for the page to fetch we only care about the first suggestion and 
			//second index in array($pagePattern, $pagePath)
			$suggestions = array_shift($suggestions);
			$suggestions = array_shift($suggestions);
			$page = $suggestions[1];				
			
			//lets determine the path variables
			$variables = $this->_getPageVariables($path, $suggestions[0]);
		} else { 
			$classBuffer = $pathArray;
			while(count($classBuffer) > 1) {
				$classParts = ucwords(implode(' ', $classBuffer)); 
				$page = 'Front_Page'.str_replace(' ', '_', $classParts);
				if(class_exists($page)) {
					break;
				}
				
				$variable = array_pop($classBuffer);
				array_unshift($variables, $variable);
			}
			
			if(count($classBuffer) == 1) {
				$page = NULL;
			}
		}
		
		$path = array(
			'string' 	=> $path, 
			'array' 	=> $pathArray,
			'variables'	=> $variables);
		
		//set the request
		$request->setData('server', $_SERVER)
			->setData('cookie', $_COOKIE)
			->setData('request', $_REQUEST)
			->setData('get', $_GET)
			->setData('post', $_POST)
			->setData('files', $_FILES)
			->setData('request', $path)
			->setData('page', $page);
		
		return $this;
	}
	
	/**
	 * Sets response
	 *
	 * @param EdenRegistry|null the request object
	 * @return this
	 */
	public function setResponse($default, Eden_Registry $request = NULL) {
		//if no request
		if(is_null($request)) {
			//set the request
			$request = $this->_registry;
		}
		
		$page = $request->getData('page');

		if(!$page || !class_exists($page)) {
			$page = $default;
		}
		
		//set the response data
		try {
			$response = $this->$page($request);
		} catch(Exception $e) {
			$exception = new Front_Error($e->getMessage());
			exit;
		}
		
		$request->setData('response', $response);
		
		return $this;
	}
	
	/**
	 * returns the response
	 *
	 * @param EdenRegistry|null the request object
	 * @return string
	 */
	public function getResponse(Eden_Registry $request = NULL) {
		//if no request
		if(is_null($request)) {
			//set the request
			$request = $this->_registry;
		}
		
		return $request->getData('response');
	}
	
	/* Public Database Methods
	-------------------------------*/
	/**
	 * Sets up the default database connection
	 *
	 * @return this
	 */
	public function addDatabase($key, 			$type = NULL, 
								$host = NULL, 	$name = NULL, 
								$user = NULL, 	$pass = NULL, 
								$default = true) {
		Front_Error::get()
			->argument(1, 'string', 'array', 'null')
			->argument(2, 'string', 'null')
			->argument(3, 'string', 'null')
			->argument(4, 'string', 'null')
			->argument(5, 'string', 'null')
			->argument(6, 'string', 'null')
			->argument(7, 'bool');
			
		if(is_array($key)) {
			$type 		= isset($key['type']) ? $key['type'] : NULL;
			$host 		= isset($key['host']) ? $key['host'] : NULL;
			$name 		= isset($key['name']) ? $key['name'] : NULL;
			$user 		= isset($key['user']) ? $key['user'] : NULL;
			$pass 		= isset($key['pass']) ? $key['pass'] : NULL;
			$default 	= isset($key['default']) ? $key['default'] : true;
			$key 		= isset($key['key']) ? $key['key'] : NULL;
		}
		
		//connect to the data as described in the config
		switch($type) {
			case 'postgre':
				$database = Eden_Pgsql::get($host, $name, $user, $pass);
				break;
			case 'mysql':
				$database = Eden_Mysql::get($host, $name, $user, $pass);
				break;
		}
		
		$this->setData('database', $key, $database);
		
		if($default) {
			$this->_database = $database;
		}
		
		return $this;
	}
	
	/**
	 * Returns the default database instance
	 *
	 * @return Eden_Database_Abstract
	 */
	public function getDatabase($key = NULL) {
		if(is_null($key)) {
			//return the default database
			return $this->_database;
		}
		
		return $this->_registry->getData('database', $key);
	}
	
	/**
	 * Sets the default database
	 *
	 * @param string key
	 * @return this
	 */
	public function setDefaultDatabase($key) {
		Front_Error::get()->argument(1, 'string');
		
		$args = func_get_args();
		//if the args are greater than 5
		//they mean to add it
		if(count($args) > 5) {
			$this->addDatabase($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
		}
		
		//now set it
		$this->_database = $this->_registry->getData('database', $key);
		
		return $this;
	}
	
	/* Public Event Methods
	-------------------------------*/
	/**
	 * Starts filters. Filters will handle when to run.
	 *
	 * @param string|array handlers
	 * @return Eden_Application
	 */
	public function startFilters($filters) {
		Front_Error::get()->argument(1, 'string', 'array');
		
		if(is_string($filters)) {
			$filters = include($filters);
		}
		
		//for each handler as class
		foreach($filters as $class) {
			//try to
			try {
				//instantiate the class
				$this->$class($this);
			//when there's an error do nothing
			} catch(Exception $e){}
		}
		
		return $this;
	}
	
	/* Public Misc Methods
	-------------------------------*/
	/**
	 * Sets the cache
	 * 
	 * @return this
	 */
	public function setCache($root) {
		// Start the Global Cache
		Eden_Cache::get($root);
		
		return $this;
	}
	
	/**
	 * Sets the PHP timezone
	 * 
	 * @return this
	 */
	public function setTimezone($zone) {
		//if zone is not string
		if(!is_string($zone)) {
			//throw exception
			throw new Eden_Site_Exception(sprintf(Eden_Exception::NOT_STRING, 1));
		}
		
		date_default_timezone_set($zone);
		
		return $this;
	}
	
	/**
	 * Returns the current Registry
	 *
	 * @return Eden_Registry
	 */
	public function getRegistry() {
		return $this->_registry;
	}
	
	/**
	 * Returns the template loaded with specified data
	 *
	 * @param array
	 * @return Eden_Template
	 */
	public function template($file, array $data = array()) {
		Front_Error::get()->argument(1, 'string');
		return Eden_Template::get()->setData($data)->parsePhp($file);
	}
	
	/**
	 * Error trigger output
	 *
	 * @return void
	 */
	public function outputError($event, $trace, $offset, $type, $level, $class, $file, $line, $message) {
		//if there is a trace template and there's at least 2 leads
		if(count($trace) > $offset) {
			//for each trace
			foreach($trace as $i => $call) {
				//if we are at the first one
				if($i < $offset) {
					//ignore it because it will be the actual 
					//call to the error or exception
					unset($trace[$i]);
					continue;
				}
				
				//either way make this array to a comma separated string
				$argments = NULL;
				if(isset($call['args'])) {
					$argments = implode(', ', $this->_getArguments($call['args']));
				}
				//lets formulate the method
				$method = $call['function'].'('.$argments.')';
				if(isset($call['class'])) {
					$method = $call['class'].'->'.$method;
				}
				
				$tline = isset($call['line']) ? $call['line'] : 'N/A';
				$tfile = isset($call['file']) ? $call['file'] : 'Virtual Call';
				
				//convert trace from array to string
				$trace[$i] = array($method, $tfile, $tline);
			}
		} else {
			$trace = array();
		}
		
		echo $this->Eden_Template()
			->setData('trace', $trace)
			->setData('type', $type)
			->setData('level', $level)
			->setData('class', $class)
			->setData('file', $file)
			->setData('line', $line)
			->setData('message', $message)
			->parsePhp(dirname(__FILE__).'/front/template/error.php');
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getPageVariables($requestPath, $pagePath) {
		//if requestPath is not string
		if(!is_string($requestPath)) {
			//throw exception
			throw new Eden_Site_Exception(sprintf(Eden_Exception::NOT_STRING, 1));
		}
		
		//if pagePath is not string
		if(!is_string($pagePath)) {
			//throw exception
			throw new Eden_Site_Exception(sprintf(Eden_Exception::NOT_STRING, 2));
		}
		
		$variables 			= array();
		
		//fix paths
		$requestPath = $this->getFormattedPath($requestPath);
		
		//if the request path equals /
		if($requestPath == '/') {
			//there would be no page variables
			return array();
		}
		
		$pagePath = $this->getFormattedPath($pagePath);
		
		//get the arrays
		$requestPathArray 	= explode('/', $requestPath);
		$pagePathArray 		= explode('/', $pagePath);
		
		//we do not need the first path because
		// /page/1 is [null,page,1] in an array
		array_shift($requestPathArray);
		array_shift($pagePathArray);
		
		//for each request path
		foreach($requestPathArray as $i => $value) {
			//if the page path is not set, is null or is '%'
			if(!isset($pagePathArray[$i]) 
				|| trim($pagePathArray[$i]) == NULL 
				|| $pagePathArray[$i] == '%') {
				//then we can assume it's a variable
				$variables[] = $requestPathArray[$i];
			}
		}
		
		return $variables;
	}
	
	protected function _getArguments($arguments) {
		if(empty($arguments)) {
			return array();
		}
		
		//for each argument
		foreach($arguments as $i => $argument) {
			//is it a string ?
			if(is_string($argument)) {
				$argument = "'".$argument."'";
			//is it an array ?
			} else if(is_array($argument)) {
				$argument = 'Array';
			//is it an object ?
			} else if(is_object($argument)) {
				$argument = get_class($argument);
			//is it a bool ?
			} else if(is_bool($argument)) {
				$argument = $argument ? 'true' : 'false';
			//is it null ?
			} else if(is_null($argument)) {
				$argument = 'null';
			}
			
			$arguments[$i] = $argument;
		}
		
		return $arguments;
	}
	
	/* Private Methods
	-------------------------------*/
}
