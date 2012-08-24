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
 * Used to inspect classes and result sets
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Debug extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_scope 	= NULL;
	protected $_name	= NULL;
	
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
		
		//set temp variables
		$name 	= $this->_name;
		$scope 	= $this->_scope;
		
		//reset globals
		$this->_name 	= NULL;
		$this->_scope 	= NULL;
		
		//if there's a property name
		if($name) {
			//output that
			$scope->debug($name);
			//and return the results
			return $results;
		}
		
		//at this point we should output the results
		$class = get_class($scope);
		
		$this->output(sprintf(self::DEBUG, $class.'->'.$name))
			->output($results);
		
		//and return the results
		return $results;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Hijacks the class and reports the results of the next
	 * method call
	 *
	 * @param object
	 * @param string
	 * @return this
	 */
	public function next($scope, $name = NULL) {
		Eden_Error::i()
			->argument(1, 'object')
			->argument(2, 'string', 'null');
			
		$this->_scope 	= $scope;
		$this->_name	= $name;
		
		return $this;
	}
	
	/**
	 * Outputs anything
	 *
	 * @param *variable any data
	 * @return Eden_Tool
	 */
	public function output($variable) {
		if($variable === true) {
			$variable = '*TRUE*';
		} else if($variable === false) {
			$variable = '*FALSE*';
		} else if(is_null($variable)) {
			$variable = '*NULL*';
		}
		
		echo '<pre>'.print_r($variable, true).'</pre>';
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