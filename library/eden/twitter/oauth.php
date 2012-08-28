<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter oauth
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Twitter_Oauth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 		= 'https://api.twitter.com/oauth/request_token'; 
	const AUTHORIZE_URL		= 'https://api.twitter.com/oauth/authorize';
	const ACCESS_URL		= 'https://api.twitter.com/oauth/access_token';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 	= NULL;
	protected $_secret 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key, $secret) {
		//argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_key 	= $key;
		$this->_secret 	= $secret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the access token 
	 * 
	 * @param string the response key; from the url usually
	 * @param string the request secret; from getRequestToken() usually
	 * @return string the response verifier; from the url usually
	 */
	public function getAccessToken($token, $secret, $verifier) {
		//argument test
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		return Eden_Oauth::i()
			->consumer(
				self::ACCESS_URL, 
				$this->_key, 
				$this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setToken($token, $secret)
			->setVerifier($verifier)
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param string the request key
	 * @param string
	 * @param boolean force user re-login
	 * @return string
	 */
	public function getLoginUrl($token, $redirect, $force_login = false) {
		//Argument tests
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'bool');  	//Argument 3 must be a boolean
		
		//build the query
		$query = array('oauth_token' => $token, 'oauth_callback' => $redirect, 'force_login' => (int)$force_login);
		$query = http_build_query($query);
		
		return self::AUTHORIZE_URL.'?'.$query;
	}
	
	/**
	 * Return a request token
	 * 
	 * @return string
	 */
	public function getRequestToken() {
		return Eden_Oauth::i()
			->consumer(
				self::REQUEST_URL, 
				$this->_key, 
				$this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}