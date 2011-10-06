<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require dirname(__FILE__).'/class.php';

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
 * @subpackage autoload
 * @category   framework
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: autoload.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct() {
		$this->addRoot(realpath(dirname(__FILE__).'/..'));
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
	public function autoload($class) {
		if(!is_string($class)) {
			return false;
		}
		
		$path = '/'.strtolower(str_replace('_', '/', $class));
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
	 * Based on the path, this will return a guess
	 * of what the class name is in this file
	 *
	 * @param *string path
	 * @return string|null class name
	 */
	public function guessClassName($file) {
		$file = Eden_Path::get()->getFormatted($file);
		
		foreach($this->_root as $root) {
			$path = str_replace('.php', '', str_replace($root, '', $file));
			$class = trim(str_replace('/', ' ', $path));
			$class = str_replace(' ', '_', ucwords($class));
			if(class_exists($class)) {
				return $class;
			}
		}
		
		return NULL;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}