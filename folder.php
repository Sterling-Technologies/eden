<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * This is an abstract definition of common
 * folder manipulation listing and information 
 * per folder.
 *
 * @package    Eden
 * @category   path
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: abstract.php 1 2010-01-02 23:06:36Z blanquera $
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
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/	
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
			throw new Eden_Folder_Error(Eden_Folder_Exception::CHMOD_IS_INVALID);
		}
		
		//if it's not a directory
		if(!is_dir($this->_path)) {
			//then make it
			mkdir($this->_path, $chmod, true);
		}
		
		return $this;
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
	 * Removes files and folder given a path
	 *
	 * @return this
	 */
	public function truncate() {
		$this->removeFolders();
		$this->removeFiles();
		
		return $this;
	}
	
	
	/**
	 * Returns the name of the directory.. just the name
	 *
	 * @return string the name
	 */
	public function getName() {
		return array_pop($this->getArray());
	}
	
	/**
	 * Returns a list of files given the path and optionally the pattern
	 *
	 * @param string regular expression
	 * @return array
	 */
	public function getFiles($regex = NULL, $recursive = false) {
		//argument test
		$error = Eden_Folder_Error::get()
			->argument(1, 'string', 'null')	//argument 1 must be a string
			->argument(2, 'bool');		//argument 2 must be a boolean
		
		$this->absolute();
		
		$files = array();
		
		if ($handle = opendir($this->_path)) {
			//for each file
			while (false !== ($file = readdir($handle))) {
				// If this is infact a file
				if(filetype($this->_path . '/' . $file) == 'file'
					&& (!$regex || preg_match($regex, $file))) {	
					//add it
					$files[] = Eden_File::get($this->_path . '/' . $file); 
				// recursive and this is infact a directory
				} else if($recursive && $file != '.' && $file != '..' 
					&& filetype($this->_path .'/'. $file) == 'dir') {
					$subfiles = self::get($this->_path.'/'.$file);
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
		Eden_Folder_Error::get()
			->argument(1, 'string', 'null')	//argument 1 must be a string
			->argument(2, 'bool');		//argument 2 must be a boolean
			
		$this->absolute();
		
		$folders = array();
		
		if($handle = opendir($this->_path)) {
			//walk the directory
			while (false !== ($folder = readdir($handle))) {
				// If this is infact a directory
				//and if it matches the regex
				if($folder != '.' && $folder != '..' 
				  	&& filetype($this->_path .'/'. $folder) == 'dir'
					&& (!$regex || preg_match($regex, $folder))) {
					
					//add it
					$folders[] = Eden_Folder::get($this->_path . '/' . $folder); 
					if($recursive) {
						$subfolders = Eden_Folder::get($this->_path.'/'.$folder);
						$folders = array_merge($folders, $subfolders->getFolders($regex, $recursive));
					}
					
				}
			}
			closedir($handle);
		}
		
		return $folders;
	}
	
	/**
	 * Removes a folder given the path and optionally the regular expression
	 *
	 * @param string regular expression
	 * @return bool
	 */
	public function removeFolders($regex = NULL) {
		Eden_Folder_Error::get()->argument(1, 'string', 'null');	//argument 1 must be a string
		
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
	 * Removes files given the path and optionally a regular expression
	 *
	 * @param string regular expression
	 * @return bool
	 */
	public function removeFiles($regex = NULL) {
		Eden_Folder_Error::get()->argument(1, 'string', 'null');	//argument 1 must be a string
		
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}