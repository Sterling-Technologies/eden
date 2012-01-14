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
	protected $_reporter	= NULL;
	protected $_type 		= NULL;
	protected $_level 		= NULL;
	protected $_offset		= 1;
	protected $_variables 	= array();
	protected $_trace		= array();
	
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
    public function __construct($message = NULL, $code = 0) {
		$this->_type = self::LOGIC;
		$this->_level = self::ERROR;
		
		parent::__construct($message, $code);
	}
	
	/* Public Methods
	-------------------------------*/
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
	 * Returns the trace offset; where we should start the trace
	 *
	 * @return this
	 */
	public function getTraceOffset() {
		return $this->_offset;
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
	 * Sets exception level to WARNING
	 *
	 * @return this
	 */
	public function setLevelWarning() {
		return $this->setLevel(self::WARNING);
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
	 * Sets exception level to DEBUG
	 *
	 * @return this
	 */
	public function setLevelDebug() {
		return $this->setLevel(self::DEBUG);
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
	 * Returns the exception level
	 *
	 * @return string
	 */
	public function getLevel() {
		return $this->_level;
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
	 * Sets exception type to LOGIC
	 *
	 * @return this
	 */
	public function setTypeLogic() {
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
	 * Sets exception type to CRITICAL
	 *
	 * @return this
	 */
	public function setTypeCritical() {
		return $this->setType(self::CRITICAL);
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
	 * REturns the class or method that caught this
	 *
	 * @return string
	 */
	public function getReporter() {
		return $this->_reporter;
	}
	
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
	 * Returns variables
	 *
	 * @return array
	 */
	public function getVariables() {
		return $this->_variables;
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
	 * Tests arguments for valid data types
	 *
	 * @param *int
	 * @param *mixed
	 * @param *string[,string..]
	 * @return this
	 */
	public function argument($index, $types) {
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
			$method = 'is_'.$type;
			if(function_exists($method) && $method($argument)) {
				return $this;
			}
			
			if(class_exists($type) && $argument instanceof $type) {
				return $this;
			}
			
			if($type == 'number' && is_numeric($argument)) {
				return $this;
			}
			
			if($type == 'int' && is_numeric($argument) 
			&& strpos((string) $argument, '.') === false) {
				return $this;
			}
			
			if($type == 'float' && is_numeric($argument) 
			&& strpos((string) $argument, '.') !== false) {
				return $this;
			}
		}
		
		//lets formulate the method
		$method = $trace['function'];
		if(isset($trace['class'])) {
			$method = $trace['class'].'->'.$method;
		}
		
		$type = 'unknown';
		if(is_string($argument)) {
			$type = "'".$argument."'";
		} else if(is_numeric($argument)) {
			$type = $argument;
		} else if(is_array($argument)) {
			$type = 'Array';
		} else if(is_bool($argument)) {
			$type = $argument ? 'true' : 'false';
		} else if(is_object($argument)) {
			$type = get_class($argument);
		} else if(is_null($argument)) {
			$type = 'null';
		}
		
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
	 * Tests virtual arguments for valid data types
	 *
	 * @param *int
	 * @param *mixed
	 * @param *string[,string..]
	 * @return this
	 */
	public function vargument($method, $args, $index, $types) {
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
			$method = 'is_'.$type;
			if(function_exists($method) && $method($argument)) {
				return $this;
			}
			
			if(class_exists($type) && $argument instanceof $type) {
				return $this;
			}
			
			if($type == 'number' && is_numeric($argument)) {
				return $this;
			}
			
			if($type == 'int' && is_numeric($argument) 
			&& strpos((string) $argument, '.') === false) {
				return $this;
			}
			
			if($type == 'float' && is_numeric($argument) 
			&& strpos((string) $argument, '.') !== false) {
				return $this;
			}
		}
		
		$method = $trace['class'].'->'.$method;
		
		$type = 'unknown';
		if(is_string($argument)) {
			$type = "'".$argument."'";
		} else if(is_numeric($argument)) {
			$type = $argument;
		} else if(is_array($argument)) {
			$type = 'Array';
		} else if(is_bool($argument)) {
			$type = $argument ? 'true' : 'false';
		} else if(is_object($argument)) {
			$type = get_class($argument);
		} else if(is_null($argument)) {
			$type = 'null';
		}
		
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
	/* Private Methods
	-------------------------------*/
}