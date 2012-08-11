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
 * Translator utility
 *
 * @package    Eden
 * @category   utility
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Language extends Eden_Class implements ArrayAccess, Iterator {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_language 	= array();
	protected $_file		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($language = array()) {
		Eden_Language_Error::i()->argument(1, 'file', 'array');
		
		if(is_string($language)) {
			$this->_file = $language;
			$language = include($language);
		}
		
		$this->_language = $language;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the current item
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function current() {
        return current($this->_language);
    }
	
	/** 
	 * Returns the translated key.
	 * if the key is not set it will set 
	 * the key to the value of the key
	 *
	 * @param string
	 * @return string
	 */
	public function get($key) {
		Eden_Language_Error::i()->argument(1, 'string');
		
		if(!isset($this->_language[$key])) {
			$this->_language[$key] = $key;
		}
		
		return $this->_language[$key];
	}
	
	/** 
	 * Return the language set
	 *
	 * @return array
	 */
	public function getLanguage() {
		return $this->_language;
	}
	
	/**
	 * Returns th current position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function key() {
        return key($this->_language);
    }

	/**
	 * Increases the position
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function next() {
        next($this->_language);
    }

	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return isset($this->_language[$offset]);
    }
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
        return $this->get($offset);
    }
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
		$this->translate($offset, $value);
    }
	
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {
		unset($this->_language[$offset]);
    }
   
	/**
	 * Rewinds the position
	 * For Iterator interface
	 *
	 * @return void
	 */
	public function rewind() {
        reset($this->_language);
    }

	/** 
	 * Saves the language to a file
	 *
	 * @param string|null
	 * @return this
	 */
	public function save($file = NULL) {
		Eden_Language_Error::i()->argument(1, 'file', 'null');
		
		if(is_null($file)) {
			$file = $this->_file;
		}
		
		if(is_null($file)) {
			Eden_Language_Error::i()
				->setMessage(Eden_Language_Error::INVALID_ARGUMENT)
				->addVariable(1)
				->addVariable(__CLASS__.'->'.__FUNCTION__)
				->addVariable('file or null')
				->addVariable($file)
				->setTypeLogic()
				->trigger();
		}
		
		Eden_File::i($file)->setData($this->_language);
		
		return $this;
	}
	
	/** 
	 * Sets the translated value to the specified key
	 *
	 * @param string
	 * @param string
	 * @return this
	 */
	public function translate($key, $value) {
		Eden_Language_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_language[$key] = $value;
		
		return $this;
	}
	
	/**
	 * Validates whether if the index is set
	 * For Iterator interface
	 *
	 * @return void
	 */
    public function valid() {
        return isset($this->_language[key($this->_language)]);
    }
	 	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Language Errors
 */
class Eden_Language_Error extends Eden_Error {
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