<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/oauth2/error.php';
require_once dirname(__FILE__).'/oauth2/abstract.php';
require_once dirname(__FILE__).'/oauth2/client.php';
require_once dirname(__FILE__).'/oauth2/desktop.php';

/**
 * Oauth2 Factory class;
 *
 * @package    Eden
 * @category   core oauth2
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Oauth2 extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns oauth 2 client side class
	 * 
	 * @param string The application client ID, can get through registration
	 * @param string The application secret, can get through registration 
	 * @param url Your callback url or where do you want to redirect the user after authentication
	 * @param url The request url,  can get through registration
	 * @param url The access url,  can get through registration
	 * @return Eden_Oauth2_Client
	 */
	public function client($client, $secret, $redirect, $requestUrl, $accessUrl) {
		//argument test
		Eden_Oauth2_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a url
			->argument(3, 'url')		//argument 3 must be a url
			->argument(4, 'url')		//argument 4 must be a url
			->argument(5, 'url');		//argument 5 must be a url
	
		return Eden_Oauth2_Client::i($client, $secret, $redirect, $requestUrl, $accessUrl);
	} 
	
	/**
	 * Returns oauth 2 desktop class
	 * 
	 * @param string The application client ID, can get through registration
	 * @param string The application secret, can get through registration 
	 * @param url Your callback url or where do you want to redirect the user after authentication
	 * @param url The request url,  can get through registration
	 * @param url The access url,  can get through registration
	 * @return Eden_Oauth2_Client
	 */
	public function desktop($client, $secret, $redirect, $requestUrl, $accessUrl) {
		//argument test
		Eden_Oauth2_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a url
			->argument(3, 'url')		//argument 3 must be a url
			->argument(4, 'url')		//argument 4 must be a url
			->argument(5, 'url');		//argument 5 must be a url
	
		return Eden_Oauth2_Desktop::i($client, $secret, $redirect, $requestUrl, $accessUrl);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
} 