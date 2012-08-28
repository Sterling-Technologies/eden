<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/file.php';

/**
 * This class allows the use of setting up multiple file cache 
 * locations. A file cache is a collection of files with data 
 * that was previously computed. We cache when computing the 
 * same data is expensive on memory or time. Once the data is 
 * stored in the file cache, it can be used in the future by 
 * accessing the cached copy rather than recomputing the 
 * original data.
 *
 * @package    Eden
 * @category   cache
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Cache extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key	 	= NULL;
	protected $_path 	= NULL;
	protected $_cache 	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($root, $key = 'key.php') {
		Eden_Cache_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->setKey($key)->setRoot($root)->build();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Builds the cache into memory
	 *
	 * @return Eden_CacheModel
	 */
	public function build() {
		try {
			$this->_cache = Eden_File::i($this->_path.'/'.$this->_key)->getData();
		} catch(Eden_Path_Error $e) {
			$this->_cache = array();
		}
		return $this;
	}
	
	/**
	 * Gets a data cache
	 *
	 * @param *string the key to the data
	 * @return mixed
	 */
	public function get($key, $default = NULL) {
		//argument 1 must be a string
		Eden_Cache_Error::i()->argument(1, 'string');
		
		//if the key exists
		if($this->keyExists($key)) {
			//return it
			return Eden_File::i($this->_cache[$key])->getData();
		}
		
		//return the defauit
		return $default;
	}
	
	/**
	 * Gets the unix time of when a cache has been created
	 *
	 * @param *string the key to the data
	 * @return int
	 */
	public function getCreated($key) {
		//argument 1 must be a string
		Eden_Cache_Error::i()->argument(1, 'string');
		
		//if the key exists
		if($this->keyExists($key)) {
			//return it
			return Eden_File::i($this->_cache[$key])->getTime();
		}
		
		return 0;
	}
	
	/**
	 * returns a list of keys
	 *
	 * @return array
	 */
	public function getKeys() {		
		//return the defauit
		return array_keys($this->_cache);
	}
	
	/**
	 * Checks if a key is cached
	 *
	 * @param *string the key to the data
	 * @return bool
	 */
	public function keyExists($key) {
		//argument 1 must be a string
		Eden_Cache_Error::i()->argument(1, 'string');
		
		return isset($this->_cache[$key]) && file_exists($this->_cache[$key]);
	}
	
	/**
	 * Sets a data cache
	 *
	 * @param *string the key to the data
	 * @return this
	 */
	public function remove($key) {
		//argument test
		Eden_Cache_Error::i()->argument(1, 'string');		//argument 1 must be a string
		
		if(isset($this->_cache[$key])) {
			unset($this->_cache[$key]);
		}
		
		//now we want to store the key and data file correlation
		Eden_File::i($this->_path.'/'.$this->_key)->setData($this->_cache);
		
		return $this;
	}
	
	/**
	 * Sets a data cache
	 *
	 * @param *string the key to the data
	 * @param *string the path of the cache
	 * @param *mixed the data to be cached
	 * @return Eden_CacheModel
	 */
	public function set($key, $path, $data) {
		//argument test
		Eden_Cache_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//get the proper path format
		$path = $this->_path.Eden_Path::i($path);
		//set the data to the file
		Eden_File::i($path)->setData($data);
		//store this data in memory by keyword
		$this->_cache[$key] = $path;
		//now we want to store the key and data file correlation
		Eden_File::i($this->_path.'/'.$this->_key)->setData($this->_cache);
		
		return $this;
	}
	
	/**
	 * Sets a cache key file
	 *
	 * @param *string the name of the key file
	 * @return Eden_CacheModel
	 */
	public function setKey($key) {
		//argument 1 must be a string
		Eden_Cache_Error::i()->argument(1, 'string');
		
		$this->_key = $key;
		return $this;
	}
	
	/**
	 * Sets a cache path root
	 *
	 * @param string the root path
	 * @return Eden_CacheModel
	 */
	public function setRoot($root) {
		//argument 1 must be a string
		Eden_Cache_Error::i()->argument(1, 'string');
		
		$this->_path = (string) Eden_Path::i($root)->absolute();
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Cache Errors
 */
class Eden_Cache_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
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