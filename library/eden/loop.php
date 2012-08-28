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
 * Loops through returned result sets
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Loop extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_scope 		= NULL;
	protected $_callback	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __call($name, $args) {
		//if the scope is null
		if(is_null($this->_scope)) {
			//just call the parent
			return parent::__call($name, $args);
		}
		
		//get the results from the method call
		$results = $this->_getResults($name, $args);
		
		//lets make sure this is loopable
		$loopable = is_scalar($results) ? array($results) : $results;
		
		//at this point we should loop through the results
		foreach($loopable as $key => $value) {
			call_user_func($this->_callback, $key, $value);
		}
		
		//and return the results
		return $results;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Hijacks the class and loop through the results
	 *
	 * @param object
	 * @param callable
	 * @return this
	 */
	public function iterate($scope, $callback) {
		Eden_Error::i()
			->argument(1, 'object')
			->argument(2, 'callable');
			
		$this->_scope 		= $scope;
		$this->_callback	= $callback;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getResults($name, $args) {
		if(method_exists($this->_scope, $name)) {
			return call_user_func_array(array($this->_scope, $name), $args);
		}
			
		return $this->_scope->__call($name, $args);
	}
	
	/* Private Methods
	-------------------------------*/
}