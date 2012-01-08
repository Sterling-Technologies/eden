<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Twitter oauth
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Twitter_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'http://api.twitter.com/oauth/request_token';
	const AUTHORIZE_URL = 'http://api.twitter.com/oauth/authorize';
	const ACCESS_URL	= 'https://api.twitter.com/oauth/access_token';
	const SECRET_KEY 	= 'twitter_token_secret';
	
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
	public function getRequestToken() {
		return Eden_Oauth::i()
			->getConsumer(self::REQUEST_URL, $this->_key, $this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param array
	 * @param string
	 * @return string
	 */
	public function getLoginUrl($token, $redirect) {
		//Argument tests
		Eden_Twitter_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		//build the query
		$query = array('oauth_token' => $token, 'oauth_callback' => $redirect);
		$query = http_build_query($query);
		
		return self::AUTHORIZE_URL.'?'.$query;
	}
	
	/**
	 * Returns the access token 
	 * 
	 * @param string
	 * @param string
	 * @return string
	 */
	public function getAccessToken($token, $secret) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		return Eden_Oauth::i()
			->getConsumer(self::ACCESS_URL, $this->_key, $this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setToken($token, $secret)
			->setSignatureToHmacSha1()
			->getQueryResponse();
	}
	
	public function setAccessToken($token, $secret) {
		$this->_accessToken 	= $token;
		$this->_accessSecret 	= $secret;
		
		return $this;
	}
	
	
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getResponse($url, array $query = array()) {
		$rest = Eden_Oauth::i()
			->getConsumer($url, $this->_key, $this->_secret)
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		$response = $rest->getJsonResponse($query);
			
		$this->_meta = $rest->getMeta();
		
		return $response;
	}
	
	protected function _post($url, $query = array()) {
		$rest = Eden_Oauth::i()
			->getConsumer($url, $this->_key, $this->_secret)
			->setToken($this->_accessToken, $this->_accessSecret)
			->setMethodToPost()
			->useAuthorization()
			->setSignatureToHmacSha1();
		
		$response = $rest->getJsonResponse($query);
		
		$this->_meta = $rest->getMeta();
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}