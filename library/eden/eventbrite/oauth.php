<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite oauth
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Oauth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const AUTHORIZE_URL		= 'https://www.eventbrite.com/oauth/authorize';
	const ACCESS_URL		= 'https://www.eventbrite.com/oauth/token';
	
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
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($clientId, $appSecret) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_key 	= $clientId;
		$this->_secret 	= $appSecret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the access token 
	 * 
	 * @param string client ID from your API console
	 * @param string app secret from your API console
	 * @return string code from the URL query
	 */
	public function getAccessToken($code) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query = array(
			'code'			=> $code,
			'client_secret' => $this->_secret,
			'client_id' 	=> $this->_key,
			'grant_type' 	=> 'authorization_code');
		
		$headers = array();
		$headers[] = 'Content-type: application/x-www-form-urlencoded';
		
		//set curl
		return Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl(self::ACCESS_URL)
			->setPost(true)
			->setPostFields(http_build_query($query))
			->setHeaders($headers)
			->getJsonResponse();
	}
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @return string
	 */
	public function getLoginUrl() {
		//build the query
		$query = array('response_type' => 'code', 'client_id' => $this->_key);
		$query = http_build_query($query);
		
		return self::AUTHORIZE_URL.'?'.$query;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}