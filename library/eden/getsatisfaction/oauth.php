<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction OAuth
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Getsatisfaction_Oauth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'http://getsatisfaction.com/api/request_token'; 
	const AUTHORIZE_URL = 'http://getsatisfaction.com/api/authorize';
	const ACCESS_URL 	= 'http://getsatisfaction.com/api/access_token';
	const SECRET_KEY 	= 'getsatisfaction_token_secret';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 	= NULL;
	protected $_secret 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($consumerKey, $consumerSecret) {
		//argument test
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_key 	= $consumerKey;
		$this->_secret 	= $consumerSecret;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Returns the access token 
	 * 
	 * @param string
	 * @param string
	 * @return string
	 */
	public function getAccess($token, $secret) {
		//argument test
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		return Eden_Oauth::i()
			->consumer(self::ACCESS_URL, $this->_key, $this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setToken($token, $secret)
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param string
	 * @return string
	 */
	public function getLoginUrl($redirect) {
		//Argument 1 must be a string
		Eden_Getsatisfaction_Error::i()->argument(1, 'string');
		
		//get the token
		$token = Eden_Oauth::i()
			->consumer(self::REQUEST_URL, $this->_key, $this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setSignatureToHmacSha1()
			->getQueryResponse();
		
		//to avoid any unesissary usage of persistent data,
		//we are going to attach the secret to the login URL
		$secret = self::SECRET_KEY.'='.$token['oauth_token_secret'];
		
		//determine the conector
		$connector = NULL;
		
		//if there is no question mark
		if(strpos($redirect, '?') === false) {
			$connector = '?';
		//if the redirect doesn't end with a question mark
		} else if(substr($redirect, -1) != '?') {
			$connector = '&';
		}
		
		//now add the secret to the redirect
		$redirect .= $connector.$secret;
		
		//build the query
		$query = array(
			'oauth_token' 		=> $token['oauth_token'],
			'oauth_callback' 	=> $redirect);
		
		$query = http_build_query($query);
		return self::AUTHORIZE_URL.'?'.$query;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}