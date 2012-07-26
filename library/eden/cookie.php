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
 * General available methods for common cookie procedures.
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Cookie extends Eden_Class implements ArrayAccess, Iterator {
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
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Removes all cookies.
	 *
	 * @return Eden_Cookie
	 */
	public function clear() {
		foreach($_COOKIE as $key => $value) {
			$this->remove($key);
		}
		
		return $this;
	}
	
	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
		return current($_COOKIE);
    }
	
	/**
	 * Returns data
	 *
	 * @param string|null
	 * @return mixed
	 */
	public function get($key = NULL) {
		Eden_Cookie_Error::i()->argument(1, 'string', 'null');
		
		if(is_null($key)) {
			return $_COOKIE;
		}
		
		if(isset($_COOKIE[$key])) {
			return $_COOKIE[$key];
		}
		
		return NULL;
	}
	
	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
		return key($_COOKIE);
    }
	
	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
		next($_COOKIE);
    }
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return isset($_COOKIE[$offset]);
    }
	
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return isset($_COOKIE[$offset]) ? $_COOKIE[$offset] : NULL;
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
       $this->set($offset, $value, strtotime('+10 years'));
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
        $this->remove($offset);
    }
	
	/**
	 * Removes a cookie.
	 *
	 * @param *string cookie name
	 * @return Eden_Cookie
	 */
	public function remove($name) {
		Eden_Cookie_Error::i()->argument(1, 'string');
		
		$this->set($name, NULL, time() - 3600);
		
		if(isset($_COOKIE[$name])) {
			unset($_COOKIE[$name]);
		}
		
		return $this;
	}
	
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
		reset($_COOKIE);
    }
	
	/**
	 * Sets a cookie.
	 *
	 * @param *string cookie name
	 * @param variable the data
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return this
	 */
	public function set($key, $data = NULL, $expires = 0, $path = NULL, $domain = NULL, $secure = false, $httponly = false) {
		//argment test
		Eden_Cookie_Error::i()
			->argument(1, 'string')						//argument 1 must be a string
			->argument(2, 'string', 'numeric', 'null')	//argument 2 must be a string,numeric or null
			->argument(3, 'int')						//argument 3 must be a integer
			->argument(4, 'string', 'null')				//argument 4 must be a string or null
			->argument(5, 'string', 'null')			//argument 5 must be a string or null
			->argument(6, 'bool')						//argument 6 must be a boolean
			->argument(7, 'bool');					//argument 7 must be a boolean
			
		$_COOKIE[$key] = $data;
		setcookie($key, $data, $expires, $path, $domain, $secure, $httponly);
		
		return $this;
	}
	
	/**
	 * Sets a set of cookies.
	 *
	 * @param *array the data in key value format
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return this
	 */
	public function setData(array $data, $expires = 0, $path = NULL, $domain = NULL, $secure = false, $httponly = false) {
		foreach($data as $key => $value) {
			$this->set($key, $value, $expires, $path, $domain, $secure, $httponly);
		}
		
		return $this;
	}
	
	/**
	 * Sets a secure cookie.
	 *
	 * @param *string cookie name
	 * @param variable the data
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return this
	 */
	public function setSecure($key, $data = NULL, $expires = 0, $path = NULL, $domain = NULL) {
		return $this->set($key, $data, $expires, $path, $domain, true, false);
	}
		
	/**
	 * Sets a set of secure cookies.
	 *
	 * @param *array the data in key value format
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return this
	 */
	public function setSecureData(array $data, $expires = 0, $path = NULL, $domain = NULL) {
		$this->set($data, $expires, $path, $domain, true, false);
		return $this;
	}
	
	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
		return isset($_COOKIE[$this->key()]);
   }
   
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Cookie Errors
 */
class Eden_Cookie_Error extends Eden_Error {
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