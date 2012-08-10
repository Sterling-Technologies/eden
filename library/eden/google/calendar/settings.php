<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar Settings Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_Settings extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_SETTINGS 	= 'https://www.googleapis.com/calendar/v3/users/me/settings';
	const URL_CALENDAR_SETTINGS_GET = 'https://www.googleapis.com/calendar/v3/users/me/settings/%s';
	
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
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Returns all user settings for the authenticated user. 
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_CALENDAR_SETTINGS);
	}
	 
	/**
	 * Returns a single user setting
	 *
	 * @param string Name of the user setting.
	 * @return array
	 */
	public function getSpecific($setting) {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_SETTINGS_GET, $setting));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}