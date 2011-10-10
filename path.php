<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
require_once dirname(__FILE__).'/class.php';
require_once dirname(__FILE__).'/path/error.php';

/**
 * General available methods for common pathing issues 
 *
 * @package    Eden
 * @subpackage path
 * @category   path
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: path.php 3 2010-01-06 01:16:54Z blanquera $
 */
class Eden_Path extends Eden_Class implements ArrayAccess {
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
	public static function get($path) {
		return self::_getMultiple(__CLASS__, $path);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($path) {
		//argument 1 must be a string
		Eden_Path_Error::get()->argument(1, 'string');
		$this->_path = $this->_format($path);
	}
	
	public function __toString() {
		return $this->_path;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Attempts to get the full absolute path 
	 * as described on the server. The path
	 * given must exist.
	 * 
	 * @param string|null root path
	 * @return this
	 */
	public function absolute($root = NULL) {
		//argument 1 must be a string or null
		Eden_Path_Error::get()->argument(1, 'string', 'null');
		
		//if path is a directory or file
		if(is_dir($this->_path) || is_file($this->_path)) {
			return $this;
		}
		
		//if root is null
		if(is_null($root)) {
			//assume the root is doc root
			$root = $_SERVER['DOCUMENT_ROOT'];
		}
		
		//get the absolute path
		$absolute = $this->_format($root).$this->_path;

		//if absolute is a directory or file
		if(is_dir($absolute) || is_file($absolute)) {
			$this->_path = $absolute;
			return $this;
		}
		
		//if we are here then it means that no path was found so we should throw an exception
		Eden_Path_Error::get()
			->setMessage(Eden_Path_Error::FULL_PATH_NOT_FOUND)
			->addVariable($this->_path)
			->addVariable($absolute)
			->trigger();
	}
	
	/**
	 * Adds a path to the existing one
	 * 
	 * @param string[,string..]
	 * @return this
	 */
	public function append($path) {
		//argument 1 must be a string
		$error = Eden_Path_Error::get()->argument(1, 'string');
		
		//each argument will be a path
		$paths = func_get_args();
		
		//for each path
		foreach($paths as $i => $path) {
			//check for type errors
			$error->argument($i + 1, $path, 'string');
			//add to path
			$this->_path .= $this->_format($path);
		}
		
		return $this;
	}
	
	/**
	 * Adds a path before the existing one
	 * 
	 * @param string[,string..]
	 * @return string
	 */
	public function prepend($path) {
		//argument 1 must be a string
		$error = Eden_Path_Error::get()->argument(1, 'string');
		
		//each argument will be a path
		$paths = func_get_args();
		
		//for each path
		foreach($paths as $i => $path) {
			//check for type errors
			$error->argument($i + 1, $path, 'string');
			//add to path
			$this->_path = $this->_format($path).$this-_path;
		}
		
		return $this;
	}
	
	/**
	 * Replaces the last path with this one
	 * 
	 * @param string
	 * @return string
	 */
	public function replace($path) {
		//argument 1 must be a string
		Eden_Path_Error::get()->argument(1, 'string');
		
		//get the path array
		$pathArray = $this->getArray();
		
		//pop out the last
		array_pop($pathArray);
		
		//push in the new
		$pathArray[] = $path;
		
		//assign back to path
		$this->_path = implode('/', $pathArray);
		
		return $this;
	}
	
	/**
	 * Returns the path array
	 * 
	 * @return array
	 */
	public function getArray() {
		return explode('/', $this->_path);
	}
	
	/**
	 * Sets data using the ArrayAccess interface
	 *
	 * @param number
	 * @param mixed
	 * @return void
	 */
	public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->append($value);
        } else if($offset == 'prepend') {
            $this->prepend($value);
        } else if($offset == 'replace') {
            $this->replace($value);
        } else {
			$pathArray = $this->getArray();
			if ($offset > 0 && $offset < count($pathArray)) {
				$pathArray[$offset] = $value;
				$this->_path = implode('/', $pathArray);
			}
		}
    }
	
	/**
	 * isset using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
    public function offsetExists($offset) {
        return in_array($offset, $this->getArray());
    }
    
	/**
	 * unsets using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetUnset($offset) {}
    
	/**
	 * returns data using the ArrayAccess interface
	 *
	 * @param number
	 * @return bool
	 */
	public function offsetGet($offset) {
		if(is_numeric($offset)) {
			$pathArray = $this->getArray();
			return isset($pathArray[$offset]) ? $pathArray[$offset] : NULL;	
		}
		
		return NULL;
    }
	
	/* Protected Methods
	-------------------------------*/
	protected function _format($path) {
		//replace back slash with forward
		$path = str_replace('\\', '/', $path);
		
		//replace double forward slash with 1 forward slash
		$path = str_replace('//', '/', $path);
		
		//if there is a last forward slash
		if(substr($path, -1, 1) == '/') {
			//remove it
			$path = substr($path, 0, -1);
		}
		
		//if the path does not start with a foward slash
		//and the path does not have a colon
		//(this is a test for windows)
		if(substr($path, 0, 1) != '/' && !preg_match("/^[A-Za-z]+\:/", $path)) {
			//it's safe to add a slash
			$path = '/'.$path;
		}
		
		return $path;
	}
	
	/* Private Methods
	-------------------------------*/
}