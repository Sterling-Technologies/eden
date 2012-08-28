<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Contacts Photos
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Contacts_Photo extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CONTACTS_GET_IMAGE = 'https://www.google.com/m8/feeds/photos/media/%s/%s';
	
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
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Retrieve a single contact photo
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getImage($contactId, $userEmail = self::DAFAULT) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//populate fields
		$query = array(
			self::VERSION 	=> self::VERSION_THREE,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_GET_IMAGE, $userEmail, $contactId), $query);
	}
	
	/**
	 * Delete a photo
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($contactId, $userEmail = self::DAFAULT) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_CONTACTS_GET_IMAGE, $userEmail, contactId), true);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}