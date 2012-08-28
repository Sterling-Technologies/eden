<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google contacts groups
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Contacts_Groups extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CONTACTS_GROUPS_LIST	= 'https://www.google.com/m8/feeds/groups/%s/full';
	const URL_CONTACTS_GROUPS_GET	= 'https://www.google.com/m8/feeds/groups/%s/full/%s';
	
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
	 * Retrieve all group list
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
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_CONTACTS_LIST, $userEmail), $query);
	}
	
	/**
	 * Retrieve single group list
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($groudId, $userEmail = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//populate fields
		$query = array(
			self::VERSION 	=> self::VERSION_THREE,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_GROUPS_GET, $userEmail, $groupId), $query);
	}
	
	/**
	 * Retrieve all group list
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function create($title, $description, $info, $userEmail = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string')		//argument 3 must be a string
			->argument(4, 'string');	//argument 4 must be a string
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::TITLE, $title)
			->set(self::DESCRIPTION, $description)
			->set(self::INFO, $info)
			->parsePHP(dirname(__FILE__).'/template/addgroups.php');
			
		return $this->_post(sprintf(self::URL_CONTACTS_GROUPS_LIST, $userEmail), $query);
	}
	
	/**
	 * Delete a group
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($groupId, $userEmail = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_CONTACTS_GROUPS_GET, $userEmail, $groupId), true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}