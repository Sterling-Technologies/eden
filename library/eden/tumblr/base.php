<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Tumblr base
 *
 * @package    Eden
 * @category   tumblr
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Tumblr_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const API_KEY = 'api_key';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_consumerKey 	= NULL;
	protected $_consumerSecret 	= NULL;
	protected $_accessToken		= NULL;
	protected $_accessSecret	= NULL;
	protected $_query			= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Tumblr_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
		
		$this->_consumerKey 	= $consumerKey; 
		$this->_consumerSecret 	= $consumerSecret; 
		$this->_accessToken 	= $accessToken; 
		$this->_accessSecret 	= $accessSecret;
		
	}
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Tumblr_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _accessKey($array) {
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			//if value is null
			if(is_null($val) || empty($val)) {
				//remove it to query
				unset($array[$key]);
			} else if($val === false) {
				$array[$key] = 0;
			} else if($val === true) {			
				$array[$key] = 1;
			}
			
		}
		
		return $array;
	}
	
	protected function _reset() {
		//foreach this as key => value
		foreach ($this as $key => $value) {
			//if the value of key is not array
			if(!is_array($this->$key)) {
				//if key name starts at underscore, probably it is protected variable
				if(preg_match('/^_/', $key)) {
					//if the protected variable is not equal to token
					//we dont want to unset the access token
					if($key != '_token') {
						//reset all protected variables that currently use
						$this->$key = NULL;
					}
				}
			} 
        } 
		
		return $this;
	}
	
	protected function _getResponse($url, array $query = array()) {
		//if needed, add developer id to the query
		if(!is_null($this->_consumerKey)) {
			$query[self::API_KEY] = $this->_consumerKey;
		}
		
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//build url query
		$url = $url.'?'.http_build_query($query);
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60);
		//get response from curl
		$response = $curl->getJsonResponse();
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		
		//reset variables
		unset($this->_query);
		
		return $response;
	} 
	
	protected function _getAuthResponse($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query); 
		//make oauth signature
		$rest =  Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->useAuthorization()
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		//get response from curl
		$response = $rest->getJsonResponse($query);
			
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['response']	= $response;
		
		//reset variables
		unset($this->_query);
		
		return $response;
	}
	
	protected function _post($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//set headers
		$headers = array();
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		//make oauth signature
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToPost()
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		//get the authorization parameters as an array
		$signature 		= $rest->getSignature($query);
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->_buildQuery($authorization);
		//if query is in array
		if(is_array($query)) {
			//build a http query
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
		$response = $curl->getJsonResponse();
	
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		//reset variables
		unset($this->_query);
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}