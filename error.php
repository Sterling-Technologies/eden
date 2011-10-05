<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2010-2012 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/error/model.php';
require_once dirname(__FILE__).'/error/validate.php';

/**
 *
 * @package    Eden
 * @category   error
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: exception.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Error {
	/* Constants
	-------------------------------*/
	//error type
	const PHP		= 'PHP';	//used when argument is invalidated
	
	//error level
	const WARNING 	= 'WARNING';
	const ERROR 	= 'ERROR';
	
	const UNKNOWN	= 'UNKNOWN';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected static $_instance = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		$class = __CLASS__;
		if(is_null(self::$_instance)) {
			self::$_instance = new $class();
		}
		
		return self::$_instance;
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/** 
	 * Called when a PHP error has occured. Must
	 * use setErrorHandler() first.
	 *
	 * @param number error number 
	 * @param string message
	 * @param string file
	 * @param string line
	 * @return true
	 */
	public function errorHandler($errno, $errstr, $errfile, $errline) {
		//depending on the error number 
		//we can determine the error level
    	switch ($errno) {
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_WARNING:
			case E_USER_WARNING:
				$level = self::WARNING;
				break;
			case E_ERROR:
			case E_USER_ERROR:
			default:
				$level = self::ERROR;
				break;
        }
		
		//errors are only triggered through PHP
		$type = self::PHP;
		
		//get the trace
		$trace = debug_backtrace();
		
		//by default we do not know the class
		$class = self::UNKNOWN;
		
		//if there is a trace
		if(count($trace) > 1) {
			//formulate the class
			$class = $trace[1]['function'].'()';
			if(isset($trace[1]['class'])) {
				$class = $trace[1]['class'].'->'.$class;
			}
		}
		
		echo $this->_getMessage(
			$trace,		1,
			$type, 		$level, 
			$class, 	$errfile, 
			$errline, 	$errstr);
		
		//Don't execute PHP internal error handler
		return true;
	}
	
	/** 
	 * Registers this class' error handler to PHP
	 *
	 * @return this
	 */
	public function setErrorHandler() {
		set_error_handler(array($this, 'errorHandler'));
		return $this;
	}
	
	/** 
	 * Returns default handler back to PHP
	 *
	 * @return this
	 */
	public function releaseErrorHandler() {
		restore_error_handler();
		return $this;
	}
	
	/** 
	 * Sets template used for errors and exceptions
	 *
	 * @return this
	 */
	public function setTemplate($template) {
		$this->_template = $template;
		return $this;
	}
	
	/** 
	 * Sets each trace template used for errors and exceptions
	 *
	 * @return this
	 */
	public function setTrace($template) {
		$this->_trace = $template;
		return $this;
	}
	
	/** 
	 * Called when a PHP exception has occured. Must
	 * use setExceptionHandler() first.
	 *
	 * @param Exception
	 * @return void
	 */
	public function exceptionHandler(Exception $e) {
		//by default set LOGIC ERROR
		$type 		= Eden_Error_Model::LOGIC;
		$level 		= Eden_Error_Model::ERROR;
		$offset 	= 1;
		$reporter 	= get_class($e);
		
		//if the exception is an eden exception
		if($e instanceof Eden_Error_Model) {
			//set type and level from that
			$type 		= $e->getType();
			$level 		= $e->getLevel();
			$offset 	= $e->getTraceOffset();
			$reporter 	= $e->getReporter();
		}
		
		//get trace
		$trace = $e->getTrace();
		
		echo $this->_getMessage(
			$trace,		$offset,
			$type, 		$level, 
			$reporter, 	$e->getFile(), 
			$e->getLine(), 	$e->getMessage());
	}
	
	/** 
	 * Registers this class' exception handler to PHP
	 *
	 * @return this
	 */
	public function setExceptionHandler() {
		set_exception_handler(array($this, 'exceptionHandler'));
		return $this;
	}
	
	/** 
	 * Returns default handler back to PHP
	 *
	 * @return this
	 */
	public function releaseExceptionHandler() {
		restore_exception_handler();
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getMessage($trace, $offset, $type, $level, $class, $file, $line, $message) {
		//if there is a trace template and there's at least 2 leads
		if($this->_trace && count($trace) > $offset) {
			//for each trace
			foreach($trace as $i => $call) {
				//if we are at the first one
				if($i < $offset) {
					//ignore it because it will be the actual 
					//call to the error or exception
					unset($trace[$i]);
					continue;
				}
				
				//lets formulate the arguments
				$args = array();
				
				//if there are arguments
				if(!empty($call['args'])) {
					//for each argument
					foreach($call['args'] as $arg) {
						//is it a string ?
						if(is_string($arg)) {
							$arg = "'".$arg."'";
						//is it an array ?
						} else if(is_array($arg)) {
							$arg = 'Array';
						//is it an object ?
						} else if(is_object($arg)) {
							$arg = get_class($arg);
						//is it a bool ?
						} else if(is_bool($arg)) {
							$arg = $arg ? 'true' : 'false';
						//is it null ?
						} else if(is_null($arg)) {
							$arg = 'null';
						}
						
						$args[] = $arg;
					}
				}
				
				//either way make this array to a comma separated string
				$args = implode(', ', $args);
				
				//lets formulate the method
				$method = $call['function'].'('.$args.')';
				if(isset($call['class'])) {
					$method = $call['class'].'->'.$method;
				}
				
				$tline = isset($call['line']) ? $call['line'] : 'N/A';
				$tfile = isset($call['file']) ? $call['file'] : 'Virtual Call';
				
				//convert trace from array to string
				$trace[$i] = sprintf($this->_trace, $method, $tfile, $tline);
			}
			
			$trace = implode("\n", $trace);
		} else {
			$trace = NULL;
		}
		
		return sprintf(
			$this->_template, 
			$type, $level, $class,
			$file, $line,
			$message, $trace);
	}
	
	/* Private Methods
	-------------------------------*/
}