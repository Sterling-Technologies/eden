<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk Users 
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_Users extends Eden_ZenDesk_Base {
	/* Constants
	-------------------------------*/
	const USERS_LIST		= 'https://%s.zendesk.com/api/v2/users.json';
	const USERS_SPECIFIC	= 'https://%s.zendesk.com/api/v2/users/%s.json';
	const USERS_SEARCH		= 'https://%s.zendesk.com/api/v2/users/search.json';
	const USERS_SHOW		= 'https://%s.zendesk.com/api/v2/users/me.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Get all users list
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::USERS_LIST, $this->_subdomain));
	}
	
	/**
	 * Get specific users 
	 *
	 * @param string
	 * @return array
	 */
	public function getSpecific($userId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');	
		
		return $this->_getResponse(sprintf(self::USERS_SPECIFIC, $this->_subdomain, $userId));
	}
	
	/**
	 * Create users 
	 *
	 * @param string
	 * @param string
	 * @param string|null
	 * @return array
	 */
	public function createUser($name, $email, $role = NULL) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')				//argument 1 must be a string
			->argument(2, 'string')				//argument 2 must be a string
			->argument(3, 'string', 'null');	//argument 3 must be a string or null
		
		$this->_query['user']['name'] 	= $name;
		$this->_query['user']['email'] 	= $email;
		$this->_query['user']['role'] 	= $role;
		
		return $this->_post(sprintf(self::USERS_LIST, $this->_subdomain), $this->_query);
	}
	
	/**
	 * Create users 
	 *
	 * @param string
	 * @return array
	 */
	public function updateUser($userId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		return $this->_put(sprintf(self::USERS_SPECIFIC, $this->_subdomain, $userId), $this->_query);
	}
	
	/**
	 * Suspend a users 
	 *
	 * @param string
	 * @return array
	 */
	public function suspendUser($userId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		return $this->_put(sprintf(self::USERS_SPECIFIC, $this->_subdomain, $userId), $this->_query);
	} 
	
	/**
	 * Delete user
	 *
	 * @param string
	 * @return array
	 */
	public function deleteUser($userId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		return $this->_delete(sprintf(self::USERS_SPECIFIC, $this->_subdomain, $userId), $this->_query);
	}
	
	/**
	 * Search user
	 *
	 * @param string
	 * @return array
	 */
	public function search($query) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['query'] = $query;
		
		return $this->_getResponse(sprintf(self::USERS_SEARCH, $this->_subdomain), $this->_query);
	}
	
	/**
	 * Show the Currently Authenticated User
	 *
	 * @return array
	 */
	public function getUser() {
		
		return $this->_getResponse(sprintf(self::USERS_SHOW, $this->_subdomain));
	}
	
	/**
	 * Set Alias, Agents can have an alias that is displayed to end-users
	 *
	 * @param string
	 * @return array
	 */
	public function setAlias($alias) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['user']['alias'] = $alias;
		
		return $this;
	}
	
	/**
	 * Zendesk has verified that this user is who he says he is
	 *
	 * @param string
	 * @return this
	 */
	public function verified() {
		$this->_query['user']['verified'] = 'true';
		
		return $this;
	}
	
	/**
	 * The primary phone number of this user
	 *
	 * @param string
	 * @return this
	 */
	public function setPhone($phone) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['user']['phone'] = $phone;
		
		return $this;
	}
	
	/**
	 * The signature of this user. Only agents and admins can have signatures
	 *
	 * @param string
	 * @return this
	 */
	public function setSignature($signature) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['user']['signature'] = $signature;
		
		return $this;
	}
	
	/**
	 * In this field you can store any details about the user. e.g. the address
	 *
	 * @param string
	 * @return this
	 */
	public function setDetails($details) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['user']['details'] = $details;
		
		return $this;
	}
	
	/**
	 * In this field you can store any notes you have about the user
	 *
	 * @param string
	 * @return this
	 */
	public function setNotes($notes) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['user']['notes'] = $notes;
		
		return $this;
	}
	
	/**
	 * Set picture for a user, use the attachement uploadFile() to get
	 * upload token
	 *
	 * @param string 
	 * @return this
	 */
	public function setPicture($uploadToken) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		$this->_query['user']['photo'] = $uploadToken;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}