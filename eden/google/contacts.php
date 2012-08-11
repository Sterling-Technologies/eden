<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Contacts
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Google_Contacts extends Eden_Google_Base {
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
	 * Returns Google contacts batch
	 *
	 * @return Eden_Google_Contacts_Batch
	 */
	public function batch() {
			
		return Eden_Google_Contacts_Batch::i($this->_token);
	}
	
	/**
	 * Returns Google contacts data
	 *
	 * @return Eden_Google_Contacts_Batch
	 */
	public function data() {
			
		return Eden_Google_Contacts_Data::i($this->_token);
	}
	
	/**
	 * Returns Google contacts groups
	 *
	 * @return Eden_Google_Contacts_Groups
	 */
	public function groups() {
			
		return Eden_Google_Contacts_Groups::i($this->_token);
	}
	
	/**
	 * Returns Google contacts photo
	 *
	 * @return Eden_Google_Contacts_Photo
	 */
	public function photo() {
			
		return Eden_Google_Contacts_Photo::i($this->_token);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}