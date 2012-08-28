<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Oauth2 abstract class
 *
 * @package    Eden
 * @category   oauth2
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
abstract class Eden_Oauth2_Abstract extends Eden_Class {
	/* Constants
	-------------------------------*/
	const CODE    	= 'code';
	const TOKEN		= 'token';
	const ONLINE	= 'online';
	const OFFLINE	= 'offline';
	const AUTO    	= 'auto';
	const FORCE   	= 'force';
	const TYPE		= 'Content-Type';
	const REQUEST	= 'application/x-www-form-urlencoded';
	
	const RESPONSE_TYPE	= 'response_type';
	const CLIENT_ID		= 'client_id';
	const REDIRECT_URL	= 'redirect_uri';
	const ACCESS_TYPE	= 'access_type';
	const APROVAL		= 'approval_prompt';
	const CLIENT_SECRET	= 'client_secret';
	const GRANT_TYPE	= 'grant_type';
	const AUTHORIZATION	= 'authorization_code';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_client		= NULL;
	protected $_secret		= NULL;
	protected $_redirect	= NULL;
	protected $_state		= NULL;
	protected $_scope		= NULL;
	protected $_display		= NULL;
	protected $_requestUrl	= NULL;
	protected $_accessUrl	= NULL;
	
	protected $_responseType	= self::CODE;
	protected $_approvalPrompt	= self::AUTO;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($client, $secret, $redirect, $requestUrl, $accessUrl) {
		//argument test
		Eden_Oauth2_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'url')		//argument 3 must be a url
			->argument(4, 'url')		//argument 4 must be a url
			->argument(5, 'url');		//argument 5 must be a url
		
		$this->_client 		= $client;
		$this->_secret 		= $secret;
		$this->_redirect 	= $redirect;
		$this->_requestUrl	= $requestUrl;
		$this->_accessUrl 	= $accessUrl;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set auth to auto approve
	 *
	 * @return this
	 */
	public function autoApprove() {
		$this->_approvalPrompt = self::AUTO;
		
		return $this;
	}
	
	/**
	 * Set auth for force approve
	 *
	 * @return this
	 */
	public function forceApprove() {
		$this->_approvalPrompt = self::FORCE;
		
		return $this;
	}
	
	/**
	 * Set state
	 *
	 * @param string
	 * @return this
	 */
	public function setState($state) {
		//argument 1 must be a string
		Eden_Oauth2_Error::i()->argument(1, 'string');
		$this->_state = $state;
		
		return $this;
	}
	
	/**
	 * Set scope
	 *
	 * @param string|array
	 * @return this
	 */
	public function setScope($scope) {
		//argument 1 must be a string or array
		Eden_Oauth2_Error::i()->argument(1, 'string', 'array');
		$this->_scope = $scope;
		
		return $this;
	}
	
	/**
	 * Set display
	 *
	 * @param string|array
	 * @return this
	 */
	public function setDisplay($display) {
		//argument 1 must be a string or array
		Eden_Oauth2_Error::i()->argument(1, 'string', 'array');
		$this->_display = $display;
		
		return $this;
	}
	
	/**
	 * Check if the response is json format
	 *
	 * @param string
	 * @return boolean
	 */
	public function isJson($string) {
		//argument 1 must be a string
		Eden_Oauth2_Error::i()->argument(1, 'string');
		
 		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);
	}
	
	/**
	 * abstract function for getting login url
	 *
	 * @param string|null
	 *
	 */
	abstract public function getLoginUrl($scope = NULL, $display = NULL);
	
	/**
	 * Returns website login url
	 *
	 * @param string*
	 * @return array
	 */
	abstract public function getAccess($code);
	
	/* Protected Methods
	-------------------------------*/
	protected function _getLoginUrl($query) {
		//if there is a scope
		if(!is_null($this->_scope)) {
			//if scope is in array
			if(is_array($this->_scope)) {
				$this->_scope = implode(' ', $this->_scope);
			}
			//add scope to the query
			$query['scope'] = $this->_scope;
		}
		//if there is state
		if(!is_null($this->_state)) {
			//add state to the query
			$query['state'] = $this->_state;
		}
		//if there is display
		if(!is_null($this->_display)) {
			//add state to the query
			$query['display'] = $this->_display;
		}
		//generate a login url
		return $this->_requestUrl.'?'.http_build_query($query);
	}
	
	
	protected function _getAccess($query, $code = NULL) {
		//if there is a code
		if(!is_null($code)) {
			//put codein the query
			$query[self::CODE] = $code;	
		}
		//set curl	  
		$result = Eden_Curl::i()
		  ->setUrl($this->_accessUrl)
		  ->verifyHost()
		  ->verifyPeer()
		  ->setHeaders(self::TYPE, self::REQUEST)
		  ->setPostFields(http_build_query($query))
		  ->getResponse();
		  
		//check if results is in JSON format
		if($this->isJson($result)) {
			//if it is in json, lets json decode it
			$response =  json_decode($result, true);	
		//else its not in json format
		} else {
			//parse it to make it an array
			 parse_str($result, $response);
		}
		
		return $response;
	}
	
	
	/* Private Methods
	-------------------------------*/
}