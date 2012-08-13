<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar Color Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_Color extends Eden_Google_Base {
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
	 * Returns the color definitions for 
	 * calendars and events. 
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_CALENDAR_COLOR);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}