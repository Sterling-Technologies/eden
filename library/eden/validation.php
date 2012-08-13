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
 * Validation
 *
 * @package    Eden
 * @category   core
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
	public function isType($type) {
		switch($type) {
			case 'number':
				return is_numeric($this->_value);
			case 'integer':
			case 'int':
				return is_numeric($this->_value) && strpos((string) $this->_value, '.') === false;
			case 'float':
				return is_numeric($this->_value) && strpos((string) $this->_value, '.') !== false;
			case 'file':
				return is_string($this->_value) && file_exists($this->_value);
			case 'folder':
				return is_string($this->_value) && is_dir($this->_value);
			case 'email':
				return is_string($this->_value) && $this->_isEmail($this->_value);
			case 'url':
				return is_string($this->_value) && $this->_isUrl($this->_value);
			case 'html':
				return is_string($this->_value) && $this->_isHtml($this->_value);
			case 'creditcard':
			case 'cc':
				return (is_string($this->_value) || is_int($this->_value)) && $this->_isCreditCard($this->_value);
			case 'hex':
				return is_string($this->_value) && $this->_isHex($this->_value);
			case 'slug':
			case 'shortname':
			case 'short':
				return !preg_match("/[^a-z0-9_]/i", $this->_value);
			default: break;
		}
		
		$method = 'is_'.$type;
		if(function_exists($method)) {
			return $method($data);
		}
		
		if(class_exists($type)) {
			return $data instanceof $type;
		}
		
		return true;
	}
	
	/* Public Number Methods
	-------------------------------*/
	public function greaterThan($number) {
		return $this->_value > (float)$number;
	}
	
	public function greaterThanEqualTo($number) {
		return $this->_value >= (float)$number;
	}
	
	public function lessThan($number) {
		return $this->_value < (float)$number;
	}
	
	public function lessThanEqualTo($number) {
		return $this->_value <= (float)$number;
	}
	
	/* Public String Methods
	-------------------------------*/		
	public function lengthGreaterThan($number) {
		return strlen((string)$this->_value) > (float)$number;
	}
	
	public function lengthGreaterThanEqualTo($number) {
		return strlen((string)$this->_value) >= (float)$number;
	}
	
	public function lengthLessThan($number) {
		return strlen((string)$this->_value) < (float)$number;
	}
		
	public function lengthLessThanEqualTo($number) {
		return strlen((string)$this->_value) <= (float)$number;
	}
	
	public function notEmpty() {
		return !empty($this->_value);
	}
	
	public function startsWithLetter() {
		return !preg_match("/^[a-zA-Z]/i", $this->_value);
	}
	
	public function alphaNumeric() {
		return preg_match('/^[a-zA-Z0-9]+$/', (string) $this->_value);
	}
	
	public function alphaNumericUnderScore() {
		return preg_match('/^[a-zA-Z0-9_]+$/', (string) $this->_value);
	}
	
	public function alphaNumericHyphen() {
		return preg_match('/^[a-zA-Z0-9-]+$/', (string) $this->_value);
	}
	
	public function alphaNumericLine() {
		return preg_match('/^[a-zA-Z0-9-_]+$/', (string) $this->_value);
	}
		
	/* Protected Methods
	-------------------------------*/
	protected function _isCreditCard($value) {
		return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]'.
		'{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-'.
		'5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/', $value);
	} 
	
	protected function _isEmail($value) {
		return preg_match('/^(?:(?:(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|\x5c(?=[@,"\[\]'.
		'\x5c\x00-\x20\x7f-\xff]))(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]'.
		'\x5c\x00-\x20\x7f-\xff]|\x5c(?=[@,"\[\]\x5c\x00-\x20\x7f-\xff])|\.(?=[^\.])){1,62'.
		'}(?:[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]|(?<=\x5c)[@,"\[\]\x5c\x00-\x20\x7f-\xff])|'.
		'[^@,"\[\]\x5c\x00-\x20\x7f-\xff\.]{1,2})|"(?:[^"]|(?<=\x5c)"){1,62}")@(?:(?!.{64})'.
		'(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9]\.?)+\.(?:xn--[a-zA-Z0-9]'.
		'+|[a-zA-Z]{2,6})|\[(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])(?:\.(?:[0-1]?\d?\d|2[0-4]\d|25'.
		'[0-5])){3}\])$/', $value);
	}
	
	protected function _isHtml($value) {
		return preg_match("/<\/?\w+((\s+(\w|\w[\w-]*\w)(\s*=\s*".
		"(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i", $value);
	}
	
	protected function _isUrl($value) {
		return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0'.
		'-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $value);
	}
	
	protected function _isHex($value) {
		return preg_match("/^[0-9a-fA-F]{6}$/", $value);
	}
	
	/* Private Methods
	-------------------------------*/
}