<?php //-->	
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.st.
 */

/**
 * Facebook Subscribe
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Facebook_Subscribe extends Eden_Class {
	/* Constants
	-------------------------------*/
	const SUBSCRIBE_URL		= 'https://graph.facebook.com/%s/subscriptions';
	const APPLICATION_URL	= 'https://graph.facebook.com/oauth/access_token?client_id=%s&client_secret=%s&grant_type=%s';
	const CREDENTIALS		= 'client_credentials';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token 	= NULL;
	protected $_meta 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($clientId, $secret) {
		//argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
		
		$this->_appId = $clientId;
		
		//request a application access token
		$tokenUrl = sprintf(self::APPLICATION_URL, $clientId, $secret, self::CREDENTIALS);
		$appToken = file_get_contents($tokenUrl);
		//convert the query to array
		parse_str($appToken, $token);
		//check access token is already set
		if(!isset($token['access_token'])) {
			//return if theres an error
			return $token;
		} else {
			//get the access token
			$this->_token = $token['access_token'];
		}
		
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta() {
	
		return $this->_meta;
	}
	
	/**
	 * Returns each of users subscribed objects and their subscribed fields 
	 *
	 * @return array
	 */
	public function getSubscription() {
	
		return $this->_getResponse(sprintf(self::SUBSCRIBE_URL, $this->_appId));
	
	}
	
	/**
	 * Subscribes to Facebook real-time updates
	 * 
	 * @param string Type of Facebook object (user, permissions, page)
	 * @param string Comma-deliminated list of fields to subscribe to (e.g. "name,picture,friends,feed")
	 * @param url Callback-url for the real-time updates
	 */
	public function subscribe($object, $fields, $callbackUrl) {
		//argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'url');
		
		//populate fields
		$query = array(
			'object'		=> $object,
			'fields' 		=> $fields,
			'callback_url'	=> $callbackUrl,
			'verify_token'	=> sha1($this->_appId.$object.$callbackUrl));
		
		//generate url
		$token 	= array('access_token' => $this->_token);
		$url 	= sprintf(self::SUBSCRIBE_URL, $this->_appId).'?'.http_build_query($token);
		
		return $this->_post($url, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _post($url, array $query = array()) {
		
		//set curl
		$curl = Eden_Curl::i()
			->setConnectTimeout(10)
			->setFollowLocation(true)
			->setTimeout(60)
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders('Expect');
		//get response form curl
		$response = $curl->getJsonResponse();		
		//get curl infomation
		$this->_meta 				= $curl->getMeta();
		$this->_meta['url'] 		= $url;
		$this->_meta['query'] 		= $query;
		$this->_meta['response']	= $response;
	
		return $response;
	}
	
	protected function _getResponse($url, array $query = array()) {
		//if needed, add access token to query
		$query['access_token'] = $this->_token;
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
		
		return $response;
	}
	/* Private Methods
	-------------------------------*/
}