<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';

/**
 * Definition of available memcache methods. Memcache module 
 * provides handy procedural and object oriented interface to 
 * memcached, highly effective caching daemon, which was 
 * especially designed to decrease database load in dynamic 
 * web applications. We cache when computing the same data is 
 * expensive on memory or time. Once the actual data is stored 
 * in memory, it can be used in the future by accessing the 
 * cached copy rather than  recomputing the original data.
 *
 * @package    Eden
 * @category   cache
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Memcache extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_memcache = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($host = 'localhost', $port = 11211, $timeout = 1) {
		//argument test
		$error = Eden_Memcache_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'int')			//Argument 2 must be an integer
			->argument(3, 'int');		//Argument 3 must be an integer
			
		//if memcache is not a class
		if(!class_exists('Memcached')) {
			//throw exception
			$error->setMessage(Eden_Memcache_Error::NOT_INSTALLED)->trigger();
		}
		
		try {
			$this->_memcache = new Memcached;
		} catch(Exception $e) {
			//throw exception
			$error->setMessage(Eden_Memcache_Error::NOT_INSTALLED)->trigger();
		}
		
		$this->_memcache->connect($host, $port, $timeout);
		
		return $this;
	}
	
	public function __destruct() {
		if(!is_null($this->_memcache)) {
			$this->_memcache->close();
			$this->_memcache = NULL;
		}
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Add a memcached server to connection pool
	 *
	 * @param string the key to the data
	 * @param string the path of the cache
	 * @param variable the data to be cached
	 * @return bool
	 */
	public function addServer($host = 'localhost', $port = 11211, $persistent = true, $weight = NULL, $timeout = 1) {
		//argument test
		Eden_Memcache_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string
			->argument(2, 'int')				//Argument 2 must be an integer
			->argument(3, 'bool')		//Argument 3 must be a boolean
			->argument(4, 'int', 'null')	//Argument 4 must be a integer or null
			->argument(5, 'int');			//Argument 5 must be an integer
			
		$this->_memcache->addServer($host, $port, $persistent, $weight, $timeout);
		
		return $this;
	}
		
	/**
	 * Flushes the cache
	 *
	 * return this
	 */
	public function clear() {
		$this->_memcache->flush();
		
		return $this;
	}
	
	/**
	 * Gets a data cache
	 *
	 * @param string|array the key to the data
	 * @param int MemCache flag
	 * @return variable
	 */
	public function get($key, $flag = NULL) {
		//argument test
		Eden_Memcache_Error::i()
			->argument(1, 'string', 'array')	//Argument 1 must be a string or array
			->argument(2, 'int', 'null');	//Argument 2 must be an integer or null
		
		return $this->_memcache->get($key, $flag);
	}

	/**
	 * deletes data of a cache
	 *
	 * @param string the key to the data
	 * @return this
	 */
	public function remove($key) {
		//Argument 1 must be a string or array
		Eden_Memcache_Error::i()->argument(1, 'string', 'array');
		
		$this->_memcache->delete($key);
		
		return $this;
	}

	/**
	 * Sets a data cache
	 *
	 * @param string the key to the data
	 * @param variable the data to be cached
	 * @param int MemCache flag
	 * @param int expire 
	 * @return bool
	 */
	public function set($key, $data, $flag = NULL, $expire = NULL) {
		//argument test
		Eden_Memcache_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string
			->argument(3, 'int', 'null')		//Argument 3 must be an integer or null
			->argument(4, 'int', 'null');	//Argument 4 must be an integer or null
		
		$this->_memcache->set($key, $data, $flag, $expire);
		
		return $this;
	}
		
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Memcache Errors
 */
class Eden_Memcache_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const NOT_INSTALLED = 'Memcache is not installed.';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}