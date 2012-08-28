<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Oauth consumer methods
 *
 * @package    Eden
 * @category   oauth
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Oauth_Consumer extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const AUTH_HEADER 	= 'Authorization: OAuth %s';
	const POST_HEADER 	= 'Content-Type: application/x-www-form-urlencoded';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_consumerKey 		= NULL; 
	protected $_consumerSecret 		= NULL; 
	protected $_requestToken		= NULL; 
	protected $_requestSecret		= NULL; 
	protected $_useAuthorization	= false;
	
	protected $_url			= NULL; 
	protected $_method 		= NULL;
	protected $_realm		= NULL; 
	protected $_time		= NULL; 
	protected $_nonce		= NULL; 
	protected $_verifier	= NULL; 
	protected $_callback	= NULL;
	protected $_signature	= NULL;
	protected $_meta		= array();
	protected $_headers		= array();
	 
	protected $_json		= false;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($url, $key, $secret) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		$this->_consumerKey 	= $key;
		$this->_consumerSecret 	= $secret;
		
		$this->_url		= $url;
		$this->_time 	= time();
		$this->_nonce 	= md5(uniqid(rand(), true));
		
		$this->_signature = self::PLAIN_TEXT;
		$this->_method = self::GET;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the authorization header string
	 *
	 * @param string
	 * @return string
	 */
	public function getAuthorization($signature, $string = true) {
		//argument test
		Eden_Oauth_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'bool');		//Argument 2 must be a boolean
		
		//this is all possible configurations
		$params = array(
			'realm'						=> $this->_realm,
			'oauth_consumer_key' 		=> $this->_consumerKey,
			'oauth_token'				=> $this->_requestToken,
			'oauth_signature_method'	=> self::HMAC_SHA1,
			'oauth_signature'			=> $signature,
			'oauth_timestamp'			=> $this->_time,
			'oauth_nonce'				=> $this->_nonce,
			'oauth_version'				=> self::OAUTH_VERSION,
			'oauth_verifier'			=> $this->_verifier,
			'oauth_callback'			=> $this->_callback);
		
		//if no realm
		if(is_null($this->_realm)) {
			//remove it
			unset($params['realm']);
		}
		
		//if no token
		if(is_null($this->_requestToken)) {
			//remove it
			unset($params['oauth_token']);
		}
		
		//if no verifier
		if(is_null($this->_verifier)) {
			//remove it
			unset($params['oauth_verifier']);
		}
		
		
		//if no callback
		if(is_null($this->_callback)) {
			//remove it
			unset($params['oauth_callback']);
		}
		
		if(!$string) {
			return $params;
		}
		
		return sprintf(self::AUTH_HEADER, $this->_buildQuery($params, ',', false));	
	}
	
	/**
	 * Returns the results
	 * parsed as DOMDocument
	 *
	 * @return DOMDOcument
	 */
	public function getDomDocumentResponse(array $query = array()) {
		$xml = new DOMDocument();
		$xml->loadXML($this->getResponse($query));
		return $xml;
	}
	
	/**
	 * Returns the signature
	 *
	 * @return string
	 */
	public function getHmacPlainTextSignature() {
		return $this->_consumerSecret . '&' . $this->_tokenSecret;
	}
	
	/**
	 * Returns the signature
	 *
	 * @param array
	 * @return string
	 */
	public function getHmacSha1Signature(array $query = array()) {
		//this is like the authorization params minus the realm and signature
		$params = array(
			'oauth_consumer_key' 		=> $this->_consumerKey,
			'oauth_token'				=> $this->_requestToken,
			'oauth_signature_method'	=> self::HMAC_SHA1,
			'oauth_timestamp'			=> $this->_time,
			'oauth_nonce'				=> $this->_nonce,
			'oauth_version'				=> self::OAUTH_VERSION,
			'oauth_verifier'			=> $this->_verifier,
			'oauth_callback'			=> $this->_callback);
		
		//if no token
		if(is_null($this->_requestToken)) {
			//unset that parameter
			unset($params['oauth_token']);
		}
		
		//if no token
		if(is_null($this->_verifier)) {
			//unset that parameter
			unset($params['oauth_verifier']);
		}
		
		//if no callback
		if(is_null($this->_callback)) {
			//remove it
			unset($params['oauth_callback']);
		}
		
		$query = array_merge($params, $query); //merge the params and the query
		$query = $this->_buildQuery($query); //make query into a string
		
		//create the base string
		$string = array($this->_method, $this->_encode($this->_url), $this->_encode($query));
		$string = implode('&', $string);
		
		//create the encryption key
  		$key = $this->_encode($this->_consumerSecret) . '&' . $this->_encode($this->_requestSecret);
		
		//authentication method
		return base64_encode(hash_hmac('sha1', $string, $key, true));
	}
	
	/**
	 * Returns the json response from the server
	 *
	 * @param array
	 * @return array
	 */
	public function getJsonResponse(array $query = array(), $assoc = true) {
		return json_decode($this->getResponse($query), $assoc);
	}
	
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Oauth_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/**
	 * Returns the query response from the server
	 *
	 * @param array
	 * @return array
	 */
	public function getQueryResponse(array $query = array()) {
		parse_str($this->getResponse($query), $response);
		return $response;
	}
	
	/**
	 * Returns the token from the server
	 *
	 * @param array
	 * @return array
	 */
	public function getResponse(array $query = array()) {
		$headers 	= $this->_headers;
		$json 		= NULL;
		
		if($this->_json) {
			$json 	= json_encode($query);
			$query 	= array();
		}
		
		//get the authorization parameters as an array
		$signature 		= $this->getSignature($query);
		$authorization 	= $this->getAuthorization($signature, false);
		
		//if we should use the authrization
		if($this->_useAuthorization) {
			//add the string to headers
			$headers[] = sprintf(self::AUTH_HEADER, $this->_buildQuery($authorization, ',', false));
		} else {
			//merge authorization and query
			$query = array_merge($authorization, $query);
		}
		
		$query 	= $this->_buildQuery($query);
		$url 	= $this->_url;
		
		//set curl
		$curl = Eden_Curl::i()->verifyHost(false)->verifyPeer(false);
		
		//if post
		if($this->_method == self::POST) {
			$headers[] = self::POST_HEADER;
			
			if(!is_null($json)) {
				$query = $json;
			}
			
			//get the response
			$response = $curl->setUrl($url)
				->setPost(true)
				->setPostFields($query)
				->setHeaders($headers)
				->getResponse();
		} else {
			if(trim($query)) {
				//determine the conector
				$connector = NULL;
				
				//if there is no question mark
				if(strpos($url, '?') === false) {
					$connector = '?';
				//if the redirect doesn't end with a question mark
				} else if(substr($url, -1) != '?') {
					$connector = '&';
				}
				
				//now add the secret to the redirect
				$url .= $connector.$query;
			}
			
			//get the response
			$response = $curl->setUrl($url)->setHeaders($headers)->getResponse();
		}
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['authorization'] 	= $authorization;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		$this->_meta['response'] 		= $response;
		
		return $response;
	}
	
	/**
	 * Returns the signature based on what signature method was set
	 *
	 * @param array
	 * @return string
	 */
	public function getSignature(array $query = array()) {
		switch($this->_signature) {
			case self::HMAC_SHA1:
				return $this->getHmacSha1Signature($query);
			case self::RSA_SHA1:
			case self::PLAIN_TEXT:
			default:
				return $this->getHmacPlainTextSignature();
		}
	}
	
	/**
	 * Returns the results
	 * parsed as SimpleXml
	 *
	 * @return SimpleXmlElement
	 */
	public function getSimpleXmlResponse(array $query = array()) {
		return simplexml_load_string($this->getResponse($query));
	}
	
	/**
	 * When sent, sends the parameters as post fields
	 *
	 * @return this
	 */
	public function jsonEncodeQuery() {
		$this->_json = true;
		return $this;
	}
	
	/**
	 * Sets the callback for authorization
	 * This should be set if wanting an access token
	 *
	 * @param string
	 * @return this
	 */
	public function setCallback($url) {
		Eden_Oauth_Error::i()->argument(1, 'string');
		
		$this->_callback = $url;
		
		return $this;
	}
	
	/**
	 * Sets request headers
	 *
	 * @param array|string
	 * @return this
	 */
	public function setHeaders($key, $value = NULL) {
		Eden_Oauth_Error::i()
			->argument(1, 'array', 'string')
			->argument(2, 'scalar','null');
		
		if(is_array($key)) {
			$this->_headers = $key;
			return $this;
		}
		
		$this->_headers[] = $key.': '.$value;
		return $this;
	}
	
	/**
	 * When sent, appends the parameters to the URL
	 *
	 * @return this
	 */
	public function setMethodToGet() {
		$this->_method = self::GET;
		return $this;
	}
	
	/**
	 * When sent, sends the parameters as post fields
	 *
	 * @return this
	 */
	public function setMethodToPost() {
		$this->_method = self::POST;
		return $this;
	}
	
	/**
	 * Some Oauth servers requires a realm to be set
	 *
	 * @param string
	 * @return this
	 */
	public function setRealm($realm) {
		Eden_Oauth_Error::i()->argument(1, 'string');
		$this->_realm = $realm;
		return $this;
	}
	
	/**
	 * Sets the signature encryption type to HMAC-SHA1
	 *
	 * @return this
	 */
	public function setSignatureToHmacSha1() {
		$this->_signature = self::HMAC_SHA1;
		return $this;
	}
	
	/** 
	 * Sets the signature encryption to RSA-SHA1
	 *
	 * @return this
	 */
	public function setSignatureToRsaSha1() {
		$this->_signature = self::RSA_SHA1;
		return $this;
	}
	
	/** 
	 * Sets the signature encryption to PLAINTEXT
	 *
	 * @return this
	 */
	public function setSignatureToPlainText() {
		$this->_signature = self::PLAIN_TEXT;
		return $this;
	}
	
	/**
	 * Sets the request token and secret. 
	 * This should be set if wanting an access token
	 *
	 * @param string
	 * @param string
	 * @return this
	 */
	public function setToken($token, $secret) {
		Eden_Oauth_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_requestToken = $token;
		$this->_requestSecret = $secret;
		
		return $this;
	}
	
	/**
	 * Some Oauth servers requires a verifier to be set
	 * when retrieving an access token
	 *
	 * @param string
	 * @return this
	 */
	public function setVerifier($verifier) {
		Eden_Oauth_Error::i()->argument(1, 'scalar');
		$this->_verifier = $verifier;
		return $this;
	}
	
	/**
	 * When sent, appends the authroization to the headers
	 *
	 * @param bool
	 * @return this
	 */
	public function useAuthorization($use = true) {
		Eden_Oauth_Error::i()->argument(1, 'bool');
		$this->_useAuthorization = $use;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}