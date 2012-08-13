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
	protected $_timeZone			= NULL;
	protected $_etag				= NULL;
	protected $_id					= NULL;
	protected $_kind				= NULL;
	protected $_location			= NULL;
	protected $_summary				= NULL;
	protected $_description			= NULL;
	
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
		
		//populate fields
		$query = array(
			self::SUMMARY		=> $summary,
			self::ETAG			=> $this->_etag,		//optional
			self::ID			=> $this->_id,			//optional
			self::KIND			=> $this->_kind,		//optional
			self::DESCRIPTION	=> $this->_description,	//optional
			self::LOCATION		=> $this->_location,	//optional
			self::TIMEZONE		=> $this->_timeZone);	//optional
		
		return $this->_post(self::URL_CALENDAR_CREATE, $query);
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
		
		//populate fields
		$query = array(
			self::ETAG		=> $this->_etag,		//optional
			self::ID		=> $this->_id,			//optional
			self::KIND		=> $this->_kind,		//optional
			self::SUMARRY	=> $this->_summary);	//optional
		
		return $this->_patch(sprintf(self::URL_CALENDAR_GET, $calendarId), $query);
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
		$this->_description = $description;
		
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
		$this->_etag = $etag;
		
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
		$this->_id = $id;
		
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
		$this->_kind = $kind;
		
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
		$this->_location = $location;
		
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
		$this->_summary = $summary;
		
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
		$this->_timeZone = $timeZone;
		
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
		
		//populate fields
		$query = array(
			self::ETAG		=> $this->_etag,		//optional
			self::ID		=> $this->_id,			//optional
			self::KIND		=> $this->_kind,		//optional
			self::SUMARRY	=> $this->_summary);	//optional
		
		return $this->_put(sprintf(self::URL_CALENDAR_GET, $calendarId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}