<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google calendar
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Calendar extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_LIST 	= 'https://www.googleapis.com/calendar/v3/users/%s/calendarList';
	const DEFAULT_USER			= 'me';
	const DEFAULT_CALENDAR		= 'primary';
	
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
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Google Create Event	 
	 *
	 * @return Eden_Google_Calendar_Event_Create
	 */
	public function createEvent() {
		return Eden_Google_Calendar_Event_Create::i($this->_token);
	}
	
	public function getCalendarList($user = self::DEFAULT_USER) {
		$url = sprintf(self::URL_CALENDAR_LIST, $user);
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		return $this->_getResponse($url);
	}
			
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}