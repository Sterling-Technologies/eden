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
class Eden_Eventbrite_Oauth extends Eden_Oauth2_Client {
	/* Constants
	-------------------------------*/
	const REQUEST_URL	= 'https://www.eventbrite.com/oauth/authorize';
	const ACCESS_URL	= 'https://www.eventbrite.com/oauth/token';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($clientId, $appSecret, $redirect) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string');	//Argument 3 must be a string
			
		parent::__construct($clientId, $appSecret, $redirect, self::REQUEST_URL, self::ACCESS_URL);
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}