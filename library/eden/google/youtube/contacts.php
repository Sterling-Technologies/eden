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
	 * Retrieve all user's contacts
	 *
	 * @param string
	 * @return array
	 */
	public function getList($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CONTACTS, $userId), $this->_query);
	}
	
	/**
	 * Retrieve specific user's contacts
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($userName, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_CONTACTS_GET, $userId, $userName), $this->_query);
	}
	
	/**
	 * Delete a contact
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($userName, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_CONTACTS_GET, $userId, $userName));
	}
	
	/**
	 * Add contacts
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function addContacts($userName, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string

		//make a xml template file
		$query = Eden_Template::i()
			->set(self::USER_NAME, $userName)
			->parsePHP(dirname(__FILE__).'/template/activate.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_CONTACTS, $userId), $query);
	}
	
	/**
	 * Update contacts
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function updateContacts($userName, $status, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		//if the input value is not allowed
		if(!in_array($status, array('accepted', 'rejected'))) {
			//throw error
			Eden_Google_Error::i()
				->setMessage(Eden_Google_Error::INVALID_STATUS) 
				->addVariable($status)
				->trigger();
		}
		
		//make a xml template file
		$query = Eden_Template::i()
			->set(self::STATUS, $status)
			->parsePHP(dirname(__FILE__).'/template/updatecontacts.php');
			
		return $this->_put(sprintf(self::URL_YOUTUBE_CONTACTS_GET, $userId, $userName), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}