<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Children Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Children extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CHILDREN_LIST		= 'https://www.googleapis.com/drive/v2/files/%s/children';
	const URL_CHILDREN_SPECIFIC	= 'https://www.googleapis.com/drive/v2/files/%s/children/%s';
	
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
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Removes a child from a folder
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($folderId, $childId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argunemt 1 must be a string
			->argument(2, 'string');	//argunemt 2 must be a string
		
		return $this->_delete(sprintf(self::URL_CHILDREN_SPECIFIC, $fileId, $childId));
	}
	
	/**
	 * Returns list of folder's children
	 *
	 * @param string
	 * @return array
	 */
	public function getList($folderId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_CHANGES_LIST, $folderId));
	}
	
	/**
	 * Gets a specific child reference
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($folderId, $childId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argunemt 1 must be a string
			->argument(2, 'string');	//argunemt 2 must be a string
		
		return $this->_getResponse(sprintf(self::URL_CHILDREN_SPECIFIC, $fileId, $childId));
	}
	
	/**
	 * Inserts a file into a folder
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function insert($folderId, $childId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argunemt 1 must be a string
			->argument(2, 'string');	//argunemt 2 must be a string
			
		//populate fields
		$query = array(self::ID => $childId);
		
		return $this->_post(sprintf(self::URL_CHANGES_LIST, $folderId), $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}