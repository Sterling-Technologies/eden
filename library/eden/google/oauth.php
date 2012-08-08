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
class Eden_Google_Oauth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'https://accounts.google.com/o/oauth2/auth';
	const ACCESS_URL 	= 'https://accounts.google.com/o/oauth2/token';
	
	const AUTH_CODE		= 'authorization_code';
	const ONLINE		= 'online';
	const OFFLINE		= 'offline';
	const FORCE			= 'force';
	const AUTO			= 'auto';
	const TOKEN			= 'token';
	const CODE			= 'code';
	
	const FORM_HEADER	= 'application/x-www-form-urlencoded';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_clientId 		= NULL;
	protected $_clientSecret 	= NULL;
	protected $_redirect 		= NULL;
	protected $_apiKey			= NULL;
	
	protected $_online 	= self::ONLINE;
	protected $_renew 	= self::AUTO;
	protected $_state 	= NULL;
	
	protected $_scopes = array(	
		'analytics' 	=> 'https://www.google.com/analytics/feeds/',
		'base' 			=> 'https://www.google.com/base/feeds/',
		'buzz' 			=> 'https://www.googleapis.com/auth/buzz',
		'book' 			=> 'https://www.google.com/books/feeds/',
		'blogger'		=> 'https://www.blogger.com/feeds/',
		'calendar' 		=> 'https://www.google.com/calendar/feeds/',
		'contacts' 		=> 'https://www.google.com/m8/feeds/',
		'chrome' 		=> 'https://www.googleapis.com/auth/chromewebstore.readonly',
		'documents'		=> 'https://docs.google.com/feeds/',
		'finance'		=> 'https://finance.google.com/finance/feeds/',
		'gmail'			=> 'https://mail.google.com/mail/feed/atom',
		'health' 		=> 'https://www.google.com/health/feeds/',
		'h9' 			=> 'https://www.google.com/h9/feeds/',
		'maps'			=> 'https://maps.google.com/maps/feeds/',
		'moderator' 	=> 'https://www.googleapis.com/auth/moderator',
		'opensocial'	=> 'https://www-opensocial.googleusercontent.com/api/people/',
		'orkut' 		=> 'https://www.googleapis.com/auth/orkut',
		'orkut'			=> 'https://orkut.gmodules.com/social/rest',
		'picasa'		=> 'https://picasaweb.google.com/data/',
		'sidewiki' 		=> 'https://www.google.com/sidewiki/feeds/',
		'sites'			=> 'https://sites.google.com/feeds/',
		'spreadsheets'	=> 'https://spreadsheets.google.com/feeds/',
		'tasks'			=> 'https://www.googleapis.com/auth/tasks',
		'shortener' 	=> 'https://www.googleapis.com/auth/urlshortener',
		'wave'			=> 'http://wave.googleusercontent.com/api/rpc',
		'webmaster' 	=> 'https://www.google.com/webmasters/tools/feeds/',
		'youtube' 		=> 'https://gdata.youtube.com');
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	public function __construct($clientId, $clientSecret, $apiKey, $redirect) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string');			//Argument 4 must be a string

			
		$this->_clientId 		= $clientId; 
		$this->_clientSecret 	= $clientSecret;
		$this->_redirect 		= $redirect;
		$this->_apiKey			= $apiKey;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the access token 
	 * 
	 * @param string
	 * @return string
	 */
	public function getAccessToken($code) {
		Eden_Google_Error::i()->argument(1, 'string');	
			
		$query = array(
			'code' 				=> $code,
			'client_id'			=> $this->_clientId,
			'client_secret'		=> $this->_clientSecret,
			'redirect_uri'		=> $this->_redirect,
			'grant_type'		=> self::AUTH_CODE);
		
		
		return Eden_Curl::i()
			->setUrl(self::ACCESS_URL)
			->verifyHost(false)
			->verifyPeer(false)
			->setPost(true)
			->setPostFields(http_build_query($query))
			->setTimeout(60)
			->getJsonResponse();
	}
	
	/**
	 * Returns the API KEY 
	 * 
	 * @return string
	 */
	public function getApiKey() {
		return $this->_apiKey;
	}
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param array|string[,string]
	 * @return string
	 */
	public function getLoginUrl($scope) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string', 'array');
		
		if(!is_array($scope)) {
			$scope = func_get_args();
		}
		
		foreach($scope as $i => $url) {
			if(isset($this->_scopes[$url])) {
				$scope[$i] = $this->_scopes[$url];
			}
		}
		
		$scope = implode(' ', $scope);
		
		$query = array(
			'response_type'		=> self::CODE,
			'client_id'			=> $this->_clientId,
			'redirect_uri'		=> $this->_redirect,
			'scope'				=> $scope,
			'access_type'		=> $this->_online, 
			'state'				=> $this->_state,
			'approval_prompt'	=> $this->_renew);
		
		if(!$this->_state) {
			unset($query['state']);
		} 
		
		return self::REQUEST_URL.'?'.http_build_query($query);
	}
	
	/**
	 * Access token is sete to offline, long lived 
	 * 
	 * @return this
	 */
	public function setOffline() {
		$this->_online = self::OFFLINE;
		return $this;
	}
	
	/**
	 * Forces user to re approve of app
	 * 
	 * @return this
	 */
	public function setRenew() {
		$this->_renew = self::FORCE;
		return $this;
	}
	
	/**
	 * Sets thee state google will return back
	 * this could be anything you want
	 * 
	 * @param string
	 * @return this
	 */
	public function setState($state) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_state = $state;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}