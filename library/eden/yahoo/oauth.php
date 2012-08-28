<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Abstractly defines a layout of available methods to
 * connect to and query a database. This class also lays out 
 * query building methods that auto renders a valid query
 * the specific database will understand without actually 
 * needing to know the query language.
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Yahoo_Oauth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const TOKEN_URL			= 'https://api.login.yahoo.com/oauth/v2/get_request_token';
	const CONSUMER_KEY_URL	= 'http://developer.apps.yahoo.com/projects/createconsumerkey';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_secret		= NULL;
	protected $_params		= array();
	protected $_scopes		= array();
	protected $_debug		= true;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key, $secret) {
		$this->_params['oauth_consumer_key'] = $key;
		$this->_secret = $secret;
	}
	
	public function setAppid($appId) {
		$this->_params['appid'] = $appId;
		return $this;
	}
	
	public function setName($name) {
		$this->_params['name'] = $name;
		return $this;
	}
	
	public function setDescription($description) {
		$this->_params['description'] = $description;
		return $this;
	}
	
	public function setFavicon($favicon) {
		$this->_params['favicon'] = $favicon;
		return $this;
	}
	
	public function setThirdParty($thirdParty) {
		$this->_params['third_party'] = $thirdParty;
		return $this;
	}
	
	public function returnUrl($url) {
		$this->_params['return_to'] = $url;
		return $this;
	}
	
	public function addScope($scope) {
		$this->_scopes[] = $scope;
		return $this;
	}
	
	public function setAppUrl($url) {
		$this->_params['application_url'] = $url;
		return $this;
	}
	
	public function setDebug($debug = true) {
		$this->_debug = $debug;
		return $this;
	}
	
	public function setDomain($domain) {
		$this->_params['domain'] = $domain;
		return $this;
	}
	
	public function setTimestamp($timestamp = NULL) {
		if(is_null($timestamp)) {
			$this->_params['oauth_timestamp'] = time();
		}
		
		if(!is_numeric($timestamp)) {
			$this->_params['oauth_timestamp'] = strtotime($timestamp);
		}
		
		$this->_params['oauth_timestamp'] = $timestamp;
		return $this;
	}
	
	public function setSignatureMethod($method = 'PLAINTEXT') {
		$this->_params['oauth_signature_method'] = $method;
		return $this;
	}
	
	public function setCallBack($callback) {
		$this->_params['oauth_callback'] = $callback;
		return $this;
	}
	
	public function getToken() {
		$this->_params['oauth_signature_method']	= ($this->_params['oauth_signature_method']) ? $this->_params['oauth_signature_method'] :  'PLAINTEXT';
		$this->_params['oauth_version']				= '1.0';
		$this->_params['xoauth_lang_pref']			= 'en-us';
		$this->_params['oauth_nonce'] = md5($this->_params['oauth_timestamp']);
		$this->_params['oauth_signature'] = $this->_setSignature();
		
		$query = http_build_query($this->_params);
		
		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl(self::TOKEN_URL)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getResponse();
		
		return $response;
	}
	
	public function getConsumerKey() {
		$this->_params['scopes'] = implode(', ', $this->_scopes);
		$url = ($this->_debug) ? self::CONSUMER_KEY_URL.'?debug=true' : self::CONSUMER_KEY_URL;
		unset($this->_params['oauth_consumer_key']);
		front()->output($this->_params); exit;
		$params = http_build_query($this->_params);
		
		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($params)
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getResponse();
		return $response;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setSignature() {
		$signature = 'POST&'.urlencode(self::TOKEN_URL).'&';
		$signature .= http_build_query($this->_params);
		
		if($this->_params['oauth_signature_method'] == 'HMAC-SHA1') {
			$signature = hash_hmac("sha1", $signature, $this->_params['oauth_consumer_key'], TRUE);
		}
		
		return $signature;
	}
	
	/* Private Methods
	-------------------------------*/
}