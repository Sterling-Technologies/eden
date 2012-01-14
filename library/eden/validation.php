<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Given the value, this class can perform many common tests against it.
 *
 * @package    Eden
 * @category   validation
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Validation extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_value = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($value) {
		$this->_value = $value;
	}
	
	/* Public Methods
	-------------------------------*/
	public function getErrors(array $tests = array()) {
		$errors = array();
		foreach($tests as $test) {
			
			$method = $test['method'];
			
			$message = false; 
			if(isset($test['message'])) {
				$message = $test['message'];
			}
			
			$value = NULL;
			if(isset($test['value'])) {
				$value = $test['value'];
			}
			
			if(method_exists($this, $method) && !$this->$method($value)) {
				$errors[$method] = $message;
			}
		}
		
		return $errors;
	}
	
	/**
	 * Test for data type array
	 *
	 * @return bool
	 */
	public function isArray() {
		return is_array($this->_value);
	}
	
	/**
	 * Test for data type number
	 *
	 * @return bool
	 */
	public function isNumber() {
		return is_numeric($this->_value);
	}
	
	/**
	 * Test for data type boolean
	 *
	 * @return bool
	 */
	public function isBool() {
		return is_bool($this->_value);
	}
	
	/* Public String Methods
	-------------------------------*/
	/**
	 * Test for string not empty
	 *
	 * @return bool
	 */
	public function isNotEmpty() {
		return !empty($this->_value);
	}
	
	/**
	 * Test for string is email
	 *
	 * @return bool
	 */
	public function isEmail() {
		return preg_match('/^(?:(?:(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff]))(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff])|\.(?=[^\.])){1,62}(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff])|[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]{1,2})|"(?:[^"]|(?<=\x5c)"){1,62}")@(?:(?!.{64})(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9]\.?)+\.(?:xn--[a-zA-Z0-9]+|[a-zA-Z]{2,6})|\[(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])(?:\.(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])){3}\])$/', $this->_value);
	}
	
	/**
	 * Test for string is url
	 *
	 * @return bool
	 */
	public function isUrl() {
		return preg_match('/^(http|https|ftp)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?/i', $this->_value);
	}
	
	/**
	 * Test for string is HTML
	 *
	 * @return bool
	 */
	public function isHtml() {
		return preg_match("/<\/?\w+((\s+(\w|\w[\w-]*\w)(\s*=\s*(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i", $this->_value);
	}
	
	/**
	 * Test for string is short name
	 *
	 * @return bool
	 */
	public function isShortName() {
		return !preg_match("/[^a-z0-9_]/i", $this->_value);
	}
	
	/**
	 * Test for string starting with any letter
	 *
	 * @return bool
	 */
	public function startsWithLetter() {
		return !preg_match("/^[a-zA-Z]/i", $this->_value);
	}
	
	/**
	 * Test for string length greater than
	 *
	 * @param number
	 * @return bool
	 */
	public function lengthGreaterThan($number) {
		Eden_Validation_Error::i()->argument('int');
		return strlen((string)$this->_value) > $number;
	}
	
	/**
	 * Test for string length less than
	 *
	 * @param number
	 * @return bool
	 */
	public function lengthLessThan($number) {
		Eden_Validation_Error::i()->argument('int');
		return strlen((string)$this->_value) < $number;
	}
	
	/**
	 * Test for string length greater than equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function lengthGreaterThanEqualTo($number) {
		Eden_Validation_Error::i()->argument('int');
		return strlen((string)$this->_value) >= $number;
	}
	
	/**
	 * Test for string length less than equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function lengthLessThanEqualTo($number) {
		Eden_Validation_Error::i()->argument('int');
		return strlen((string)$this->_value) <= $number;
	}
	
	/**
	 * Test for words equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function wordCountEquals($number) {
		Eden_Validation_Error::i()->argument('int');
		$words = explode(' ', $this->_value);
		return count($words) === $number;
	}
	
	/**
	 * Test for words greater than
	 *
	 * @param number
	 * @return bool
	 */
	public function wordCountGreaterThan($number) {
		Eden_Validation_Error::i()->argument('int');
		$words = explode(' ', $this->_value);
		return count($words) > $number;
	}
	
	/**
	 * Test for words less than
	 *
	 * @param number
	 * @return bool
	 */
	public function wordCountLessThan($number) {
		Eden_Validation_Error::i()->argument('int');
		$words = explode(' ', $this->_value);
		return count($words) < $number;
	}
	
	/**
	 * Test for words greater than equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function wordCountGreaterThanEqualTo($number) {
		Eden_Validation_Error::i()->argument('int');
		$words = explode(' ', $this->_value);
		return count($words) >= $number;
	}
	
	/**
	 * Test for words less than equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function wordCountLessThanEqualTo($number) {
		Eden_Validation_Error::i()->argument('int');
		$words = explode(' ', $this->_value);
		return count($words) <= $number;
	}
	
	/* Public Number Methods
	-------------------------------*/
	/**
	 * Test for number greater than
	 *
	 * @param number
	 * @return bool
	 */
	public function greaterThan($number) {
		Eden_Validation_Error::i()->argument('numeric');
		return $this->_value > (float)$number;
	}
	
	/**
	 * Test for number less than
	 *
	 * @param number
	 * @return bool
	 */
	public function lessThan($number) {
		Eden_Validation_Error::i()->argument('numeric');
		return $this->_value < (float)$number;
	}
	
	/**
	 * Test for number greater than equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function greaterThanEqualTo($number) {
		Eden_Validation_Error::i()->argument('numeric');
		return $this->_value >= (float)$number;
	}
	
	/**
	 * Test for number less than equal to
	 *
	 * @param number
	 * @return bool
	 */
	public function lessThanEqualTo($number) {
		Eden_Validation_Error::i()->argument('numeric');
		return $this->_value <= (float)$number;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Javascript Errors
 */
class Eden_Validation_Error extends Eden_Error {
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
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
	/* Magic
	-------------------------------*/
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}