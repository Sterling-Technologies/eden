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
	protected $_userEmail	= 'default';
	protected $_version		= '3.0';
	protected $_title		= NULL;
	protected $_description	= NULL;
	protected $_info		= NULL;
	protected $_groupId		= NULL;
	
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
	public function setGroupId($groupId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_groupId = $groupId;
		
		return $this;
	}
	
	/**
	 * Set group title
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_title = $title;
		
		return $this;
	}
	
	/**
	 * Set group description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_description = $description;
		
		return $this;
	}
	
	/**
	 * Set group description
	 *
	 * @param string
	 * @return this
	 */
	public function setInfo($info) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_info = $info;
		
		return $this;
	}
	
	/**
	 * Retrieve all group list
	 *
	 * return array
	 */
	public function getList() {
		//populate fields
		$query = array(
			self::VERSION 	=> $this->_version,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_CONTACTS_LIST, $this->_userEmail), $query);
	}
	
	/**
	 * Retrieve single group list
	 *
	 * return array
	 */
	public function getSpecific() {
		//populate fields
		$query = array(
			self::VERSION 	=> $this->_version,
			self::RESPONSE	=> self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_CONTACTS_GROUPS_GET, $this->_userEmail, $this->_groupId), $query);
	}
	
	/**
	 * Retrieve all group list
	 *
	 * return array
	 */
	public function create() {
		//make a xml template
		$query = Eden_Template::i()
			->set(self::TITLE, $this->_title)
			->set(self::DESCRIPTION, $this->_description)
			->set(self::INFO, $this->_info)
			->parsePHP(dirname(__FILE__).'/template/addgroups.php');
			
		return $this->_post(sprintf(self::URL_CONTACTS_GROUPS_LIST, $this->_userEmail), $query);
	}
	
	/**
	 * Delete a group
	 *
	 * return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CONTACTS_GROUPS_GET, $this->_userEmail, $this->_groupId), true);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}