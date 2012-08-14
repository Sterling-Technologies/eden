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
	 * Returns Google Drive About
	 *
	 * @return Eden_Google_Drive_About
	 */
	public function about() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_About::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Apps
	 *
	 * @return Eden_Google_Drive_Apps
	 */
	public function apps() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Apps::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Changes
	 *
	 * @return Eden_Google_Drive_Changes
	 */
	public function changes() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Changes::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Children
	 *
	 * @return Eden_Google_Drive_Children
	 */
	public function children() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Children::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Files
	 *
	 * @return Eden_Google_Drive_Files
	 */
	public function files() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Files::i($this->_token);
	}
	
	/**
	 * Returns Google Drive parent
	 *
	 * @return Eden_Google_Drive_Parent
	 */
	public function parents() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Parent::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Permissions
	 *
	 * @return Eden_Google_Drive_Permissions
	 */
	public function permissions() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Permissions::i($this->_token);
	}
	
	/**
	 * Returns Google Drive Revisions
	 *
	 * @return Eden_Google_Drive_Revisions
	 */
	public function revisions() {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Drive_Revisions::i($this->_token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}