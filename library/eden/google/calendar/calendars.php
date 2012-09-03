<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar Calendars Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_Calendars extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_GET		= 'https://www.googleapis.com/calendar/v3/calendars/%s';
	const URL_CALENDAR_CREATE 	= 'https://www.googleapis.com/calendar/v3/calendars';
	const URL_CALENDAR_CLEAR	= 'https://www.googleapis.com/calendar/v3/calendars/%s/clear';
	
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
	 * Clears a primary calendar. This operation 
	 * deletes all data associated with the primary 
	 * calendar of an account and cannot be undone
	 *
	 * @param string Calendar identifier
	 * @return null
	 */
	public function clear($calendarId = self::PRIMARY) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_post(sprintf(self::URL_CALENDAR_CLEAR, calendarId));
	}
	
	/**
	 * Creates a secondary calendar.
	 *
	 * @param string* Title of the calendar.
	 * @return array
	 */
	public function create($summary) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::SUMMARY] = $summary;
		
		return $this->_post(self::URL_CALENDAR_CREATE, $this->_query);
	}
	
	/**
	 * Deletes a secondary calendar.
	 *
	 * @param string Calendar identifier
	 * @return null
	 */
	public function delete($calendarid = self::PRIMARY) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_delete(sprintf(self::URL_CALENDAR_GET, $calendarId));
	}
	
	/**
	 * Return specific calendar
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getCalendars($calendarId = self::PRIMARY) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_GET, $calendarId));
	}
	
	/**
	 * Updates metadata for a calendar. 
	 * This method supports patch semantics.
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function patch($calendarId = self::PRIMARY) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_patch(sprintf(self::URL_CALENDAR_GET, $calendarId), $this->_query);
	}

	/**
	 * Set default reminders
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::DESCRIPTION] = $description;
		
		return $this;
	}
	
	/**
	 * ETag of the resource.
	 *
	 * @param string 
	 * @return this
	 */
	public function setEtag($etag) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::ETAG] = $etag;
		
		return $this;
	}
	
	/**
	 * Identifier of the calendar.
	 *
	 * @param string|integer 
	 * @return this
	 */
	public function setId($id) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		$this->_query[self::ID] = $id;
		
		return $this;
	}
	
	/**
	 * Set calendar kind
	 *
	 * @param string Type of the resource ("calendar#calendar").
	 * @return this
	 */
	public function setKind($kind) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::KIND] = $kind;
		
		return $this;
	}
	
	/**
	 * Set geographic location of the 
	 8 calendar as free-form text.
	 *
	 * @param string
	 * @return this
	 */
	public function setLocation($location) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::LOCATION] = $location;
		
		return $this;
	}
	
	/**
	 * Set summary
	 *
	 * @param string
	 * @return this
	 */
	public function setSummary($summary) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::SUMMARY] = $summary;
		
		return $this;
	}
	
	/**
	 * Set time zone
	 *
	 * @param string The time zone of the calendar.
	 * @return this
	 */
	public function setTimeZone($timeZone) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::TIMEZONE] = $timeZone;
		
		return $this;
	}
	
	/**
	 * Update Calendar
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function update($calendarId = self::PRIMARY) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_put(sprintf(self::URL_CALENDAR_GET, $calendarId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}