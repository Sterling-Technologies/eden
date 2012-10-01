<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Dropbox File operations
 *
 * @package    Eden
 * @category   dropbox
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Dropbox_FileOperations extends Eden_Dropbox_Base {
	/* Constants
	-------------------------------*/
	const DROPBOX_CREATE_FOLDER = 'https://api.dropbox.com/1/fileops/create_folder';
	const DROPBOX_COPY 			= 'https://api.dropbox.com/1/fileops/copy';
	const DROPBOX_MOVE 			= 'https://api.dropbox.com/1/fileops/move';
	const DROPBOX_DELETE 		= 'https://api.dropbox.com/1/fileops/delete';
	
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
	 * Creates a folder.
	 *
	 * @param string The path to the folder you want to search from.
	 * @param string The path to the new folder to create relative to root.
	 * @return array
	 */
	public function createFolder($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_query['root'] = $root;
		$this->_query['path'] = $path;
		
		return $this->_post(self::DROPBOX_CREATE_FOLDER, $this->_query);
	}
	
	/**
	 * Copies a file or folder to a new location.
	 *
	 * @param string Specifies the destination path, including the new name for the file or folder, relative to root.
	 * @param string The path to the new folder to create relative to root.
	 * @return array
	 */
	public function copyFile($toPath , $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_query['root'] 		= $root;
		$this->_query['to_path']	= $toPath;
		
		return $this->_post(self::DROPBOX_COPY, $this->_query);
	}
	
	/**
	 * Moves a file or folder to a new location.
	 *
	 * @param string Specifies the destination path, including the new name for the file or folder, relative to root.
	 * @param string Specifies the file or folder to be moved from relative to root.
	 * @param string The root relative to which from_path and to_path are specified.
	 * @return array
	 */
	public function moveFile($toPath, $fromPath, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
			
		$this->_query['root'] 		= $root;
		$this->_query['to_path']	= $toPath;
		$this->_query['from_path']	= $fromPath;
		
		return $this->_post(self::DROPBOX_MOVE, $this->_query);
	}
	
	/**
	 * Deletes a file or folder.
	 *
	 * @param string The path to the file or folder to be deleted.
	 * @param string The root relative to which from_path and to_path are specified.
	 * @return array
	 */
	public function deleteFile($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_query['root'] 	= $root;
		$this->_query['path']	= $path;
		
		return $this->_post(self::DROPBOX_DELETE, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}