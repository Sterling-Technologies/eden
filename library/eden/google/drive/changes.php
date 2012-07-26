<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Changes Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Changes extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_DRIVE_CHANGES_LIST	= 'https://www.googleapis.com/drive/v2/changes';
	const URL_DRIVE_CHANGES_GET		= 'https://www.googleapis.com/drive/v2/changes/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_fileId	= NULL:
	 
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
	 * The ID for the file
	 *
	 * @param string
	 * @return this
	 */
	public function setFileId($fileId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_fileId = $fileId;
		
		return $this;
	}
	
	/**
	 * Gets a specific changes.
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_DRIVE_CHANGES_GET, $this->_fileId));
	}
	
	/**
	 * Lists the changes for a user.
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_DRIVE_CHANGES_LIST);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}