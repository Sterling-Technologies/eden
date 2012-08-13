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
 * This class objectifies APC and easily makes APC functionality 
 * available. APC does not offer having multiple instances so no 
 * model class was defined in Eve. Alternative PHP Cache (APC) 
 * Allows you to cache data in memory for the duration of the 
 * active server or an expire time has been reached. We cache 
 * when computing the same data is expensive on memory or time. 
 * Once the actual data is stored in memory, it can be used in 
 * the future by accessing the cached copy rather than 
 * recomputing the original data.
 *
 * @package    Eden
 * @category   cache
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Apc extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct() {
		//if apc_cache_info is not a function
		if(!function_exists('apc_cache_info')) {
			//throw exception
			Eden_Apc_Error::i(Eden_Apc_Error::NOT_INSTALLED)->trigger();
		}
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Flushes the cache
	 *
	 * @return this
	 */
	public function clear() {
		apc_clear_cache();
		
		return $this;
	}
	
	/**
	 * Gets a data cache
	 *
	 * @param string|array the key to the data
	 * @param int MemCache flag
	 * @return variable
	 */
	public function get($key) {
		//Argument 1 must be a string or array
		Eden_Memcache_Error::i()->argument(1, 'string', 'array');
		
		return apc_fetch($key);
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
		
		apc_delete($key);
		
		return $this;
	}
	
	/**
	 * Sets a data cache
	 *
	 * @param string the key to the data
	 * @param variable the data to be cached
	 * @param int expire 
	 * @return bool
	 */
	public function set($key, $data, $expire = NULL) {
		//argument test
		Eden_Apc_Error::i()
			->argument(1, 'string')			//Argument 1 must be a string or array
			->argument(3, 'int', 'null');	//Argument 2 must be an integer or null
		
		apc_store($key, $data, $expire);
		
		return $this;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * APC Errors
 */
class Eden_Apc_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const NOT_INSTALLED = 'APC is not installed.';
	
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