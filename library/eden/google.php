<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';
require_once dirname(__FILE__).'/google/error.php';
require_once dirname(__FILE__).'/google/oauth.php';
require_once dirname(__FILE__).'/google/base.php';
require_once dirname(__FILE__).'/google/calendar.php';

/**
 * Google API factory. This is a factory class with 
 * methods that will load up different Google classes.
 * Google classes are organized as described on their 
 * developer site: calendar, docs, youtube, shortener
 * gmail, contacts, maps, google+. We also added several 
 * classes for more advanced options when posting to Google.
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google extends Eden_Class {
	/* Constants
	-------------------------------*/
	const CALENDAR_SCOPE	= 'https://www.googleapis.com/auth/calendar';
	const PLUS_SCOPE		= 'https://www.googleapis.com/auth/plus.me';
	
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
	 * Returns Google OAuth
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return Eden_Google_Oauth
	 */
	public function auth($key, $secret, $redirect, $apiKey) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string')
			->argument(3, 'string')
			->argument(4, 'string');
			
		return Eden_Google_Oauth::i($key, $secret, $redirect, $apiKey);
	}
	
	/**
	 * Returns Google Calendar
	 *
	 * @param string
	 * @return Eden_Google_Calendar
	 */
	public function calendar($token) {
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Calendar::i($token);
	}
	
	/**
	 * Returns Google Docs
	 *
	 * @param string
	 * @return Eden_Google_Docs
	 */
	public function docs($token) {
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Docs::i($token);
	}
	
	/**
	 * Returns Google Plus
	 *
	 * @param string
	 * @return Eden_Google_Docs
	 */
	public function plus($token) {
		Eden_Google_Error::i()->argument(1, 'string');
			
		return Eden_Google_Plus::i($token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}