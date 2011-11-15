<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
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
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
     * Attaches an instance to be notified
     * when an event has been triggered
     *
     * @param *string
	 * @param *string|object
	 * @param string|null
	 * @param bool
     * @return this
     */
    public function listen($event, $instance, $method = NULL, $important = true) {
		Eden_Event_Error::get()
			->argument(1, 'string')					//argument 1 must be string
			->argument(2, 'object', 'string')		//argument 2 must be object or string
			->argument(3, 'null', 'string', 'bool')	//argument 3 must be string or null
			->argument(4, 'bool');					//argument 4 must be boolean
		
		//get the instance unique id
		$id = is_object($instance) ? spl_object_hash($instance) : false;
		
		//if method is bool
		if(is_bool($method)) {
			//this was meant to be impoertant
			$important = $method;
		} 
		
		//if the method is string
		if(is_string($method)) {
			//set up a class call
			$method = array($instance, $method);
		} else {
			//instance must be a function call
			$method = $instance;
		}
		
		//set up the observer
		$observer = array($event, $id, $method);
		
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
     * Stops listening to an event
     *
     * @param object
	 * @param string|null
     * @return this
     */
    public function unlisten($event, $instance, $method = NULL) {
		Eden_Event_Error::get()
			->argument(1, 'string', 'null')		//argument 1 must be string or null
			->argument(2, 'object', 'string')	//argument 2 must be instance
			->argument(3, 'string', 'null');	//argument 3 must be string or null
			
		$id 	= false;
		$class 	= $instance;
		
		//if instance is an object
		if(is_object($instance)) {
			//set the id
			$id 	= spl_object_hash($instance);
			//get the class name
			$class 	= get_class($instance);
		}
		
		
		//for each observer
        foreach($this->_observers as $i => $observer) {
			//if there is an event and event is not being listened to
			if(!is_null($event) && $event != $observer[0]) {
				//skip it
				continue;
			}
			
			//if id is not equal to observer
			if($id != $observer[1]) {
				//skip it
				continue;
			}
			
			//if this is a class call
			if(is_array($observer[2])) {
				//instance is a string and instance equals class
				if(is_string($observer[2][0]) && $observer[2][0] != $class) {
					//skip it
					continue;
				}
				
				//instance either equals class or is an object
			//observer is a function call
			} else if($observer[2] != $class) {
				//skip it
				continue;
			}
			
			//unset it
			unset($this->_observers[$i]);
		}
		
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
		Eden_Event_Error::get()->argument(1, 'string', 'null');
		
		if(is_null($event)) {
			$trace = debug_backtrace();
			$event = $trace[1]['function'];
		}
		
		//get the arguments
		$args = func_get_args();
		//shift out the event
		$event = array_shift($args);
		
		//as a courtesy lets shift in the object
		array_unshift($args, $this);
		
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Event Errors
 */
class Eden_Event_Error extends Eden_Error {
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
	public static function get($message = NULL, $code = 0) {
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