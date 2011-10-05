<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/cookie/error.php';

/**
 * General available methods for common cookie procedures.
 *
 * @package    Eden
 * @subpackage cookie
 * @category   tool
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: cookie.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets a cookie.
	 *
	 * @param *string cookie name
	 * @param variable the data
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return bool
	 */
	public function set($key, $data = NULL, $expires = 0, $path = '/', $domain = NULL, $secure = false, $httponly = false) {
		//argument 1 must be a string or null
		Eden_Error_Validate::get()
			->argument(0, 'string')
			->argument(1, 'string', 'number')
			->argument(2, 'string', 'null')
			->argument(3, 'number')
			->argument(4, 'string')
			->argument(5, 'string', 'null')
			->argument(6, 'string', 'null')
			->argument(7, 'bool')
			->argument(8, 'bool');
		
		return setcookie($key, $data, (int) $expires, $path, $domain, $secure, $httponly);
	}
	
	/**
	 * Sets a secure cookie.
	 *
	 * @param *string cookie name
	 * @param variable the data
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return bool
	 */
	public function setSecure($key, $data = NULL, $expire = 0, $path = '/', $domain = NULL) {
		try {
			return $this->set($key, $data, $expires, $path, $domain, true, false);
		} catch(Eden_Error_Model $e) {
			throw new Eden_Cookie_Error($e->getMessage());
		}
	}
	
	/**
	 * Sets an unsecure cookie.
	 *
	 * @param *string cookie name
	 * @param variable the data
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return bool
	 */
	public function setUnsecure($key, $data = NULL, $expire = 0, $path = '/', $domain = NULL) {
		try {
			return $this->set($key, $data, $expires, $path, $domain, false, true);
		} catch(Eden_Error_Model $e) {
			throw new Eden_Cookie_Error($e->getMessage());
		}
	}
	
	/**
	 * Sets a set of cookies.
	 *
	 * @param *array the data in key value format
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return Eden_Cookie
	 */
	public function setData(array $data, $expires = 0, $path = '/', $domain = NULL, $secure = false, $httponly = false) {
		foreach($data as $key => $value) {
			try {
				$this->set($key, $value, $expires, $path, $domain, $secure, $httponly);
			} catch(Eden_Error_Model $e) {
				throw new Eden_Cookie_Error($e->getMessage());
			}
		}
		
		return $this;
	}
	
	/**
	 * Sets a set of secure cookies.
	 *
	 * @param *array the data in key value format
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return Eden_Cookie
	 */
	public function setSecureData(array $data, $expires = 0, $path = '/', $domain = NULL) {
		try {
			$this->setData($data, $expires, $path, $domain, true, false);
		} catch(Eden_Error_Model $e) {
			throw new Eden_Cookie_Error($e->getMessage());
		}
		
		return $this;
	}
	
	/**
	 * Sets a set of unsecure cookies.
	 *
	 * @param *array the data in key value format
	 * @param int expiration
	 * @param string path to make the cookie available
	 * @param string|null the domain
	 * @return Eden_Cookie
	 */
	public function setUnsecureData(array $data, $expires = 0, $path = '/', $domain = NULL) {
		try {
			$this->setData($data, $expires, $path, $domain, false, true);
		} catch(Eden_Error_Model $e) {
			throw new Eden_Cookie_Error($e->getMessage());
		}
		
		return $this;
	}
	
	/**
	 * Returns data
	 *
	 * @param string|null
	 * @return mixed
	 */
	public function getData($key = NULL) {
		Eden_Error_Validate::get()->argument(0, 'string', 'null');
		
		if(is_null($key)) {
			return $_COOKIE;
		}
		
		return $_COOKIE[$key];
	}
	
	/**
	 * Removes a cookie.
	 *
	 * @param *string cookie name
	 * @return Eden_Cookie
	 */
	public function remove($name) {
		Eden_Error_Validate::get()->argument(0, 'string');
		
		$this->setKey($name, NULL, time() - 3600);
		
		if(isset($_COOKIE[$name])) {
			unset($_COOKIE[$name]);
		}
		
		return $this;
	}
	
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
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
		reset($_COOKIE);
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
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
		return isset($_COOKIE[$this->key()]);
   }
   
   /**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
        try {
			$this->set($offset, $value, strtotime('+10 years'));
		} catch(Eden_Error_Model $e) {
			throw new Eden_Cookie_Error($e->getMessage());
		}
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
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
        $this->remove($offset);
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}