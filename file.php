<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

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
	public function getPath() {
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
		$path = Eden_Path::get()->getAbsolute($this->_path);
		
		//if the pat is not a real file
		if(!is_file($path)) {
			//throw an exception
			throw new Eden_File_Exception(sprintf(Eden_File_Exception::PATH_IS_NOT_FILE, $path));
		}
		
		return include($path);
	}
	
	/**
	 * Returns the contents of a file given the path
	 *
	 * @param var default value if no file is found
	 * @return string
	 */
	public function getContent() {
		$path = Eden_Path::get()->getAbsolute($this->_path);
		
		//if the pat is not a real file
		if(!is_file($path)) {
			//throw an exception
			throw new Eden_File_Exception(sprintf(Eden_File_Exception::PATH_IS_NOT_FILE, $path));
		}
		
		return file_get_contents($path);
	}
	
	/**
	 * Returns the mime type of a file
	 *
	 * @return string
	 */
	public function getMimeType() {
		//mime_content_type seems to be deprecated in some versions of PHP
		//if it does exist then lets use it
		if(function_exists('mime_content_type')) {
			return mime_content_type((string)$this);
		}
		
		//if not then use the replacement funciton fileinfo
		//see: http://www.php.net/manual/en/function.finfo-file.php
		if(function_exists('finfo_open')) {
			$resource = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($resource, (string)$this);
			finfo_close($finfo);
			
			return $mime;
		}
		
		//ok we have to do this manually
		//get this file extension
		$extension = strtolower($this->getExtension());
		
		//get the list of mimetypes stored locally
		$types = include('mimetypes.php');
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
		return filesize(Eden_Path::get()->getAbsolute($this->_path));
	}
	
	/**
	 * Returns the last time file was modified in UNIX time
	 *
	 * @return int
	 */
	public function getTime() {
		return filemtime(Eden_Path::get()->getAbsolute($this->_path));
	}
	
	/**
	 * Creates a file and puts specified content into that file
	 *
	 * @param string content
	 * @return bool
	 */
	public function setContent($content) {
		//if the content is not a string
		if(!is_string($content)) {
			//throw an exception
			throw new Eden_File_Exception(sprintf(Eden_Exception::NOT_STRING, 2));
		}
		
		return file_put_contents($this->_path, $content);
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
		$path = Eden_Path::get()->getFormatted($this->_path);
		
		touch($path);
		
		return $this;
	}
	
	/**
	 * Removes a file
	 *
	 * @return bool
	 */
	public function remove() {
		$path = Eden_Path::get()->getAbsolute($this->_path);
		
		//if it's a file
		if(is_file($path)) {
			//remove it
			return unlink($path);
		}
		
		return false;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}