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
class Eden_Foursquare_Oauth extends Eden_Oauth2_Client {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'https://foursquare.com/oauth2/authorize';
	const ACCESS_URL 	= 'https://foursquare.com/oauth2/access_token';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($clientId, $clientSecret, $redirect) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string');			//Argument 4 must be a string

		parent::__construct($clientId, $clientSecret, $redirect, self::REQUEST_URL, self::ACCESS_URL);
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}