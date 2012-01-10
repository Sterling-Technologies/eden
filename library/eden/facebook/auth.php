<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.st.
 */

/**
 * Facebook Authentication
 *
 * @package    Eden
 * @subpackage file
 * @category   path
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: model.php 4 2010-01-06 04:41:07Z blanquera $
 */
class Eden_Facebook_Auth extends Eden_Class {
	/* Constants
	-------------------------------*/
	const AUTHENTICATION_USER_URL 	= 'https://www.facebook.com/dialog/oauth';
	const AUTHENTICATION_APP_URL	= 'https://graph.facebook.com/oauth/access_token';
	const USER_AGENT				= 'facebook-php-3.1';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 			= NULL;
	protected $_secret 			= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($key, $secret) {
		$this->_key 		= $key;
		$this->_secret 		= $secret;
	}
	
	/* Public Methods
	-------------------------------*/
	public function getLoginUrl($redirect, array $scope = array(), $state = NULL) {
		$parameters = array(
			'client_id'		=> $this->_key,
			'redirect_uri'	=> $redirect,
			'scope'			=> implode(',',$scope),
			'state'			=> $state);
		
		if(empty($scope)) {
			unset($parameters['scope']);
		}
		
		if(!$state) {
			unset($parameters['state']);
		}
		
		$parameters = http_build_query($parameters);
		
		return self::AUTHENTICATION_USER_URL.'?'.$parameters;
	}
	
	public function getToken($code, $redirect) {
		$parameters = array(
			'client_id'		=> $this->_key,
			'client_secret'	=> $this->_secret,
			'redirect_uri'	=> $redirect,
			'code'			=> $code);
		
		$parameters = http_build_query($parameters);
		$url 		= self::AUTHENTICATION_APP_URL.'?'.$parameters;
		
		$response = Eden_Curl::i()
			->setUrl($url)
			->setConnectTimeout(10)
			->setTimeout(60)
			->setUserAgent(self::USER_AGENT)
			->setHeaders('Expect')
			->verifyPeer(false)
			->getQueryResponse();
		
		return $response['access_token'];
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}