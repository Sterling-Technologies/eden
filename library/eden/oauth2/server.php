<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Oauth2 server class
 *
 * @package    Eden
 * @category   server
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Oauth2_Server extends Eden_Oauth2_Abstract {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_responseType   	= self::CODE;
	protected $_accessType		= self::ONLINE;
	protected $_approvalPrompt 	= self::AUTO;
	protected $_grantType    	= self::AUTHORIZATION;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set auth for online access
	 *
	 * @return this
	 */
	public function forOnline() {
		$this->_accessType = self::ONLINE;
	
		return $this;
	}
	
	/**
	 * Set auth for offline access
	 * 
	 * @return this
	 */
	public function forOffline() { 
		$this->_accessType = self::OFFLINE;
	
		return $this;
	}
	
	/**
	 * Returns website login url
	 *
	 * @param string*
	 * @param string*
	 * @param string|null
	 * @return url
	 */
	public function getLoginUrl($url, $redirect, $scope = NULL) {
		//argument testing
		Eden_Oauth2_Error::i()
		  ->argument(1, 'string')					//argument 1 must be a string
		  ->argument(2, 'string')					//argument 2 must be a string
		  ->argument(3, 'string', 'array', 'null');	//argument 3 must be a string, array or null
	
		//populate fields
		$query = array(
		  self::RESPONSE_TYPE   => $this->_responseType,
		  self::CLIENT_ID     	=> $this->_client,
		  self::REDIRECT_URL    => $redirect,
		  self::ACCESS_TYPE     => $this->_accessType,
		  self::APROVAL			=> $this->_approvalPrompt);
	
		return $this->_getLoginUrl($url, $query, $scope);
	}
	
	/**
	 * Returns website login url
	 *
	 * @param string*
	 * @param string*
	 * @param string*
	 * @return array
	 */
	public function getToken($url, $code, $redirect) {
		//argument testing
		Eden_Oauth2_Error::i()
		  ->argument(1, 'string')	//argument 1 must be a string
		  ->argument(2, 'string')	//argument 2 must be a string
		  ->argument(3, 'string');	//argument 3 must be a string
	 	
		//populate fields
		$query = array(
			self::CODE			=> $code,
			self::CLIENT_ID		=> $this->_client,
			self::CLIENT_SECRET	=> $this->_secret,
			self::REDIRECT_URL	=> $redirect,
			self::GRANT_TYPE	=> $this->_grantType);
		
		//set curl	  
		return $this->Eden_Curl()
		  ->setUrl($url)
		  ->verifyHost()
		  ->verifyPeer()
		  ->setHeaders(self::TYPE, self::REQUEST)
		  ->setPostFields(http_build_query($query))
		  ->debug(true)
		  ->getJsonResponse();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
