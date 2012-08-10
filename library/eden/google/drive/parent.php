<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Parent Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Parent extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_PARENT_LIST	= 'https://www.googleapis.com/drive/v2/files/%s/parents';
	const URL_PARENT_GET	= 'https://www.googleapis.com/drive/v2/files/%s/parents/%s';
	
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
	 * Removes a parent from a file.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($fileId, $parentId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_PARENT_GET, $fileId, $parentId));
	}
	
	/**
	 * A link to the child.
	 *
	 * @param string
	 * @return this
	 */
	public function setChildLink($childLink) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_childLink = $childLink;
		
		return $this;
	}
	
	/**
	 * Lists a file's parents. 
	 *
	 * @param string
	 * @return array
	 */
	public function getList($fileId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_PARENT_LIST, $fileId));
	}
	
	/**
	 * Gets a specific parent reference.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($fileId, $parentId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::URL_PARENT_GET, $fileId, $parentId));
	}
	
	/**
	 * Adds a parent folder for a file.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function insert($fileId, $parentId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(self::ID => $parentId);
		
		return $this->_post(sprintf(self::URL_PARENT_LIST, $fileId), $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}