<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * String Object
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Type_String extends Eden_Type_Abstract {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_methods = array(
		'addslashes'				=> self::PRE,				
		'bin2hex'					=> self::PRE,	'chunk_split'				=> self::PRE,
		'convert_uudecode'			=> self::PRE,	'convert_uuencode'			=> self::PRE,
		'crypt'						=> self::PRE,	'html_entity_decode'		=> self::PRE,
		'htmlentities'				=> self::PRE,	'htmlspecialchars_decode'	=> self::PRE,
		'htmlspecialchars'			=> self::PRE,	'lcfirst'					=> self::PRE,
		'ltrim'						=> self::PRE,	'md5'						=> self::PRE,
		'nl2br'						=> self::PRE,	'quoted_printable_decode'	=> self::PRE,
		'quoted_printable_encode'	=> self::PRE,	'quotemeta'					=> self::PRE,
		'rtrim'						=> self::PRE,	'sha1'						=> self::PRE,
		'sprintf'					=> self::PRE,	'str_pad'					=> self::PRE,
		'str_repeat'				=> self::PRE,	'str_rot13'					=> self::PRE,
		'str_shuffle'				=> self::PRE,	'strip_tags'				=> self::PRE,
		'stripcslashes'				=> self::PRE,	'stripslashes'				=> self::PRE,
		'strpbrk'					=> self::PRE,	'stristr'					=> self::PRE,
		'strrev'					=> self::PRE,	'strstr'					=> self::PRE,
		'strtok'					=> self::PRE,	'strtolower'				=> self::PRE,
		'strtoupper'				=> self::PRE,	'strtr'						=> self::PRE,
		'substr_replace'			=> self::PRE,	'substr'					=> self::PRE,
		'trim'						=> self::PRE,	'ucfirst'					=> self::PRE,
		'ucwords'					=> self::PRE,	'vsprintf'					=> self::PRE,
		'wordwrap'					=> self::PRE,	'count_chars'				=> self::PRE,
		'hex2bin'					=> self::PRE,	'strlen'					=> self::PRE,
		'strpos'					=> self::PRE,	'substr_compare'			=> self::PRE,
		'substr_count'				=> self::PRE,	
		
		'str_ireplace'	=> self::POST,	'str_replace'	=> self::POST, 
		'preg_replace'	=> self::POST, 	'explode'		=> self::POST);
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($data) {
		//argument 1 must be scalar
		Eden_Type_Error::i()->argument(1, 'scalar');
		$data = (string) $data;
		
		parent::__construct($data);
	}
	
	public function __toString() {
		return $this->_data;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Camelizes a string
	 *
	 * @param string prefix
	 * @return this
	 */
	public function camelize($prefix = '-') {
		//argument 1 must be a string
		Eden_Type_Error::i()->argument(1, 'string');
		
		$this->_data = str_replace($prefix, ' ', $this->_data);
		$this->_data = str_replace(' ', '', ucwords($this->_data));
		
		$this->_data = strtolower(substr($name, 0, 1)).substr($name, 1);
		
		return $this;
	}
	
	/**
	 * Transforms a string with caps and 
	 * space to a lower case dash string 
	 *
	 * @return this
	 */
	public function dasherize() {
		$this->_data = preg_replace("/[^a-zA-Z0-9_-\s]/i", '', $this->_data);
		$this->_data = str_replace(' ', '-', trim($this->_data));
		$this->_data = preg_replace("/-+/i", '-', $this->_data);
		$this->_data = strtolower($this->_data);
		
		return $this;
	}
	
	/**
	 * Titlizes a string
	 *
	 * @param string prefix
	 * @return this
	 */
	public function titlize($prefix = '-') {
		//argument 1 must be a string
		Eden_Type_Error::i()->argument(1, 'string');
		
		$this->_data = ucwords(str_replace($prefix, ' ', $this->_data));
		
		return $this;
	}
	
	/**
	 * Uncamelizes a string
	 *
	 * @param string prefix
	 * @return this
	 */
	public function uncamelize($prefix = '-') {
		//argument 1 must be a string
		Eden_Type_Error::i()->argument(1, 'string');
		
		$this->_data = strtolower(preg_replace("/([A-Z])/", $prefix."$1", $this->_data));
		
		return $this;
	}
	
	/**
	 * Summarizes a text
	 *
	 * @param int number of words
	 * @return this
	 */
	public function summarize($words) {
		//argument 1 must be a string
		Eden_Type_Error::i()->argument(1, 'int');
		
		$this->_data = explode(' ', strip_tags($this->_data), $words);
		array_pop($this->_data);
		$this->_data = implode(' ', $this->_data);
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getMethodType(&$name) {
		if(isset(self::$_methods[$name])) {
			return self::$_methods[$name];
		}
		
		if(isset(self::$_methods['str_'.$name])) {
			$name = 'str_'.$name;
			return self::$_methods[$name];
		}
		
		$uncamel = strtolower(preg_replace("/([A-Z])/", "_$1", $name));
		
		if(isset(self::$_methods[$uncamel])) {
			$name = $uncamel;
			return self::$_methods[$name];
		}
		
		if(isset(self::$_methods['str_'.$uncamel])) {
			$name = 'str_'.$uncamel;
			return self::$_methods[$name];
		}
		
		return false;
	}
	
	/* Private Methods
	-------------------------------*/
}