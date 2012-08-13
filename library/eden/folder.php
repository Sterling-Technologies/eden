<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/path.php';

/**
 * This is an abstract definition of common
 * folder manipulation listing and information 
 * per folder.
 *
 * @package    Eden
 * @category   path
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Folder extends Eden_Path {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
		
	/* Public Methods
	-------------------------------*/
	/**
	 * Creates a folder given the path
	 *
	 * @param int chmod
	 * @return this
	 */
	public function create($chmod = 0755) {
		//if chmod is not and integer or not between 0 and 777
		if(!is_int($chmod) || $chmod < 0 || $chmod > 777) {
			//throw an error
			Eden_Folder_Error::i(Eden_Folder_Exception::CHMOD_IS_INVALID)->trigger();
		}
		
		//if it's not a directory
		if(!is_dir($this->_data)) {
			//then make it
			mkdir($this->_data, $chmod, true);
		}
		
		return $this;
	}
	
	/**
	 * Returns a list of files given the path and optionally the pattern
	 *
	 * @param string regular expression
	 * @return array
	 */
	public function getFiles($regex = NULL, $recursive = false) {
		//argument test
		$error = Eden_Folder_Error::i()
			->argument(1, 'string', 'null')	//argument 1 must be a string
			->argument(2, 'bool');		//argument 2 must be a boolean
		
		$this->absolute();
		
		$files = array();
		
		if ($handle = opendir($this->_data)) {
			//for each file
			while (false !== ($file = readdir($handle))) {
				// If this is infact a file
				if(filetype($this->_data . '/' . $file) == 'file'
					&& (!$regex || preg_match($regex, $file))) {	
					//add it
					$files[] = Eden_File::i($this->_data . '/' . $file); 
				// recursive and this is infact a directory
				} else if($recursive && $file != '.' && $file != '..' 
					&& filetype($this->_data .'/'. $file) == 'dir') {
					$subfiles = self::i($this->_data.'/'.$file);
					$files = array_merge($files, $subfiles->getFiles($regex, $recursive));
				}
			}
			
			closedir($handle);
		}
		
		return $files;
	}
	
	/**
	 * Returns a list of folders given the path and optionally the regular expression
	 *
	 * @param string regular expression
	 * @return array
	 */
	public function getFolders($regex = NULL, $recursive = false) {
		//argument test
		Eden_Folder_Error::i()
			->argument(1, 'string', 'null')	//argument 1 must be a string
			->argument(2, 'bool');		//argument 2 must be a boolean
			
		$this->absolute();
		
		$folders = array();
		
		if($handle = opendir($this->_data)) {
			//walk the directory
			while (false !== ($folder = readdir($handle))) {
				// If this is infact a directory
				//and if it matches the regex
				if($folder != '.' && $folder != '..' 
				  	&& filetype($this->_data .'/'. $folder) == 'dir'
					&& (!$regex || preg_match($regex, $folder))) {
					
					//add it
					$folders[] = Eden_Folder::i($this->_data . '/' . $folder); 
					if($recursive) {
						$subfolders = Eden_Folder::i($this->_data.'/'.$folder);
						$folders = array_merge($folders, $subfolders->getFolders($regex, $recursive));
					}
					
				}
			}
			closedir($handle);
		}
		
		return $folders;
	}
		
	/**
	 * Returns the name of the directory.. just the name
	 *
	 * @return string the name
	 */
	public function getName() {
		$pathArray = $this->getArray();
		return array_pop($pathArray);
	}
	
	/**
	 * Checks to see if this 
	 * path is a real file
	 *
	 * @return bool
	 */
	public function isFile() {
		return file_exists($this->_data);
	}

	/**
	 * Checks to see if this 
	 * path is a real file
	 *
	 * @return bool
	 */
	public function isFolder($path = NULL) {
		Eden_Folder_Error::i()->argument(1, 'string', 'null');	//argument 1 must be a string
		
		//if path is string
		if(is_string($path)) {
			//return path appended
			return is_dir($this->_data.'/'.$path);
		}
		
		return is_dir($this->_data);
	}

	/**
	 * Removes a folder given the path
	 *
	 * @return this
	 */
	public function remove() {
		//get absolute path
		$path = $this->absolute();
		
		//if it's a directory
		if(is_dir($path)) {
			//remove it
			rmdir($path);
		}
		
		return $this;
	}
	
	/**
	 * Removes files given the path and optionally a regular expression
	 *
	 * @param string regular expression
	 * @return bool
	 */
	public function removeFiles($regex = NULL) {
		Eden_Folder_Error::i()->argument(1, 'string', 'null');	//argument 1 must be a string
		
		//get the files
		$files = $this->getFiles($regex);
		
		if(empty($files)) {
			return $this;
		}
		
		//walk the array
		foreach($files as $file) {
			//remove everything
			$file->remove();
		}
		
		return $this;
	}
	
	/**
	 * Removes a folder given the path and optionally the regular expression
	 *
	 * @param string regular expression
	 * @return bool
	 */
	public function removeFolders($regex = NULL) {
		Eden_Folder_Error::i()->argument(1, 'string', 'null');	//argument 1 must be a string
		
		$this->absolute();
		
		$folders = $this->getFolders($regex);
		
		if(empty($folders)) {
			return $this;
		}
		
		//walk directory
		foreach($folders as $folder) {
			//remove directory
			$folder->remove();
		}
		
		return $this;
	}
	
	/**
	 * Removes files and folder given a path
	 *
	 * @return this
	 */
	public function truncate() {
		$this->removeFolders();
		$this->removeFiles();
		
		return $this;
	}
		
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * Folder Errors
 */
class Eden_Folder_Error extends Eden_Error {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i($message = NULL, $code = 0) {
		$class = __CLASS__;
		return new $class($message, $code);
	}
	
    /* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}