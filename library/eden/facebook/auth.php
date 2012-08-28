<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.st.
 */

/**
 * Facebook Authentication
 *
 * @package    Eden
 * @category   facebook
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Facebook_Auth extends Eden_Oauth2_Client {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'https://www.facebook.com/dialog/oauth';
	const ACCESS_URL	= 'https://graph.facebook.com/oauth/access_token';
	const USER_AGENT	= 'facebook-php-3.1';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 		= NULL;
	protected $_secret 		= NULL;
	protected $_redirect 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key, $secret, $redirect) {
		//argument test
		Eden_Facebook_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string');			//Argument 4 must be a string
		
		parent::__construct($key, $secret, $redirect, self::REQUEST_URL, self::ACCESS_URL);
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}