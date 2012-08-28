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
 * Allows the ability to listen to events made known by another 
 * piece of functionality. Events are items that transpire based 
 * on an action. With events you can add extra functionality 
 * right after the event has triggered.
 *
 * @package    Eden
 * @category   event
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Event extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_observers 		= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
     * Attaches an instance to be notified
     * when an event has been triggered
     *
     * @param *string
	 * @param *string|object|callable
	 * @param string|null|bool
	 * @param bool
     * @return this
     */
    public function listen($event, $instance, $method = NULL, $important = false) {
		$error = Eden_Event_Error::i()
			->argument(1, 'string')							//argument 1 must be string
			->argument(2, 'object', 'string', 'callable')	//argument 2 must be object, string or callable
			->argument(3, 'null', 'string', 'bool')			//argument 3 must be string or null
			->argument(4, 'bool');							//argument 4 must be boolean
		
		//if method is bool
		if(is_bool($method)) {
			//this was meant to be important
			$important 	= $method;
			$method 	= NULL;
		}
		
		$id 		= $this->_getId($instance, $method);
		$callable 	= $this->_getCallable($instance, $method);
		
		//set up the observer
		$observer = array($event, $id, $callable);
		
		//if this is important
		if($important) {
			//put the observer on the top of the list
			array_unshift($this->_observers, $observer);	
			return $this;
		}
        
		//add the observer
		$this->_observers[] = $observer;
		return $this;
    }
	
	/**
     * Notify all observers of that a specific 
	 * event has happened
     *
	 * @param string
	 * @param [mixed]
     * @return this
     */
    public function trigger($event = NULL) {
		//argument 1 must be string
		Eden_Event_Error::i()->argument(1, 'string', 'null');
		
		if(is_null($event)) {
			$trace = debug_backtrace();
			$event = $trace[1]['function'];
		}
		
		//get the arguments
		$args = func_get_args();
		//shift out the event
		$event = array_shift($args);
		
		//as a courtesy lets shift in the object
		array_unshift($args, $this, $event);
		
		//for each observer
		foreach($this->_observers as $observer) {
			//if this is the same event, call the method, if the method returns false
			if($event == $observer[0] && call_user_func_array($observer[2], $args) === false) {
				//break out of the loop
				break;
			}
        }
		
		return $this;
    }
	
    /**
     * Stops listening to an event
     *
	 * @param string|null
     * @param object|null
	 * @param string|null
     * @return this
     */
    public function unlisten($event, $instance = NULL, $method = NULL) {
		Eden_Event_Error::i()
			->argument(1, 'string', 'null')				//argument 1 must be string or null
			->argument(2, 'object', 'string', 'null')	//argument 2 must be instance or null
			->argument(3, 'string', 'null');			//argument 3 must be string or null
		
		//if there is no event and no instance
		if(is_null($event) && is_null($instance)) {
			//it means that they want to remove everything
			$this->_observers = array();
			return $this;
		}
		
		$id = $this->_getId($instance, $method);
		
		//if we could not determine the id
		if($id === false) {
			//do nothing
			return false;
		}
		
		//for each observer
        foreach($this->_observers as $i => $observer) {
			//if there is an event and is not being listened to
			if(!is_null($event) && $event != $observer[0]) {
				//skip it
				continue;
			}
			
			if($id == $observer[1] && is_array($observer[2]) && $method != $observer[2][1]) {
				continue;
			}
			
			if($id != $observer[1]) {
				continue;
			}
			
			//unset it
			unset($this->_observers[$i]);
		}
		
		return $this;
    }

	/* Protected Methods
	-------------------------------*/
	protected function _getCallable($instance, $method = NULL) {
		if(class_exists('Closure') && $instance instanceof Closure) {
			return $instance;
		}
		
		if(is_object($instance)) {
			return array($instance, $method);
		}
		
		if(is_string($instance) && is_string($method)) {
			return $instance.'::'.$method;
		} 
		
		if(is_string($instance)) {
			return $instance;
		}
		
		return NULL;
	}
	
	protected function _getId($instance, $method = NULL) {
		if(is_object($instance)) {
			return spl_object_hash($instance);
		}
		
		if(is_string($instance) && is_string($method)) {
			return $instance.'::'.$method;
		}
		
		if(is_string($instance)) {
			return $instance;
		}
		
		return false;
	}
	
	/* Private Methods
	-------------------------------*/
}

/**
 * Event Errors
 */
class Eden_Event_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	const NO_METHOD = 'Instance %s was passed but, no callable method was passed in listen().';
	
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