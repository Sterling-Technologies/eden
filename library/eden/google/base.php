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
class Eden_Google_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'https://www.google.com/accounts/OAuthGetRequestToken';
	const ACCESS_URL	= 'https://www.google.com/accounts/OAuthGetAccessToken';
	const AUTHORIZE_URL = 'https://www.google.com/accounts/OAuthAuthorizeToken';
	
	const SECRET_KEY 	= 'google_token_secret';
	
	const DEFAULT_USER 		= 'default';
	const VERSION_HEADER 	= 'GData-Version';
	const GDATA_VERSION 	= 2;
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 	= NULL;
	protected $_secret 	= NULL;
	protected $_scope	= NULL;
	
	protected $_meta			= array();
	
	protected $_accessToken		= NULL; 
	protected $_accessSecret	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
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
		Eden_Google_Error::i()->argument(1, 'string');
		
		//get the token
		$token = Eden_Oauth::i()
			->getConsumer(self::REQUEST_URL, $this->_key, $this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setSignatureToHmacSha1()
			->getQueryResponse(array('scope' => $this->_scope));
		
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
		Eden_Google_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		return Eden_Oauth::i()
			->getConsumer(self::ACCESS_URL, $this->_key, $this->_secret)
			->useAuthorization()
			->setMethodToPost()
			->setToken($token, $secret)
			->setSignatureToHmacSha1()
			->getQueryResponse(array('scope' => $this->_scope));
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
		$query['alt'] = 'jsonc';
		
		$rest = Eden_Oauth::i()
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
		$headers[] = self::VERSION_HEADER.': '.self::GDATA_VERSION;
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		$headers[] = 'Content-Type: application/json';
		
		$rest = Eden_Oauth::i()
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
		$curl = Eden_Curl::i()
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