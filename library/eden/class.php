<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/error.php';
require_once dirname(__FILE__).'/route.php';

require_once dirname(__FILE__).'/debug.php';
require_once dirname(__FILE__).'/when.php';
require_once dirname(__FILE__).'/loop.php';

/**
 * The base class for all classes wishing to integrate with Eden.
 * Extending this class will allow your methods to seemlessly be 
 * overloaded and overrided as well as provide some basic class
 * loading patterns.
 *
 * @package    Eden
 * @category   core	
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Class {
	/* Constants
	-------------------------------*/
	const DEBUG		= 'DEBUG %s:';
	const INSTANCE 	= 0;
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	private static $_instances 	= array();
	
	/* Magic
	-------------------------------*/
	public static function i() {
		if(static::INSTANCE === 1) {
			return self::_getSingleton();
		}
		
		return self::_getMultiple();
	}
	
	public function __call($name, $args) {
		//if the method name starts with a capital letter
		//most likely they want a class
		if(preg_match("/^[A-Z]/", $name)) {
			//lets first consider that they may just
			//want to load a class so lets try
			try {
				//return the class
				return Eden_Route::i()->getClass($name, $args);
			//only if there's a route exception do we want to catch it
			//this is because a class can throw an exception in their construct
			//so if that happens then we do know that the class has actually
			//been called and an exception is suppose to happen
			} catch(Eden_Route_Error $e) {}
		}
		
		try {
			//let the router handle this
			return Eden_Route::i()->getMethod()->call($this, $name, $args);
		} catch(Eden_Route_Error $e) {
			Eden_Error::i($e->getMessage())->trigger();
		}
	}
	
	public function __invoke() {
		//if arguments are 0
		if(func_num_args() == 0) {
			//return this
			return $this;
		}
		
		//get the arguments
		$args = func_get_args();
		
		//if the first argument is an array
		if(is_array($args[0])) {
			//make the args that
			$args = $args[0];
		}
		
		//take our the class name
		$class = array_shift($args);
		//if this class does not start with Eden
		if(strpos('Eden_', $class) !== 0) {
			//add it
			$class = 'Eden_'.$class;
		}
		
		//try to
		try {
			//instantiate it
			return Eden_Route::i()->getClass($class, $args);
		} catch(Eden_Route_Error $e) {
			//throw the error at this point 
			//to get rid of false positives
			Eden_Error::i($e->getMessage())->trigger();
		}
	}
	
	public function __toString() {
		return get_class($this);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Calls a method in this class and allows 
	 * argumetns to be passed as an array
	 *
	 * @param string
	 * @param array
	 * @return mixed
	 */
	public function callThis($method, array $args = array()) {
		//argument 1 must be a string
		Eden_Error::i()->argument(1,'string');
		
		return Eden_Route::i()->getMethod($this, $method, $args);
	}
	
	/** 
	 * Force outputs any class property
	 *
	 * @param string|null
	 * @param string|null
	 * @return this
	 */
	public function debug($variable = NULL, $next = NULL) {
		//we are using tool in all cases
		$class 	= get_class($this);
		
		//if variable is null
		if(is_null($variable)) {
			//output the class
			Eden_Debug::i()
				->output(sprintf(self::DEBUG, $class))
				->output($this);
				
			return $this;
		}
		
		//if variable is true
		if($variable === true) {
			//return whatever the next response is
			//or return the next specified variable
			return Eden_Debug::i()->next($this, $next);
		}
		
		//if variable is not a string
		if(!is_string($variable)) {
			//soft output error
			Eden_Debug::i()->output(Eden_Error::DEBUG_NOT_STRING);
			return $this;
		}
		
		//if variable is set
		if(isset($this->$variable)) {
			//output it
			Eden_Debug::i()
				->output(sprintf(self::DEBUG, $class.'->'.$variable))
				->output($this->$variable);
				
			return $this;
		}
		
		//could be private
		$private = '_'.$variable;
		//if private variable is set
		if(isset($this->$private)) {
			//output it
			Eden_Debug::i()
				->output(sprintf(self::DEBUG, $class.'->'.$private))
				->output($this->$private);
				
			return $this;
		}
		
		//soft output error
		Eden_Debug::i()->output(sprintf(Eden_Error::DEBUG_NOT_PROPERTY, $variable, $class));
			
		return $this;
	}
	
	/** 
	 * Loops through returned result sets
	 *
	 * @param *callable
	 * @return this
	 */
	public function each($callback) {
		Eden_Error::i()->argument(1, 'callable');
		return Eden_Loop::i()->iterate($this, $callback);
	}
	
	/**
	 * Creates a class route for this class.
	 * 
	 * @param *string the class route name
	 * @return Eden_Class
	 */
	public function routeThis($route) {
		//argument 1 must be a string
		Eden_Error::i()->argument(1, 'string');
		
		if(func_num_args() == 1) {
			//when someone calls a class call this instead
			Eden_Route::i()->getClass()->route($route, $this);
			return $this;
		}
		
		//argument 2 must be a string
		Eden_Error::i()->argument(2, 'string', 'object');
		
		$args = func_get_args();
		
		$source = array_shift($args);
		$class 	= array_shift($args);
		$destination = NULL;
		
		if(count($args)) {
			$destination = array_shift($args);
		}
		
		//when someone calls a method here call something ele instead
		Eden_Route::i()->getMethod()->route($this, $source, $class, $destination);
		return $this;
	}
	
	/**
	 * Invokes When if conditional is false
	 *
	 * @param bool
	 * @return this|Eden_Noop
	 */
	public function when($isTrue, $lines = 0) {
		if($isTrue) {
			return $this;
		}
		
		return Eden_When::i($this, $lines);
	}
	
	/* Protected Methods
	-------------------------------*/
	protected static function _getMultiple($class = NULL) {
		if(is_null($class) && function_exists('get_called_class')) {
			$class = get_called_class();
		}
		
		$class = Eden_Route::i()->getClass()->getRoute($class);		
		return self::_getInstance($class);
	}
	
	protected static function _getSingleton($class = NULL) {
		if(is_null($class) && function_exists('get_called_class')) {
			$class = get_called_class();
		}
		
		$class = Eden_Route::i()->getClass()->getRoute($class);
		
		if(!isset(self::$_instances[$class])) {
			self::$_instances[$class] = self::_getInstance($class);
		}
		
		return self::$_instances[$class];
	}
		
	/* Private Methods
	-------------------------------*/
	private static function _getInstance($class) {
		$trace 	= debug_backtrace();
		$args 	= array();
		
		if(isset($trace[1]['args']) && count($trace[1]['args']) > 1) {
			$args = $trace[1]['args'];
			//shift out the class name
			array_shift($args);
		} else if(isset($trace[2]['args']) && count($trace[2]['args']) > 0) {
			$args = $trace[2]['args'];
		}
		
		if(count($args) === 0 || !method_exists($class, '__construct')) {
			return new $class;
		}
		
		$reflect = new ReflectionClass($class);
		
		try {
			return $reflect->newInstanceArgs($args);
		} catch(Reflection_Exception $e) {
			Eden_Error::i()
				->setMessage(Eden_Error::REFLECTION_ERROR) 
				->addVariable($class)
				->addVariable('new')
				->trigger();
		}
	}
}