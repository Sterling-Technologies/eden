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
	
	const SCOPE_ANALYTICS 		= 'https://www.googleapis.com/auth/analytics.readonly';
	const SCOPE_BASE 			= 'https://www.google.com/base/feeds/';
	const SCOPE_BUZZ 			= 'https://www.googleapis.com/auth/buzz';
	const SCOPE_BOOK 			= 'https://www.google.com/books/feeds/';
	const SCOPE_BLOGGER			= 'https://www.blogger.com/feeds/';
	const SCOPE_CALENDAR 		= 'https://www.google.com/calendar/feeds/';
	const SCOPE_CONTACTS 		= 'https://www.google.com/m8/feeds/';
	const SCOPE_CHROME 			= 'https://www.googleapis.com/auth/chromewebstore.readonly';
	const SCOPE_DOCUMENTS		= 'https://docs.google.com/feeds/';
	const SCOPE_DRIVE			= 'https://www.googleapis.com/auth/drive';
	const SCOPE_FINANCE			= 'https://finance.google.com/finance/feeds/';
	const SCOPE_GMAIL			= 'https://mail.google.com/mail/feed/atom';
	const SCOPE_HEALTH 			= 'https://www.google.com/health/feeds/';
	const SCOPE_H9 				= 'https://www.google.com/h9/feeds/';
	const SCOPE_MAPS			= 'https://maps.google.com/maps/feeds/';
	const SCOPE_MODERATOR 		= 'https://www.googleapis.com/auth/moderator';
	const SCOPE_OPENSOCIAL		= 'https://www-opensocial.googleusercontent.com/api/people/';
	const SCOPE_ORKUT 			= 'https://www.googleapis.com/auth/orkut';
	const SCOPE_PLUS			= 'https://www.googleapis.com/auth/plus.me';
	const SCOPE_PICASA			= 'https://picasaweb.google.com/data/';
	const SCOPE_SIDEWIKI 		= 'https://www.google.com/sidewiki/feeds/';
	const SCOPE_SITES			= 'https://sites.google.com/feeds/';
	const SCOPE_SREADSHEETS		= 'https://spreadsheets.google.com/feeds/';
	const SCOPE_TASKS			= 'https://www.googleapis.com/auth/tasks';
	const SCOPE_SHORTENER 		= 'https://www.googleapis.com/auth/urlshortener';
	const SCOPE_WAVE			= 'http://wave.googleusercontent.com/api/rpc';
	const SCOPE_WEBMASTER 		= 'https://www.google.com/webmasters/tools/feeds/';
	const SCOPE_YOUTUBE 		= 'https://gdata.youtube.com';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey = NULL;
	protected $_scopes = array(	
		'analytics' 	=> self::SCOPE_ANALYTICS,
		'base' 			=> self::SCOPE_BASE,
		'buzz' 			=> self::SCOPE_BUZZ,
		'book' 			=> self::SCOPE_BOOK,
		'blogger'		=> self::SCOPE_BLOGGER,
		'calendar' 		=> self::SCOPE_CALENDAR,
		'contacts' 		=> self::SCOPE_CONTACTS,
		'chrome' 		=> self::SCOPE_CHROME,
		'documents'		=> self::SCOPE_DOCUMENTS,
		'drive'			=> self::SCOPE_DRIVE,
		'finance'		=> self::SCOPE_FINANCE,
		'gmail'			=> self::SCOPE_GMAIL,
		'health' 		=> self::SCOPE_HEALTH,
		'h9' 			=> self::SCOPE_H9,
		'maps'			=> self::SCOPE_MAPS,
		'moderator' 	=> self::SCOPE_MODERATOR,
		'opensocial'	=> self::SCOPE_OPENSOCIAL,
		'orkut' 		=> self::SCOPE_ORKUT,
		'plus'			=> self::SCOPE_PLUS,
		'picasa'		=> self::SCOPE_PICASA,
		'sidewiki' 		=> self::SCOPE_SIDEWIKI,
		'sites'			=> self::SCOPE_SITES,
		'spreadsheets'	=> self::SCOPE_SREADSHEETS,
		'tasks'			=> self::SCOPE_TASKS,
		'shortener' 	=> self::SCOPE_SHORTENER,
		'wave'			=> self::SCOPE_WAVE,
		'webmaster' 	=> self::SCOPE_WEBMASTER,
		'youtube' 		=> self::SCOPE_YOUTUBE);
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
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
	/**
	 * Returns website login url
	 *
	 * @param string|null
	 * @param string|null
	 * @return url
	 */
	public function getLoginUrl($scope = NULL, $display = NULL) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string', 'array', 'null')	//argument 1 must be a string, array or null
			->argument(2, 'string', 'array', 'null');	//argument 2 must be a string, array or null
		
		//if scope is a key in the scopes array
		if(is_string($scope) && isset($this->_scopes[$scope])) {
			$scope = $this->_scopes[$scope];
		//if it's an array
		} else if(is_array($scope)) {
			//loop through it
			foreach($scope as $i => $key) {
				//if this is a scope key
				if(is_string($key) && isset($this->_scopes[$key])) {
					//change it
					$scope[$i] = $this->_scopes[$key];
				}
			}
		}
		
		return parent::getLoginUrl($scope, $display);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}