<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * DropBox base
 *
 * @package    Eden
 * @category   dropbox
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_Dropbox_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_consumerKey 	= NULL;
	protected $_consumerSecret 	= NULL;
	protected $_accessToken		= NULL;
	protected $_accessSecret	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Dropbox_Error::i()
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
		Eden_Dropbox_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Check if the response is json format
	 *
	 * @param string
	 * @return boolean
	 */
	public function isJson($string) {
		//argument 1 must be a string
		Eden_Dropbox_Error::i()->argument(1, 'string');
		
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
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
				unset($array[$key]);
			} else if($val === false) {
				$array[$key] = 0;
			} else if($val === true) {			
				$array[$key] = 1;
			}
			
		}
		
		return $array;
	}
	
	protected function _getResponse($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToGet()
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		//get response from curl
		$response = $rest->getResponse($query);
		//echo base64_decode($response); exit;
		//reset variables
		unset($this->_query);
		
		$this->_meta = $rest->getMeta();
		
		//check if the response is in json format
		if($this->isJson($response)) { 
			//json encode it
			return json_decode($response, true);
		//else it is a raw query
		} else {
			//return it
			return $response;
		}
	}
	
	
	protected function _post($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setMethodToPost()
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		//get the authorization parameters as an array
		$signature 		= $rest->getSignature($query);
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->_buildQuery($authorization);
	
		if(is_array($query)) {
			$query 	= $this->_buildQuery($query);
		}

		$headers = array();
		$headers[] = Eden_Oauth_Consumer::POST_HEADER;
		
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
		
		//reset variables
		unset($this->_query);
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	protected function _upload($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//set url
		$this->_url = $url;
		//make authorization for twitter
		$this->_getAuthentication();
		//set headers
		//$this->_headers['Expect'] = '';
		$this->_headers['Content-Type: multipart/form-data'] = '';
		//at this point, the authentication header si already set
		foreach($this->_headers as $k => $v) {
			//trim header
			$headers[] = trim($k . ':' . $v);
		}
		
		 //set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)	
			->setHeaders($headers);
		//json decode the response	
		$response = $curl->getJsonResponse();
		
		//reset variables
		unset($this->_query);
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	protected function _getAuthentication() { 
		//populate fields
		$defaults = array(
		  'oauth_version'          	=> '1.0',
		  'oauth_nonce'            	=> md5(uniqid(rand(), true)),
		  'oauth_timestamp'        	=> time(),
		  'oauth_consumer_key'     	=> $this->_consumerKey,
		  'oauth_signature_method' 	=> 'HMAC-SHA1',
		  'oauth_token'				=> $this->_accessToken);
		
		//encode the parameters
		foreach ($defaults as $k => $v) {
		  $this->_signingParams[$this->safeEncode($k)] = $this->safeEncode($v);
		}
		//sort an array by keys using a user-defined comparison function
		uksort($this->_signingParams, 'strcmp'); 
		
		foreach ($this->_signingParams as $k => $v) {
		  //encode key 
		  $k = $this->safeEncode($k);
		  //encode value
		  $v = $this->safeEncode($v);
		  $_signing_params[$k] = $v;
		  $kv[] = "{$k}={$v}";
		}
		//implode signingParams to make it a string
		$this->_signingParams = implode('&', $kv);
   		//check if they have the same value
    	$this->_authParams = array_intersect_key($defaults, $_signing_params);
		//make a base string
		$base = array('POST', $this->_url, $this->_signingParams);
		//convert array to string and safely encode it 
		$this->_baseString = implode('&', $this->safeEncode($base));
		//make a signing key by combining consumer secret and access secret
		$this->_signingKey = $this->safeEncode($this->_consumerSecret).'&'.$this->safeEncode($this->_accessSecret);
		//generate signature
		$this->_authParams['oauth_signature'] = $this->safeEncode(
       	 	base64_encode(hash_hmac('sha1', $this->_baseString, $this->_signingKey, true)));
		
		foreach ($this->_authParams as $k => $v) {
		  $kv[] = "{$k}=\"{$v}\"";
		}
		//implode authHeader to make it ia string
		$this->_authHeader = 'OAuth ' . implode(', ', $kv);
		//put it in the authorization headera
		$this->_headers['Authorization'] = $this->_authHeader;
  	} 
 	
	protected function safeEncode($data) {
		//if data is in array
		if (is_array($data)) {
			//array map the data
			return array_map(array($this, 'safeEncode'), $data);
		//else it is not array
		} else if (is_scalar($data)) {
		  //str ireplace data, it is case-insensitive version of str_replace()
		  return str_ireplace(array('+', '%7E'), array(' ', '~'), rawurlencode($data));
		//else it is null or uempty
		} else {
		  return '';
		}
	
	}
	/* Private Methods
	-------------------------------*/
}