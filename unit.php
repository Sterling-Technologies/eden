<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  
 *
 * @package    Eden
 * @category   core
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Unit {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_last 		= array();
	protected $_start 		= 0;
	protected $_end 		= 0;
	protected $_report		= array();
	protected $_package		= 'main';
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get() {
		$class = __CLASS__;
		return new $class;
	}
	
	/* Magic
	-------------------------------*/
	public function __construct() {
		$this->_start = time();
	}
	
	public function __destruct() {
		$this->_end = time();
	}
	
	public function __call($name, $args) {
		if(method_exists($this, '_'.$name)) {
			$method 	= '_'.$name;
			$message 	= array_pop($args);
			$test 		= array(
				'name'		=> $name,
				'start' 	=> isset($this->_last['end']) ? $this->_last['end'] : $this->_start, 
				'message' 	=> $message);
			
			try {
				$test['pass'] = call_user_func_array(array(&$this, $method), $args);
			} catch(Exception $e) {
				$test['pass'] = false;
				$test['error'] = array(get_class($e), $e->getMessage());
			}
			
			$test['end'] 	= time();
			$test['trace'] 	= debug_backtrace();
			
			$this->_report[$this->_package][] = $this->_last = $test; 
			
			return $this;
		}
	}
	
	/* Public Methods
	-------------------------------*/
	public function setPackage($name) {
		$this->_package = $name;
		return $this;
	}
	
	public function getTotalTests($package = NULL) {
		if(isset($this->_report[$package])) {
			return count($this->_report[$package]);
		}
		
		$total = 0;
		foreach($this->_report as $package => $tests) {
			$total += $tests;
		}
		
		return $tests;
	}
	
	public function getPassFail($package = NULL) {
		$passFail = array(0, 0);
		if(isset($this->_report[$package])) {
			foreach($this->_report[$package] as $test) {
				if($test['pass']) {
					$passFail[0]++;
					continue;
				}
				
				$passFail[1]++;
			}
			
			return $passFail;
		}
		
		foreach($this->_report as $package => $tests) {
			$packagePassFail = $this->getPassFail($package);
			$passFail[0] += $packagePassFail[0];
			$passFail[1] += $packagePassFail[1];
		}
		
		return $passFail;
	}
	
	public function getReport() {
		return $this->_report;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _assertArrayHasKey($needle, array $haystack) {
		return array_key_exists($needle, $haystack);
	}
	
	protected function _assertClassHasAttribute($needle, $haystack) {
		return property_exists($needle, $haystack);
	}
	
	protected function _assertContains($needle, $haystack) {
		if(is_string($haystack)) {
			return strstr($haystack, $needle) !== false;
		}
		
		if(is_array($haystack)) {
			return in_array($needle, $haystack);
		}
		
		return false;
	}
	
	protected function _assertContainsOnly($type, array $haystack) {
		$method = 'is_'.$type;
		
		if(function_exists($method)) {
			foreach($haystack as $needle) {
				if(!$method($needle)) {
					return false;
				}
			}
			
			return true;
		}
		
		if(class_exists($type)) {
			foreach($haystack as $needle) {
				if(get_class($needle) != $type) {
					return false;
				}
			}
			
			return true;
		}
		
		return false;
	}
	
	protected function _assertCount($number, array $haystack) {
		return count($haystack) == $number;
	}
	
	protected function _assertEmpty($actual) {
		return empty($haystack);
	}
	
	protected function _assertEquals($expected, $actual) {
		return $expected === $actual;
	}
	
	protected function _assertFalse($condition) {
		return $condition === false;
	}
	
	protected function _assertGreaterThan($number, $actual) {
		return $number > $actual;
	}
	
	protected function _assertGreaterThanOrEqual($number, $actual) {
		return $number >= $actual;
	}
	
	protected function _assertInstanceOf($expected, $actual) {
		return $actual instanceof $expected;
	}
	
	protected function _assertInternalType($type, $actual) {
		$method = 'is_'.$type;
		
		if(function_exists($method)) {
			return !$method($actual);
		}
		
		if(class_exists($type)) {
			return get_class($actual) != $type;
		}
		
		return false;
	}
	
	protected function _assertLessThan($number, $actual) {
		return $number < $actual;
	}
	
	protected function _assertLessThanOrEqual($number, $actual) {
		return $number <= $actual;
	}
	
	protected function _assertNull($mixed) {
		return is_null($mixed);
	}
	
	protected function _assertRegExp($pattern, $string) {
		return preg_match($pattern, $string);
	}
	
	protected function _assertSame($expected, $actual) {
		return $expected == $actual;
	}
	
	protected function _assertStringEndsWith($suffix, $string) {
		return substr_compare($string, $suffix, -strlen($suffix), strlen($suffix)) === 0;
	}
	
	protected function _assertStringStartsWith($prefix, $string) {
		return strpos($string, $prefix) === 0;
	}
	
	protected function _assertTrue($condition) {
		return $condition === true;
	} 
	
	/* Private Methods
	-------------------------------*/
}