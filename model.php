<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/array.php';
require_once dirname(__FILE__).'/model/error.php';

/**
 *
 * @package    Eden
 * @category   registry
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Model extends Eden_Array {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __call($name, $args) {
		//if the method starts with get
		if(strpos($name, 'get') === 0) {
			$key = preg_replace("/([A-Z])/", "_$1", $name);
			//get rid of get_
			$key = strtolower(substr($key, 4));
			
			if(isset($this->_data[$key])) {
				return $this->_data[$key];
			}
		} else if (strpos($name, 'set') === 0) {
			$key = preg_replace("/([A-Z])/", "_$1", $name);
			//get rid of get_
			$key = strtolower(substr($key, 4));
			
			return $this->__set($key, $args[0]);
		}
		
		try {
			return parent::__call($name, $args);
		} catch(Eden_Type_Error $e) {
			throw new Eden_Model_Error($e->getMessage());
		}
	}
	
	public function __get($name) {
		if(isset($this->_data[$name])) {
			return $this->_data[$name];
		}
		
		return NULL;
	}
	
	public function __set($name, $value) {
		if(isset($this->_meta[$name])) {
			$this->_data[$name] = $value;
		}
		
		return $this;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets meta data about the given property
	 *
	 * @param string
	 * @param array
	 * @return this
	 */
	public function setMetaData($name, array $meta = array()) {
		//argument 1 must be a string
		Eden_Error_Validate::get()->argument(0, 'string');
		
		$this->_meta[$name] = $meta;
		
		if(!isset($this->_data[$name])) {
			$this->_data[$name] = NULL;
		}
		
		return $this;
	}
	
	/**
	 * Returns meta data
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getMetaData($name = NULL, $key = NULL) {
		//argument 1 must be a string or null
		Eden_Error_Validate::get()->argument(0, 'string', 'null');
		//argument 2 must be a string or null
		Eden_Error_Validate::get()->argument(1, 'string', 'null');
		
		if(!is_null($name) && isset($this->_meta[$name])) {		
			if(!is_null($key) && isset($this->_meta[$name][$key])) {
				return $this->_meta[$name][$key];
			}
			return $this->_meta[$name];
		}
		
		return $this->_meta;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}