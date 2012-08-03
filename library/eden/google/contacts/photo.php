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
	protected $_userEmail	= 'default';
	protected $_version		= '3.0';
	protected $_contactId	= NULL;
	
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
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setUserEmail($userEmail) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userEmail = $userEmail;
		
		return $this;
	}
	
	/**
	 * Set contact id
	 *
	 * @param string
	 * @return this
	 */
	public function setContactId($contactId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_contactId = $contactId;
		
		return $this;
	}
	
	/**
	 * Set etag
	 *
	 * @param string
	 * @return this
	 */
	public function setEtag($etag) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_etag = $etag;
		
		return $this;
	}
	
	/**
	 * Retrieve a single contact photo
	 *
	 * return array
	 */
	public function getImage() {
		//populate fields
		$query = array(
			self::VERSION 	=> $this->_version,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_GET_IMAGE, $this->_userEmail, $this->_contactId), $query);
	}
	
	/**
	 * Delete a photo
	 *
	 * return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CONTACTS_GET_IMAGE, $this->_userEmail, $this->_contactId), true);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}