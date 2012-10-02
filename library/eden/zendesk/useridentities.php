<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk User Identities 
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_UserIdentities extends Eden_ZenDesk_Base {
	/* Constants
	-------------------------------*/
	const USER_IDENTITY_LIST		= 'https://%s.zendesk.com/api/v2/users/%s/identities.json';
	const USER_IDENTITY_GET			= 'https://%s.zendesk.com/api/v2/users/%s/identities/%s.json';
	const USER_IDENTITY_SET			= 'https://%s.zendesk.com/api/v2/users/%s/identities/%s/make_primary.json';
	const USER_IDENTITY_VERIFY		= 'https://%s.zendesk.com/api/v2/users/%s/identities/%s/verify.json';
	const USER_IDENTITY_REQUEST		= 'https://%s.zendesk.com/api/v2/users/%s/identities/%s/request_verification.json';
	
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
	 * Get list of user identities
	 *
	 * @param string|integer
	 * @return array
	 */
	public function getList($userId) {
		//argument 1 must be a string or integet
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');
		
		return $this->_getResponse(sprintf(self::USER_IDENTITY_LIST, $this->_subdomain, $userId));
	}
	
	
	/**
	 * Show a User Identity 
	 *
	 * @param string|integer
	 * @param string|integer 
	 * @return array
	 */
	public function getSpecific($userId, $identityId) {
		//argument test 
		Eden_ZenDesk_Error::i()
			->argument(1, 'string', 'int')			//argument 1 must be a string  or integer
			->argument(2, 'string', 'int');		//argument 2 must be a string  or integer
		
		return $this->_getResponse(sprintf(self::USER_IDENTITY_GET, $this->_subdomain, $userId, $identityId));
	}

	/**
	 * Add User Identity
	 *
	 * @param string|integer 
	 * @return array
	 */
	public function addIdentity($userId) {
		//argument 1 must be a string or integer
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');
		
		return $this->_post(sprintf(self::USER_IDENTITY_LIST, $this->_subdomain, $userId), $this->_query);
	}
	
	
	/**
	 * Update user identity
	 *
	 * @param string|integer
	 * @param string|integer 
	 * @return array
	 */
	public function updateidentity($userId, $identityId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string', 'int')		//argument 1 must be a string or integer
			->argument(1, 'string', 'int');		//argument 2 must be a string or integer	
			
		return $this->_put(sprintf(self::USER_IDENTITY_GET, $this->_subdomain, $userId, $identityId), $this->_query);
	}
	
	/**
	 * Make a User Identity the Primary
	 *
	 * @param string|integer
	 * @param string|integer 
	 * @return array
	 */
	public function setAsPrimary($userId, $identityId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string', 'int')		//argument 1 must be a string or integer
			->argument(1, 'string', 'int');		//argument 2 must be a string or integer	
			
		return $this->_put(sprintf(self::USER_IDENTITY_SET, $this->_subdomain, $userId, $identityId));
	}
	
	/**
	 * Verify a given User Identity
	 *
	 * @param string|integer
	 * @param string|integer 
	 * @return array
	 */
	public function verifyIdentity($userId, $identityId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string', 'int')		//argument 1 must be a string or integer
			->argument(1, 'string', 'int');		//argument 2 must be a string or integer	
			
		return $this->_put(sprintf(self::USER_IDENTITY_VERIFY, $this->_subdomain, $userId, $identityId));
	}
	
	/**
	 * Request User Verification
	 *
	 * @param string|integer
	 * @param string|integer 
	 * @return array
	 */
	public function requestVerification($userId, $identityId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string', 'int')		//argument 1 must be a string or integer
			->argument(1, 'string', 'int');		//argument 2 must be a string or integer	
			
		return $this->_put(sprintf(self::USER_IDENTITY_REQUEST, $this->_subdomain, $userId, $identityId));
	}
	
	
	/**
	 * Delete User Identity
	 *
	 * @param string|integer
	 * @param string|integer 
	 * @return array
	 */
	public function deleteIdentity($userId, $identityId) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string', 'int')		//argument 1 must be a string or integer
			->argument(1, 'string', 'int');		//argument 2 must be a string or integer	
			
		return $this->_delete(sprintf(self::USER_IDENTITY_GET, $this->_subdomain, $userId, $identityId));
	}
	
	/**
	 * Is true of the identity has gone through verification
	 *
	 * @return this
	 */
	public function verified() {
		$this->_query['identities']['verified'] = true;
		
		return $this;
	}
	
	/**
	 * Is true of the primary identity of the user
	 *
	 * @return this
	 */
	public function primary() {
		$this->_query['identities']['primary'] = true;
		
		return $this;
	}
	
	/**
	 * Set email account
	 *
	 * @param string
	 * @return this
	 */
	public function setEmail($email) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['identity']['type'] = 'email';
		$this->_query['identity']['value'] = $email;
		
		return $this;
	}
	
	/**
	 * Set twitter account
	 *
	 * @param string
	 * @return this
	 */
	public function setTwitter($screenName) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['identity']['type']	=  'twitter'; 
		$this->_query['identity']['value']	= $screenName;
		
		return $this;
	}
	
	/**
	 * Set facebook account
	 *
	 * @param string
	 * @return this
	 */
	public function setFacebook($facebookId) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['identity']['type']	= 'facebook';
		$this->_query['identity']['value']	= $facebookId;
		
		return $this;
	}
	
	/**
	 * Set google account
	 *
	 * @param string
	 * @return this
	 */
	public function setGoogle($email) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['identity']['type'] 	= 'google'; 
		$this->_query['identity']['value'] 	= $email;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}