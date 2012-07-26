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
	protected $_client	= NULL;
	protected $_secret	= NULL;
	protected $_state	= NULL;
	
	protected $_responseType	= self::CODE;
	protected $_approvalPrompt	= self::AUTO;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __construct($client, $secret) {
		//argument test
		Eden_Oauth2_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_client = $client;
		$this->_secret = $secret;
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
	 * abstract function for getting login url
	 *
	 * @param string
	 * @param string
	 * @param string
	 *
	 */
	abstract public function getLoginUrl($url, $scope, $redirect);
	
	/* Protected Methods
	-------------------------------*/
	protected function _getLoginUrl($url, $query, $scope = NULL) {
		//if there is a scope
		if(!is_null($scope)) {
			//if scope is in array
			if(is_array($scope)) {
				$scope = implode(' ', $scope);
			}
			//add scope to the query
			$query['scope'] = $scope;
		}
		//of there is state
		if(!is_null($this->_state)) {
			//add state to the query
			$query['state'] = $this->_state;
		}
		
		//generate http build query url
		return $url.'?'.http_build_query($query);
	}
	
	/* Private Methods
	-------------------------------*/
}