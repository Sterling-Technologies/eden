<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar API Factory
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_COLOR = 'https://www.googleapis.com/calendar/v3/colors';
	
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
	 * Returns Google acl
	 *
	 * @return Eden_Google_Calendar_acl
	 */
	public function acl() {
		return Eden_Google_Calendar_Acl::i($this->_token);
	}
	
	/**
	 * Returns Google Calendars
	 *
	 * @return Eden_Google_Calendar_Calendars
	 */
	public function calendars() {
		return Eden_Google_Calendar_Calendars::i($this->_token);
	}
	
	/**
	 * Returns the color definitions for 
	 * calendars and events. 
	 *
	 * @return array
	 */
	public function getColors() {
		return $this->_getResponse(self::URL_CALENDAR_COLOR);
	}
	
	/**
	 * Returns Google Event
	 *
	 * @return Eden_Google_Calendar_Event
	 */
	public function event() {
		return Eden_Google_Calendar_Event::i($this->_token);
	}
	
	/**
	 * Returns Google freebusy
	 *
	 * @return Eden_Google_Calendar_freebusy
	 */
	public function freebusy() {
		return Eden_Google_Calendar_Freebusy::i($this->_token);
	}
	
	/**
	 * Returns Google List
	 *
	 * @return Eden_Google_Calendar_List
	 */
	public function lists() {
		return Eden_Google_Calendar_List::i($this->_token);
	}
	
	/**
	 * Returns Google setting
	 *
	 * @return Eden_Google_Calendar_Settings
	 */
	public function settings() {
		return Eden_Google_Calendar_Settings::i($this->_token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}