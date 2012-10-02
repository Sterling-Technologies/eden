<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Instagram Auth
 *
 * @package    Eden
 * @category   Instagram
 * @author     Nikko Bautista (nikko@nikkobautista.com)
 */
class Eden_Instagram_Auth extends Eden_Instagram {
	/* Constants
	-------------------------------*/
	const AUTHORIZE_URL		= 'https://api.instagram.com/oauth/authorize';
	const ACCESS_URL		= 'https://api.instagram.com/oauth/access_token';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_client_id 		= NULL;
	protected $_client_secret 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($client_id, $client_secret) {
		//argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
			
		$this->_client_id 	= $client_id;
		$this->_client_secret 	= $client_secret;
	}
	
	/* Public Methods
	-------------------------------*/
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param string callback URL
	 * @param array array of permissions to ask
	 * @param string response type (usually set to code)
	 * @return string authorize URL
	 */
	public function getLoginUrl($redirect, $scope = array(), $state = NULL, $response_type = 'code') {
		//Argument tests
		Eden_Instagram_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'array')		//Argument 2 must be a array
			->argument(3, 'string');	//Argument 3 must be a string
		
		//build the query
		$query = array(
			'client_id' => $this->_client_id,
			'redirect_uri' => $redirect,
			'response_type' => $response_type,
			'scope' => implode(' ', $scope),
			'state' => $state
		);

		if( !$state ) {
			unset($query['state']);
		}

		return $this->_buildurl(self::AUTHORIZE_URL, $query);
	}
	
	/**
	 * Returns the access token 
	 * 
	 * @param string code value provided post-redirect
	 * @param string call back URI provided in the getLoginUrl request
	 * @return string an access token for the user
	 */
	public function getAccessToken($code, $redirect, $grant_type = 'authorization_code') {
		//Argument test
		Eden_Instagram_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
		
		return $this->_post(self::ACCESS_URL, array(
			'client_id' => $this->_client_id,
			'client_secret' => $this->_client_secret,
			'grant_type' => $grant_type,
			'redirect_uri' => $redirect,
			'code' => $code
		));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}