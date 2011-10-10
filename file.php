<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/path.php';
require_once dirname(__FILE__).'/file/error.php';

/**
 * General available methods for common file 
 * manipulations and information per file
 *
 * @package    Eden
 * @category   path
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: model.php 4 2010-01-06 04:41:07Z blanquera $
 */
class Eden_File extends Eden_Path {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_path = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function get($path) {
		return self::_getMultiple(__CLASS__, $path);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the file name
	 *
	 * @return string
	 */
	public function getName() {
		return basename($this->_path);
	}
	
	/**
	 * Returns the file path
	 *
	 * @return string
	 */
	public function getFolder() {
		return dirname($this->_path);
	}
	
	/**
	 * Returns the base file name with out the extension
	 *
	 * @return string
	 */
	public function getBase() {
		$pathInfo = pathinfo($this->_path);
		return $pathInfo['filename'];
	}
	
	/**
	 * Returns the base file name extension
	 *
	 * @return string
	 */
	public function getExtension() {
		$pathInfo = pathinfo($this->_path);
		
		if(!isset($pathInfo['extension'])) {
			return NULL;	
		}
		
		return $pathInfo['extension'];
	}
	
	/**
	 * Returns the executes the specified file and returns the final value
	 *
	 * @return *
	 */
	public function getData() {
		$this->absolute();
		
		return include($this->_path);
	}
	
	/**
	 * Returns the contents of a file given the path
	 *
	 * @param var default value if no file is found
	 * @return string
	 */
	public function getContent() {
		$this->absolute();
		
		//if the pat is not a real file
		if(!is_file($this->_path)) {
			//throw an exception
			Eden_File_Error::get()
				->setMessage(Eden_File_Exception::PATH_IS_NOT_FILE)
				->addVariable($this->_path)
				->trigger();
		}
		
		return file_get_contents($this->_path);
	}
	
	/**
	 * Returns the mime type of a file
	 *
	 * @return string
	 */
	public function getMime() {
		$this->absolute();
		
		//mime_content_type seems to be deprecated in some versions of PHP
		//if it does exist then lets use it
		if(function_exists('mime_content_type')) {
			return mime_content_type($this->_path);
		}
		
		//if not then use the replacement funciton fileinfo
		//see: http://www.php.net/manual/en/function.finfo-file.php
		if(function_exists('finfo_open')) {
			$resource = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($resource, $this->_path);
			finfo_close($finfo);
			
			return $mime;
		}
		
		//ok we have to do this manually
		//get this file extension
		$extension = strtolower($this->getExtension());
		
		//get the list of mimetypes stored locally
		$types = include('file/mimetypes.php');
		//if this extension exissts in the types
		if(isset($types[$extension])) {
			//return the mimetype
			return $types[$extension];
		}
		
		//return text/plain by default
		return $types['class'];
	}
	
	/**
	 * Returns the size of a file in bytes
	 *
	 * @return string
	 */
	public function getSize() {
		$this->absolute();
		
		return filesize($this->_path);
	}
	
	/**
	 * Returns the last time file was modified in UNIX time
	 *
	 * @return int
	 */
	public function getTime() {
		$this->absolute();
		
		return filemtime($this->_path);
	}
	
	/**
	 * Checks to see if this 
	 * path is a real file
	 *
	 * @return bool
	 */
	public function isFile() {
		return file_exists($this->_path);
	}
	
	/**
	 * Creates a file and puts specified content into that file
	 *
	 * @param string content
	 * @return bool
	 */
	public function setContent($content) {
		//argument 1 must be string
		Eden_File_Error::get()->argument(1, 'string');
		
		$this->absolute();
		
		file_put_contents($this->_path, $content);
		
		return $this;
	}
	
	/**
	 * Creates a php file and puts specified variable into that file
	 *
	 * @param string variable
	 * @return bool
	 */
	public function setData($variable) {
		return $this->setContent("<?php //-->\nreturn ".var_export($variable, true).";");
	}
	
	/**
	 * Touches a file (effectively creates the file if
	 * it doesn't exist and updates the date if it does)
	 *
	 * @return bool
	 */
	public function touch() {
		touch($this->_path);
		
		return $this;
	}
	
	/**
	 * Removes a file
	 *
	 * @return bool
	 */
	public function remove() {
		$this->absolute();
		
		//if it's a file
		if(is_file($this->_path)) {
			//remove it
			unlink($this->_path);
			
			return $this;
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}