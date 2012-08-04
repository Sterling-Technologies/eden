<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google oauth
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Oauth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'https://accounts.google.com/o/oauth2/auth';
	const ACCESS_URL 	= 'https://accounts.google.com/o/oauth2/token';
	
	const AUTH_CODE		= 'authorization_code';
	const ONLINE		= 'online';
	const OFFLINE		= 'offline';
	const FORCE			= 'force';
	const AUTO			= 'auto';
	const TOKEN			= 'token';
	const CODE			= 'code';
	
	const FORM_HEADER	= 'application/x-www-form-urlencoded';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 		= NULL;
	protected $_secret 		= NULL;
	protected $_redirect 	= NULL;
	protected $_apiKey		= NULL;
	
	protected $_online 	= self::ONLINE;
	protected $_renew 	= self::AUTO;
	protected $_state 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __construct($key, $secret, $redirect, $apiKey) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string');			//Argument 4 must be a string

			
		$this->_key 		= $key; 
		$this->_secret 		= $secret;
		$this->_redirect 	= $redirect;
		$this->_apiKey		= $apiKey;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the access token 
	 * 
	 * @param string
	 * @return string
	 */
	public function getAccessToken($code) {
		Eden_Google_Error::i()->argument(1, 'string');	
			
		$query = array(
			'code' 				=> $code,
			'client_id'			=> $this->_key,
			'client_secret'		=> $this->_secret,
			'redirect_uri'		=> $this->_redirect,
			'grant_type'		=> self::AUTH_CODE);
		
		
		return Eden_Curl::i()
			->setUrl(self::ACCESS_URL)
			->verifyHost(false)
			->verifyPeer(false)
			->setPost(true)
			->setPostFields(http_build_query($query))
			->setTimeout(60)
			->getJsonResponse();
	}
	
	/**
	 * Returns the API KEY 
	 * 
	 * @return string
	 */
	public function getApiKey() {
		return $this->_apiKey;
	}
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param string
	 * @return string
	 */
	public function getLoginUrl($scope) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string', 'array');
		
		if(is_array($scope)) {
			$scope = implode(' ', $scope);
		}
		
		$query = array(
			'response_type'		=> self::CODE,
			'client_id'			=> $this->_key,
			'redirect_uri'		=> $this->_redirect,
			'scope'				=> $scope,
			'access_type'		=> $this->_online, 
			'state'				=> $this->_state,
			'approval_prompt'	=> $this->_renew);
		
		return self::REQUEST_URL.'?'.http_build_query($query);
	}
	
	/**
	 * Access token is sete to offline, long lived 
	 * 
	 * @return this
	 */
	public function setOffline() {
		$this->_online = self::OFFLINE;
		return $this;
	}
	
	/**
	 * Forces user to re approve of app
	 * 
	 * @return this
	 */
	public function setRenew() {
		$this->_renew = self::FORCE;
		return $this;
	}
	
	/**
	 * Sets thee state google will return back
	 * this could be anything you want
	 * 
	 * @param string
	 * @return this
	 */
	public function setState($state) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_state = $state;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}