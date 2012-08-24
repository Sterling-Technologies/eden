<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google oauth
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Oauth extends Eden_Oauth2_Client {
	/* Constants
	-------------------------------*/
	const REQUEST_URL 	= 'https://accounts.google.com/o/oauth2/auth';
	const ACCESS_URL 	= 'https://accounts.google.com/o/oauth2/token';	
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey = NULL;
	protected $_scopes = array(	
		'analytics' 	=> 'https://www.googleapis.com/auth/analytics.readonly',
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
	
	public function __construct($clientId, $clientSecret, $redirect,  $apiKey = NULL) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string')				//Argument 2 must be a string
			->argument(3, 'string')				//Argument 3 must be a string
			->argument(4, 'string', 'null');	//Argument 4 must be a string or null

		$this->_apiKey = $apiKey;
		
		parent::__construct($clientId, $clientSecret, $redirect, self::REQUEST_URL, self::ACCESS_URL);
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}