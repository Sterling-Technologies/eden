<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google youtube constacts
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Contacts extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_CONTACTS		= 'https://gdata.youtube.com/feeds/api/users/%s/contacts';
	const URL_YOUTUBE_CONTACTS_GET	= 'https://gdata.youtube.com/feeds/api/users/%s/contacts/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId		= 'default';
	protected $_userName	= NULL;
	protected $_status		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_token 		= $token;
		$this->_developerId = $developerId; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * YouTube user ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserId($userId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/**
	 * Set user name or channel name.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserName($userName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userName = $userName;
		
		return $this;
	}
	
	/**
	 * Accept a contacts
	 *
	 * @return this
	 */
	public function accept() {
		$this->_status = 'accepted';
		
		return $this;
	}
	
	/**
	 * Reject a contacts
	 *
	 * @return this
	 */
	public function reject() {
		$this->_status = 'rejected';
		
		return $this;
	}
	
	/**
	 * Retrieve all user's contacts
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CONTACTS, $this->_userId), $query);
	}
	
	/**
	 * Retrieve specific user's contacts
	 *
	 * @return array
	 */
	public function getSpecific() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CONTACTS_GET, $this->_userId, $this->_userName), $query);
	}
	
	/**
	 * Delete a contact
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_CONTACTS_GET, $this->_userId, $this->_userName));
	}
	
	/**
	 * Add contacts
	 *
	 * @return array
	 */
	public function addContacts() {

		//make a xml template file
		$query = Eden_Template::i()
			->set(self::USER_NAME, $this->_userName)
			->parsePHP(dirname(__FILE__).'/template/activate.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_CONTACTS, $this->_userId), $query);
	}
	
	/**
	 * Update contacts
	 *
	 * @return array
	 */
	public function updateContacts() {
		
		//make a xml template file
		$query = Eden_Template::i()
			->set(self::STATUS, $this->_status)
			->parsePHP(dirname(__FILE__).'/template/updatecontacts.php');
			
		return $this->_put(sprintf(self::URL_YOUTUBE_CONTACTS_GET, $this->_userId, $this->_userName), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}