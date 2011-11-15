<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Allows you to create JavaScript calls (not properties) in PHP
 *
 * @package    Eden
 * @category   javascript
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: model.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Javascript_Class extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_script = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __toString() {
		$output = NULL;
		foreach($this->_script as $script) {
			if(is_null($output) || substr($output, -1, 1) == ';') {
				$output .= $script;
			} else {
				$output .= '.'.$script;
			}
		}
		return $output;
	}
	
	public function __call($name, $args) {
		//for each argument
		foreach($args as $i => $arg) {
			//encode the argument in javascript
			$args[$i] = $this->___encode($arg);
		}
		
		//add to script
		$this->_script[] = $name.'('.implode(',', $args).')';
		
		return $this;
	}
	
	public function __get($name) {
		//add to script
		$this->_script[] = $name;
		
		return $this;
	}
	
	public function __set($name, $value) {
		//add to script
		$this->_script[] = $name.'='.$this->___encode($value).';';
		
		return $this;
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	protected function ___encode($value) {
		$type = Eden_Tool::get()->type($value);
		switch($type) {
			case 'array':
			case 'object':
				$jsonType = substr(json_encode($value), 0, 1);
				if($jsonType == '[') {
					$value = $this->____encodeArray($value);
				} else {
					$value = $this->____encodeObject($value);
				}
				break;
			default:
				$value = json_encode($value);
				break;
		}
		
		return $value;
	}
	
	protected function ____encodeObject($object) {
		$encoded = array();
		$class = __CLASS__;
		foreach($object as $key => $value) {
			$key = json_encode($key);
			if(!($value instanceof $class)) {
				$value = $this->___encode($value);
			}
			
			$encoded[] = $key.':'.$value;
		}
		
		return '{'.implode(',', $encoded).'}';
	}
	
	protected function ____encodeArray($array) {
		$encoded = array();
		$class = __CLASS__;
		foreach($array as $value) {
			if(!($value instanceof $class)) {
				$value = $this->___encode($value);
			}
			
			$encoded[] = $value;
		}
		
		return '['.implode(',', $encoded).']';
	}
	
	/* Private Methods
	-------------------------------*/
}