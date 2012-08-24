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
 * General available methods for common 
 * server session procedures.
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Session extends Eden_Class implements ArrayAccess, Iterator {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_session = false;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __toString() {
		if(!self::$_session) {
			return '[]';
		}
		
		return json_encode($_SESSION);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Removes all session data
	 *
	 * @return bool
	 */
	public function clear() {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
		$_SESSION = array();
		
		return $this;
	}
	
	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        return current($_SESSION);
    }

	/**
	 * Returns data
	 *
	 * @param string|null
	 * @return mixed
	 */
	public function get($key = NULL) {
		$error = Eden_Session_Error::i()->argument(1, 'string', 'null');
		
		if(!self::$_session) {
			$error->setMessage(Eden_Session_Error::ERROR_ERROR_NOT_STARTED)->trigger();
		}
		
		if(is_null($key)) {
			return $_SESSION;
		}
		
		if(isset($_SESSION[$key])) {
			return $_SESSION[$key];
		}
		
		return NULL;
	}
	
	/**
	 * Returns session id
	 * 
	 * @return int
	 */
	public function getId() {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
		return session_id();
	}
	
	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        return key($_SESSION);
    }

	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        next($_SESSION);
    }

	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        return isset($_SESSION[$offset]);
    }
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        return isset($_SESSION[$offset]) ? $_SESSION[$offset] : NULL;
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        if (is_null($offset)) {
            $_SESSION[] = $value;
        } else {
            $_SESSION[$offset] = $value;
        }
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        unset($_SESSION[$offset]);
    }

	/**
	 * Removes a session.
	 *
	 * @param *string session name
	 * @return this
	 */
	public function remove($name) {
		Eden_Session_Error::i()->argument(1, 'string');
		
		if(isset($_SESSION[$name])) {
			unset($_SESSION[$name]);
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
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        reset($_SESSION);
    }

	/**
	 * Sets data
	 *
	 * @param array|string
	 * @param mixed
	 * @return this
	 */
	public function set($data, $value = NULL) {
		$error = Eden_Session_Error::i()->argument(1, 'array', 'string');
		
		if(!self::$_session) {
			$error->setMessage(Eden_Session_Error::ERROR_ERROR_NOT_STARTED)->trigger();
		}
		
		if(is_array($data)) {
			$_SESSION = $data;
			return $this;
		}
		
		$_SESSION[$data] = $value;
		
		return $this;
	}
	
	/**
	 * Sets the session ID
	 *
	 * @param *int
	 * @return int
	 */
	public function setId($sid) {
		$error = Eden_Session_Error::i()->argument(1, 'numeric');
		
		if(!self::$_session) {
			$error->setMessage(Eden_Session_Error::ERROR_ERROR_NOT_STARTED)->trigger();
		}
		
		return session_id((int) $sid);
	}
	/**
	 * Starts a session
	 *
	 * @return bool
	 */
	public function start() {
		if(!session_id()) {
			self::$_session = session_start();
		}
		
		return $this;
	}
	
	/**
	 * Starts a session
	 *
	 * @return Eden_SessionServer
	 */
	public function stop() {
		self::$_session = false;
		session_write_close();
		return $this;
	}
	
	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
		if(!self::$_session) {
			Eden_Session_Error::i(Eden_Session_Error::ERROR_NOT_STARTED)->trigger();
		}
		
        return isset($_SESSION[$this->key()]);
   }
	    
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Session Errors
 */
class Eden_Session_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const ERROR_NOT_STARTED = 'Session is not started. Try using Eden_Session->start() first.';
	
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