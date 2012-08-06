<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google contacts data
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Contacts_Data extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CONTACTS_LIST	= 'https://www.google.com/m8/feeds/contacts/%s/full';
	const URL_CONTACTS_GET	= 'https://www.google.com/m8/feeds/contacts/%s/full/%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userEmail	= 'default';
	protected $_version		= '3.0';
	protected $_contactId	= NULL;
	protected $_givenName	= NULL;
	protected $_familyName	= NULL;
	protected $_fullName	= NULL;
	protected $_phoneNumber	= NULL;
	protected $_city		= NULL;
	protected $_street		= NULL;
	protected $_region		= NULL;
	protected $_postCode	= NULL;
	protected $_country		= NULL;
	protected $_notes		= NULL;
	protected $_email		= NULL;
	protected $_etag		= NULL;
	
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
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setEmail($email) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_email = $email;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setGivenName($givenName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_givenName = $givenName;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setFamilyName($familyName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_familyName = $familyName;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setPhoneNumber($phoneNumber) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_phoneNumber = $phoneNumber;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setCity($city) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_city = $city;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setStreet($street) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_street = $street;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setRegion($region) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_region = $region;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setPostCode($postCode) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_postCode = $postCode;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setCountry($country) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_country = $country;
		
		return $this;
	}
	
	/**
	 * Set user email
	 *
	 * @param string
	 * @return this
	 */
	public function setNotes($notes) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_notes = $notes;
		
		return $this;
	}
	
	/**
	 * Set user email
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
	 * Retrieve all of a user's contacts
	 *
	 * return array
	 */
	public function getList() {
		//populate fields
		$query = array(
			self::VERSION 	=> $this->_version,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_LIST, $this->_userEmail), $query);
	}  
	
	/**
	 * Retrieve a single contact
	 *
	 * return array
	 */
	public function getSpecific() {
		//populate fields
		$query = array(
			self::VERSION 	=> $this->_version,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_GET, $this->_userEmail, $this->_contactId), $query);
	}
	
	/**
	 * Creates a contacts.
	 *
	 * @return array
	 */
	public function create() {
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::GIVEN_NAME, $this->_givenName)
			->set(self::FAMILY_NAME, $this->_familyName)
			->set(self::PHONE_NUMBER, $this->_phoneNumber)
			->set(self::CITY, $this->_city)
			->set(self::STREET, $this->_street)
			->set(self::POST_CODE, $this->_postCode)
			->set(self::COUNTRY, $this->_country)
			->set(self::NOTES, $this->_notes)
			->set(self::EMAIL, $this->_email)
			->parsePHP(dirname(__FILE__).'/template/addcontacts.php');
			
		return $this->_post(sprintf(self::URL_CONTACTS_LIST, $this->_userEmail), $query);
	}
	
	/**
	 * Delete a contact
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CONTACTS_GET, $this->_userEmail, $this->_contactId), true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}