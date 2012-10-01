<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Dropbox Files
 *
 * @package    Eden
 * @category   dropbox
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Dropbox_Files extends Eden_Dropbox_Base {
	/* Constants
	-------------------------------*/
	const DROPBOX_FILES_PUT 		= 'https://api-content.dropbox.com/1/files_put/%s/%s';
	const DROPBOX_FILES_SEARCH		= 'https://api.dropbox.com/1/search/%s/%s';
	const DROPBOX_FILES_GET			= 'https://api-content.dropbox.com/1/files/%s/%s';
	const DROPBOX_FILES_META		= 'https://api.dropbox.com/1/metadata/%s/%s';
	const DROPBOX_FILES_REV			= 'https://api.dropbox.com/1/revisions/%s/%s';
	const DROPBOX_FILES_RESTORE		= 'https://api.dropbox.com/1/revisions/%s/%s';
	const DROPBOX_FILES_SHARE		= 'https://api.dropbox.com/1/shares/%s/%s';
	const DROPBOX_FILES_MEDIA		= 'https://api.dropbox.com/1/media/%s/%s';
	const DROPBOX_FILES_COPY_REF	= 'https://api.dropbox.com/1/copy_ref/%s/%s';
	const DROPBOX_FILES_THUMBNAIL	= 'https://api-content.dropbox.com/1/thumbnails/%s/%s';
	
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
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
	 * Returns metadata for all files and folders whose filename contains the given 
	 * search string as a substring.
	 *
	 * @param string The search string
	 * @param string The path to the folder you want to search from.
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function search($query, $path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
			
		$this->_query['query'] = $query;
		
		return $this->_getResponse(sprintf(self::DROPBOX_FILES_SEARCH, $root, $path), $this->_query);
	}
	
	/**
	 * Uploads a file
	 *
	 * @param string The relative path on the server of the file to upload.
	 * @param string The location in the user's dropbox to place the file.
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function uploadFiles($file, $path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		$this->_query['file'] = '@'.$file;
		
		return $this->_upload(sprintf(self::DROPBOX_FILES_PUT, $root, $path), $this->_query);
	}
	
	/**
	 * Downloads a file. 
	 *
	 * @param stringThe path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function downloadFiles($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::DROPBOX_FILES_GET, $root, $path));
	}
	
	/**
	 * Retrieves file and folder metadata.
	 *
	 * @param stringThe path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function getMetaData($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::DROPBOX_FILES_META, $root, $path));
	}
	
	/**
	 * Obtains metadata for the previous revisions of a file.
	 *
	 * @param string The path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function getRevisions($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::DROPBOX_FILES_REV, $root, $path));
	}
	
	/**
	 * Restores a file path to a previous revision.
	 *
	 * @param string The revision of the file to restore.
	 * @param string The path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function restore($reviseion, $path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		$this->_query['rev'] = $revision; 
		
		return $this->_post(sprintf(self::DROPBOX_FILES_RESTORE, $root, $path), $this->_query);
	}
	
	/**
	 * Creates and returns a Dropbox link to files or folders users can use to view
	 * a preview of the file in a web browser.
	 *
	 * @param string The path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function share($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_post(sprintf(self::DROPBOX_FILES_SHARE, $root, $path));
	}
	
	/**
	 * Returns a link directly to a file.
	 *
	 * @param string The path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function media($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_post(sprintf(self::DROPBOX_FILES_MEDIA, $root, $path));
	}
	
	/**
	 * Creates and returns a copy_ref to a file. This reference string can be used to copy that 
	 * file to another user's Dropbox by passing it in as the from_copy_ref parameter 
	 * on file operation copyFile().
	 *
	 * @param string The path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function createReference($path, $root = 'dropbox') {
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::DROPBOX_FILES_COPY_REF, $root, $path));
	}
	
	/**
	 * Gets a thumbnail for an image
	 *
	 * @param string The path to the folder
	 * @param string The root relative to which path is specified. 
	 * @return array
	 */
	public function getThumbnail($path, $root = 'dropbox') { 
		//argument test
		Eden_Dropbox_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::DROPBOX_FILES_THUMBNAIL, $root, $path), $this->_query);
	}
	
	/**
	 * Set image format to be return in thumbnail
	 *
	 * @param string jpeg (default) or png
	 * @return array
	 */
	public function setFormat($format) {
		//Argument 1 must be a string
		Eden_Dropbox_Error::i()->argument(1, 'string');
		$this->_query['format'] = $format;
		
		return $this;
	}
	
	/**
	 * Set image Size: xs = 32x32, s = 64x64, m = 128x128, l = 640x480,
	 * xl = 1024x768
	 *
	 * @param string 
	 * @return array
	 */
	public function setSize($size) {
		//Argument 1 must be a string
		Eden_Dropbox_Error::i()->argument(1, 'string');
		$this->_query['size'] = $size;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}