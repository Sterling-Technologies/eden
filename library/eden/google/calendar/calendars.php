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
	const URL_CALENDAR_CLEAR	= 'https://www.googleapis.com/calendar/v3/calendars/primary/clear';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_timeZone			= NULL;
	protected $_calendarId			= NULL;
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
	 * @return null
	 */
	public function clear() {
		//populate fields
		$query = array(self::CALENDAR_ID => 'primary');
		
		return $this->_post(self::URL_CALENDAR_CLEAR, $query);
	}
	
	/**
	 * Creates a secondary calendar.
	 *
	 * @return array
	 */
	public function create() {
		//populate fields
		$query = array(
			self::ETAG			=> $this->_etag,
			self::ID			=> $this->_id,
			self::KIND			=> $this->_kind,
			self::SUMMARY		=> $this->_summary,
			self::DESCRIPTION	=> $this->_description,
			self::LOCATION		=> $this->_location,
			self::TIMEZONE		=> $this->_timeZone);
		
		return $this->_post(self::URL_CALENDAR_CREATE, $query);
	}
	
	/**
	 * Deletes a secondary calendar.
	 *
	 * @return null
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CALENDAR_GET, $this->_calendarId));
	}
	
	/**
	 * Return specific calendar
	 *
	 * @return array
	 */
	public function getCalendars() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_GET, $this->_calendarId));
	}
	
	/**
	 * Updates metadata for a calendar. 
	 * This method supports patch semantics.
	 *
	 * @return array
	 */
	public function patch() {
		//populate fields
		$query = array(
			self::ETAG		=> $this->_etag,
			self::ID		=> $this->_id,
			self::KIND		=> $this->_kind,
			self::SUMARRY	=> $this->_summary);
		
		return $this->_patch(sprintf(self::URL_CALENDAR_GET, urlencode($this->_calendarId)), $query);
	}
	
	/**
	 * Set calendar id
	 *
	 * @param string
	 * @return this
	 */
	public function setCalendarId($calendarId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calendarId = $calendarId;
		
		return $this;
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
	 * Set etag
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
	 * Set id
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
	 * @param string
	 * @return this
	 */
	public function setKind($kind) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_kind = $kind;
		
		return $this;
	}
	
	/**
	 * Set location
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
	 * @param string
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
	 * @return array
	 */
	public function update() {
		//populate fields
		$query = array(
			self::ETAG		=> $this->_etag,
			self::ID		=> $this->_id,
			self::KIND		=> $this->_kind,
			self::SUMARRY	=> $this->_summary);
		
		return $this->_put(sprintf(self::URL_CALENDAR_GET, urlencode($this->_calendarId)), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}