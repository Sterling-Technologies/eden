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
 * Handler for class autoloading. Many developers writing 
 * object-oriented applications create one PHP source file per-class 
 * definition. One of the biggest annoyances is having to write a 
 * long list of needed includes at the beginning of each script 
 * (one for each class). When a class is not found an Autoload
 * class is used to define how it is found. I have adopted Zend's
 * autoloading logic where a class name with underscores is the actual
 * location of that class if the underscores were replaced with foward
 * slashes. For example: Eden_Cache_Model is located at eve/cache/model.
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Loader extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_root = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __construct($eden = true) {
		if($eden) {
			$this->addRoot(realpath(dirname(__FILE__).'/..'));
		}
	}
	
	public function __call($name, $args) {
		//if the method name starts with a capital letter
		//most likely they want a class
		//since we are in the loader class
		//we might as well try to load it
		if(preg_match("/^[A-Z]/", $name)) {
			$this->load($name);
		}
		
		return parent::__call($name, $args);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Allows extra paths to search in before looking in the root first
	 *
	 * @param *string the path
	 * @return Eden_Autoload
	 */
	public function addRoot($path) {
		//add the absolute path
		array_unshift($this->_root, $path);
		
		return $this;
	}
	
	/**
	 * Logically includes a class if not included already.
	 *
	 * @param *string the class name
	 * @return bool
	 */
	public function handler($class) {
		if(!is_string($class)) {
			return false;
		}
		
		$path = str_replace(array('_', '\\'), '/', $class);
		$path = '/'.strtolower($path);
		$path = str_replace('//', '/', $path);
		
		foreach($this->_root as $root) {
			$file = $root.$path.'.php';
			
			if(file_exists($file) && require_once($file)) {
				//then we are done
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Logically includes a class if not included already.
	 *
	 * @param *string the class name
	 * @return this
	 */
	public function load($class) {
		if(!class_exists($class)) {
			$this->handler($class);
		}
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}