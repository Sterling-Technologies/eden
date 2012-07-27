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
	protected $_settingId	= NULL;
	 
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
	 * Returns all user settings for the authenticated user. 
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_SETTINGS_GET, $this->_settingId));
	}
	
	/**
	 * Set calendar id
	 *
	 * @param string
	 * @return this
	 */
	public function setSettingId($settingId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_settingId = $settingId;
		
		return $this;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}