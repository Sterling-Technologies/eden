<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * The base class for any class handling exceptions. Exceptions
 * allow an application to custom handle errors that would 
 * normally let the system handle. This exception allows you to 
 * specify error levels and error types. Also using this exception
 * outputs a trace (can be turned off) that shows where the problem
 * started to where the program stopped.
 *
 * @package    Eden
 * @category   error
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Error extends Exception {
	/* Constants
	-------------------------------*/
	const REFLECTION_ERROR 		= 'Error creating Reflection Class: %s, Method: %s.';
	const INVALID_ARGUMENT 		= 'Argument %d in %s() was expecting %s, however %s was given.';
	
	//error type
	const ARGUMENT	= 'ARGUMENT';	//used when argument is invalidated
	const LOGIC 	= 'LOGIC'; 		//used when logic is invalidated
	const GENERAL 	= 'GENERAL'; 	//used when anything in general is invalidated
	const CRITICAL 	= 'CRITICAL'; 	//used when anything caused application to crash
	
	//error level
	const WARNING 		= 'WARNING';
	const ERROR 		= 'ERROR';
	const DEBUG 		= 'DEBUG'; 			//used for temporary developer output
	const INFORMATION 	= 'INFORMATION'; 	//used for permanent developer notes
	
	const DEBUG_NOT_STRING 		= 'Debug was expecting a string';
	const DEBUG_NOT_PROPERTY 	= 'Debug: %s is not a property of %s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_reporter		= NULL;
	protected $_type 			= NULL;
	protected $_level 			= NULL;
	protected $_offset			= 1;
	protected $_variables 		= array();
	protected $_trace			= array();
	
	protected static $_argumentTest	= true;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    public function __construct($message = NULL, $code = 0) {
		$this->_type = self::LOGIC;
		$this->_level = self::ERROR;
		
		parent::__construct($message, $code);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Adds parameters used in the message
	 *
	 * @return this
	 */
	public function addVariable($variable) {
		$this->_variables[] = $variable;
		return $this;
	}
	
	/**
	 * Tests arguments for valid data types
	 *
	 * @param *int
	 * @param *mixed
	 * @param *string[,string..]
	 * @return this
	 */
	public function argument($index, $types) {
		//if no test
		if(!self::$_argumentTest) {
			return $this;
		}
		
		$trace 		= debug_backtrace();
		$trace 		= $trace[1];
		$types 		= func_get_args();
		$index 		= array_shift($types) - 1;
		
		if($index < 0) {
			$index = 0;
		}
		
		//if it's not set then it's good because the default value
		//set in the method will be it.
		if($index >= count($trace['args'])) {
			return $this;
		}
		
		$argument 	= $trace['args'][$index];
		
		foreach($types as $i => $type) {
			if($this->_isValid($type, $argument)) {
				return $this;
			}
		}
		
		//lets formulate the method
		$method = $trace['function'];
		if(isset($trace['class'])) {
			$method = $trace['class'].'->'.$method;
		}
		
		$type = $this->_getType($argument);
		
		$this->setMessage(self::INVALID_ARGUMENT)
			->addVariable($index + 1)
			->addVariable($method)
			->addVariable(implode(' or ', $types))
			->addVariable($type)
			->setTypeLogic()
			->setTraceOffset(1)
			->trigger();
	}
	
	/**
	 * Returns the exception level
	 *
	 * @return string
	 */
	public function getLevel() {
		return $this->_level;
	}
	
	/**
	 * Returns raw trace
	 *
	 * @return array
	 */
	public function getRawTrace() {
		return $this->_trace;
	}
	
	/**
	 * REturns the class or method that caught this
	 *
	 * @return string
	 */
	public function getReporter() {
		return $this->_reporter;
	}
	
	/**
	 * Returns the trace offset; where we should start the trace
	 *
	 * @return this
	 */
	public function getTraceOffset() {
		return $this->_offset;
	}
	
	/**
	 * Returns the exception type
	 *
	 * @return string
	 */
	public function getType() {
		return $this->_type;
	}
	
	/**
	 * Returns variables
	 *
	 * @return array
	 */
	public function getVariables() {
		return $this->_variables;
	}
	
	/**
	 * In a perfect production environment, 
	 * we can assume that arguments passed in
	 * all methods are valid. To increase
	 * performance call this method.
	 *
	 * @return this
	 */
	public function noArgTest() {
		self::$_argumentTest = false;
		return $this;
	}
	
	/**
	 * Sets exception level
	 *
	 * @param string
	 * @return this
	 */
	public function setLevel($level) {
		$this->_level = $level;
		return $this;
	}
	
	/**
	 * Sets exception level to DEBUG
	 *
	 * @return this
	 */
	public function setLevelDebug() {
		return $this->setLevel(self::DEBUG);
	}
	
	/**
	 * Sets exception level to ERROR
	 *
	 * @return this
	 */
	public function setLevelError() {
		return $this->setLevel(self::WARNING);
	}
	
	/**
	 * Sets exception level to INFORMATION
	 *
	 * @return this
	 */
	public function setLevelInformation() {
		return $this->setLevel(self::INFORMATION);
	}
	
	/**
	 * Sets exception level to WARNING
	 *
	 * @return this
	 */
	public function setLevelWarning() {
		return $this->setLevel(self::WARNING);
	}
	
	/**
	 * Sets message
	 *
	 * @param string
	 * @return this
	 */
	public function setMessage($message) {
		$this->message = $message;
		return $this;
	}
	
	/**
	 * Sets what index the trace should start at
	 *
	 * @return this
	 */
	public function setTraceOffset($offset) {
		$this->_offset = $offset;
		return $this;
	}
	
	/**
	 * Sets exception type
	 *
	 * @param string
	 * @return this
	 */
	public function setType($type) {
		$this->_type = $type;
		return $this;
	}
	
	/**
	 * Sets exception type to ARGUMENT
	 *
	 * @return this
	 */
	public function setTypeArgument() {
		return $this->setType(self::ARGUMENT);
	}
	
	/**
	 * Sets exception type to CRITICAL
	 *
	 * @return this
	 */
	public function setTypeCritical() {
		return $this->setType(self::CRITICAL);
	}
	
	/**
	 * Sets exception type to GENERAL
	 *
	 * @return this
	 */
	public function setTypeGeneral() {
		return $this->setType(self::GENERAL);
	}
	
	/**
	 * Sets exception type to LOGIC
	 *
	 * @return this
	 */
	public function setTypeLogic() {
		return $this->setType(self::CRITICAL);
	}
	
	/**
	 * Combines parameters with message and throws it
	 *
	 * @return void
	 */
	public function trigger() {
		$this->_trace = debug_backtrace();
		
		$this->_reporter = get_class($this);
		if(isset($this->_trace[$this->_offset]['class'])) {
			$this->_reporter = $this->_trace[$this->_offset]['class'];
		}
		
		if(isset($this->_trace[$this->_offset]['file'])) {
			$this->file = $this->_trace[$this->_offset]['file'];
		}
		
		if(isset($this->_trace[$this->_offset]['line'])) {
			$this->line = $this->_trace[$this->_offset]['line'];
		}
		
		if(!empty($this->_variables)) {
			$this->message = vsprintf($this->message, $this->_variables);
			$this->_variables = array();
		}
		
		throw $this;
	}
	
	/**
	 * Tests virtual arguments for valid data types
	 *
	 * @param *int
	 * @param *mixed
	 * @param *string[,string..]
	 * @return this
	 */
	public function vargument($method, $args, $index, $types) {
		//if no test
		if(!self::$_argumentTest) {
			return $this;
		}
		
		$trace   = debug_backtrace();
		$trace   = $trace[1];
		$types   = func_get_args();
		$method  = array_shift($types);
		$args  = array_shift($types);
		$index   = array_shift($types) - 1;
		
		if($index < 0) {
			$index = 0;
		}
		
		//if it's not set then it's good because the default value
		//set in the method will be it.
		if($index >= count($args)) {
			return $this;
		}
		
		$argument = $args[$index];

		foreach($types as $i => $type) {
			if($this->_isValid($type, $argument)) {
				return $this;
			}
		}
		
		$method = $trace['class'].'->'.$method;
		
		$type = $this->_getType($argument);
		
		$this->setMessage(self::INVALID_ARGUMENT)
			->addVariable($index + 1)
			->addVariable($method)
			->addVariable(implode(' or ', $types))
			->addVariable($type)
			->setTypeLogic()
			->setTraceOffset(1)
			->trigger();
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
	
	protected function _isHex($value) {
		return preg_match("/^[0-9a-fA-F]{6}$/", $value);
	}
	
	protected function _isHtml($value) {
		return preg_match("/<\/?\w+((\s+(\w|\w[\w-]*\w)(\s*=\s*".
		"(?:\".*?\"|'.*?'|[^'\">\s]+))?)+\s*|\s*)\/?>/i", $value);
	}
	
	protected function _isUrl($value) {
		return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0'.
		'-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $value);
	}
	
	public function _alphaNum($value) {
		return preg_match('/^[a-zA-Z0-9]+$/', $value);
	}
	
	public function _alphaNumScore($value) {
		return preg_match('/^[a-zA-Z0-9_]+$/', $value);
	}
	
	public function _alphaNumHyphen($value) {
		return preg_match('/^[a-zA-Z0-9-]+$/', $value);
	}
	
	public function _alphaNumLine($value) {
		return preg_match('/^[a-zA-Z0-9-_]+$/', $value);
	}
	
	protected function _isValid($type, $data) {
		$type = $this->_getTypeName($type);
		
		switch($type) {
			case 'number':
				return is_numeric($data);
			case 'int':
				return is_numeric($data) && strpos((string) $data, '.') === false;
			case 'float':
				return is_numeric($data) && strpos((string) $data, '.') !== false;
			case 'file':
				return is_string($data) && file_exists($data);
			case 'folder':
				return is_string($data) && is_dir($data);
			case 'email':
				return is_string($data) && $this->_isEmail($data);
			case 'url':
				return is_string($data) && $this->_isUrl($data);
			case 'html':
				return is_string($data) && $this->_isHtml($data);
			case 'cc':
				return (is_string($data) || is_int($data)) && $this->_isCreditCard($data);
			case 'hex':
				return is_string($data) && $this->_isHex($data);
			case 'alphanum':
				return is_string($data) && $this->_alphaNum($data);
			case 'alphanumscore':
				return is_string($data) && $this->_alphaNumScore($data);
			case 'alphanumhyphen':
				return is_string($data) && $this->_alphaNumHyphen($data);
			case 'alphanumline':
				return is_string($data) && $this->_alphaNumLine($data);
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
	
	/* Private Methods
	-------------------------------*/
	private function _getType($data) {
		if(is_string($data)) {
			return "'".$data."'";
		} 
		
		if(is_numeric($data)) {
			return $data;
		}
		
		if(is_array($data)) {
			return 'Array';
		}
		
		if(is_bool($data)) {
			return $data ? 'true' : 'false';
		}
		
		if(is_object($data)) {
			return get_class($data);
		}
		
		if(is_null($data)) {
			return 'null';
		}
		
		return 'unknown';
	}
	
	private function _getTypeName($data) {
		if(is_string($data)) {
			return $data;
		} 
		
		if(is_numeric($data)) {
			return 'numeric';
		}
		
		if(is_array($data)) {
			return 'array';
		}
		
		if(is_bool($data)) {
			return 'bool';
		}
		
		if(is_object($data)) {
			return get_class($data);
		}
		
		if(is_null($data)) {
			return 'null';
		}
	}
}