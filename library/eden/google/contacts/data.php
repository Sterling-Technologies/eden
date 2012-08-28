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
	 * Retrieve all of a user's contacts
	 *
	 * @param string
	 * @return array
	 */
	public function getList($userEmail = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		//populate fields
		$query = array(
			self::VERSION 	=> self::VERSION_THREE,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_LIST, $userEmail), $query);
	}  
	
	/**
	 * Retrieve a single contact
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($contactId, $userEmail = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//populate fields
		$query = array(
			self::VERSION 	=> self::VERSION_THREE,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_GET, $userEmail, $contactId), $query);
	}
	
	/**
	 * Creates a contacts.
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function create($givenName, $familyName, $phoneNumber, $city, $street, $postCode, $country, $notes, $email, $userEmail = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string')		//argument 3 must be a string
			->argument(4, 'string')		//argument 4 must be a string
			->argument(5, 'string')		//argument 5 must be a string
			->argument(6, 'string')		//argument 6 must be a string
			->argument(7, 'string')		//argument 7 must be a string
			->argument(8, 'string')		//argument 8 must be a string
			->argument(9, 'string')		//argument 9 must be a string
			->argument(10, 'string');	//argument 10 must be a string
	
		//make a xml template
		$query = Eden_Template::i()
			->set(self::GIVEN_NAME, $givenName)
			->set(self::FAMILY_NAME, $familyName)
			->set(self::PHONE_NUMBER, $phoneNumber)
			->set(self::CITY, $city)
			->set(self::STREET, $street)
			->set(self::POST_CODE, $postCode)
			->set(self::COUNTRY, $country)
			->set(self::NOTES, $notes)
			->set(self::EMAIL, $email)
			->parsePHP(dirname(__FILE__).'/template/addcontacts.php');
			
		return $this->_post(sprintf(self::URL_CONTACTS_LIST, $userEmail), $query);
	}
	
	/**
	 * Delete a contact
	 *
	 * @return array
	 * @param string
	 * @param string
	 */
	public function delete($contactId, $userEmail = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_CONTACTS_GET, $userEmail, $contactId), true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}