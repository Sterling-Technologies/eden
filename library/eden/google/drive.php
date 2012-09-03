<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive API factory
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_DRIVE_ABOUT	= 'https://www.googleapis.com/drive/v2/about';
	const URL_DRIVE_APPS	= 'hhttps://www.googleapis.com/drive/v2/apps';
	
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
	 * Returns Google Drive Changes
	 *
	 * @return Eden_Google_Drive_Changes
	 */
	public function changes() {
		return Eden_Google_Drive_Changes::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Children
	 *
	 * @return Eden_Google_Drive_Children
	 */
	public function children() {
		return Eden_Google_Drive_Children::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Files
	 *
	 * @return Eden_Google_Drive_Files
	 */
	public function files() {
		return Eden_Google_Drive_Files::i($this->_token);
	}
	
	/**
	 * Gets the information about the 
	 * current user along with Drive API settings 
	 *
	 * @return array
	 */
	public function getAbout() {
		return $this->_getResponse(self::URL_DRIVE_ABOUT);
	}
	
	/**
	 * Lists a user's apps. 
	 *
	 * @return array
	 */
	public function getApps() {
		return $this->_getResponse(self::URL_DRIVE_APPS);
	}
	
	/**
	 * Returns Google Drive parent
	 *
	 * @return Eden_Google_Drive_Parent
	 */
	public function parents() {
		return Eden_Google_Drive_Parent::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Permissions
	 *
	 * @return Eden_Google_Drive_Permissions
	 */
	public function permissions() {
		return Eden_Google_Drive_Permissions::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Revisions
	 *
	 * @return Eden_Google_Drive_Revisions
	 */
	public function revisions() {
		return Eden_Google_Drive_Revisions::i($this->_token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}