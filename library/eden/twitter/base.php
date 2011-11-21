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
		Eden_Twitter_Error::get()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_key 	= $key;
		$this->_secret 	= $secret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param string
	 * @return string
	 */
	public function getLoginUrl($redirect) {
		//Argument 1 must be a string
		Eden_Google_Error::get()->argument(1, 'string');
		
		//get the token
		$token = Eden_Oauth::get()
			->getConsumer(self::REQUEST_URL, $this->_key, $this->_secret)
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
	
	/**
	 * Returns the access token 
	 * 
	 * @param string
	 * @param string
	 * @return string
	 */
	public function getAccessToken($token, $secret) {
		//argument test
		Eden_Google_Error::get()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		return Eden_Oauth::get()
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
		Eden_Google_Error::get()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getResponse($url, array $query = array()) {
		$rest = Eden_Oauth::get()
			->getConsumer($url, $this->_key, $this->_secret)
			->setHeaders(self::VERSION_HEADER, self::GDATA_VERSION)
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		$response = $rest->getJsonResponse($query);
			
		$this->_meta = $rest->getMeta();
		
		return $response;
	}
	
	/**
	 * Returns the token from the server
	 *
	 * @param array
	 * @return array
	 */
	protected function _post($url, $query = array()) {
		$headers = array();
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		
		$rest = Eden_Oauth::get()
			->getConsumer($url, $this->_key, $this->_secret)
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		//get the authorization parameters as an array
		$signature 		= $rest->getSignature();
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->_buildQuery($authorization);
		
		if(is_array($query)) {
			$query 	= $this->_buildQuery($query);
		}
		
		//determine the conector
		$connector = NULL;
		
		//if there is no question mark
		if(strpos($url, '?') === false) {
			$connector = '?';
		//if the redirect doesn't end with a question mark
		} else if(substr($url, -1) != '?') {
			$connector = '&';
		}
		
		//now add the authorization to the url
		$url .= $connector.$authorization;
		
		//set curl
		$curl = Eden_Curl::get()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}