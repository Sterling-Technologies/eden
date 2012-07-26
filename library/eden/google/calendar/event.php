<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar Event Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_Event extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_EVENT		= 'https://www.googleapis.com/calendar/v3/calendars/%s/events';
	const URL_CALENDAR				= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s';
	const URL_CALENDAR_IMPORT		= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/import';
	const URL_CALENDAR_MOVE			= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s/move';
	const URL_QUICK_CREATE_EVENT	= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/quickAdd';
	const URL_CALENDAR_INSTANCES	= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s/instances';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_summary		= NULL;
	protected $_location	= NULL;
	protected $_eventId		= NULL;
	protected $_importId	= NULL;
	protected $_destination	= NULL;
	protected $_description	= NULL;
	protected $_colorId		= NULL;
	protected $_creator		= NULL;
	protected $_kind		= NULL;
	protected $_organizer	= NULL;
	protected $_reminders	= NULL;
	protected $_status		= NULL;
	
	protected $_start 		= array();
	protected $_end 		= array();
	protected $_attendees 	= array();
	protected $_calendarId 	= 'primary';
	
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
	 * Set the summary for event
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
	 * Set the location for event
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
	 * Set start for event
	 *
	 * @param string|int
	 * @return this
	 */
	public function setStart($start) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$this->_start['dateTime'] = date('c', $start);
		
		return $this;
	}
	
	/**
	 * sets the end for event
	 *
	 * @param string|int
	 * @return this
	 */
	public function setEnd($end) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$this->_end['dateTime'] = date('c', $end);
		
		return $this;
	}
	
	/**
	 * sets the attendees for event
	 *
	 * @param string|array
	 * @return this
	 */
	public function addAttendee($attendee) {
		//argument 1 must be a string or array
		Eden_Google_Error::i()->argument(1, 'string', 'array');
		
		if(!is_array($attendee)) {
			$attendee = array($attendee);
		}
		
		foreach($attendee as $user) {
			$this->_attendees[] = array('email' => $user);
		}
		
		return $this;
	}
	
	/**
	 * sets the calendar id for event
	 *
	 * @param int|string
	 * @return this
	 */
	public function setCalendarId($calendarId) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		$this->_calendarId = $calendarId;
		
		return $this;
	}
	
	/**
	 * Set event id
	 *
	 * @param int|string
	 * @return this
	 */
	public function setEventId($eventId) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		$this->_eventId = $eventId;
		
		return $this;
	}
	
	/**
	 * Set import id (iCalUID) of an event
	 *
	 * @param int|string
	 * @return this
	 */
	public function setImportId($importId) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		$this->_importId = $importId;
		
		return $this;
	}
	
	/**
	 * Set destination or calendar id
	 *
	 * @param int|string
	 * @return this
	 */
	public function setDestination($destination) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		$this->_destination = $destination;
		
		return $this;
	}
	
	/**
	 * Set event description
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
	 * Set event color id
	 *
	 * @param integer
	 * @return this
	 */
	public function setColorId($colorId) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_colorId = $colorId;
		
		return $this;
	}
	
	/**
	 * Set event creator
	 *
	 * @param string
	 * @return this
	 */
	public function setCreator($creator) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_creator = $creator;
		
		return $this;
	}
	
	/**
	 * Set event kind
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
	 * Set event organizer
	 *
	 * @param string
	 * @return this
	 */
	public function setOrganizer($organizer) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_organizer = $organizer;
		
		return $this;
	}
	
	/**
	 * Set event reminders
	 *
	 * @param string
	 * @return this
	 */
	public function setReminders($reminders) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_reminders = $reminders;
		
		return $this;
	}
	
	/**
	 * Set event status
	 *
	 * @param string
	 * @return this
	 */
	public function setStatus($status) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_status = $status;
		
		return $this;
	}
	
	/**
	 * Import an event of a calendar
	 *
	 * @return array
	 */
	public function importEvent() {
		//populate fields
		$query = array(
			self::START	=> $this->_start,
			self::END	=> $this->_end,
			self::UID	=> $this->_importId);
		
		return $this->_post(sprintf(self::URL_CALENDAR_IMPORT, $this->_calendarId), $query);
	}	
	
	/**
	 * Return specific event
	 *
	 * @return array
	 */
	public function getSpecificEvent() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR, $this->_calendarId, $this->_eventId));
	}
	
	/**
	 * Return all event fo calendar
	 *
	 * @return array
	 */
	public function getEvent() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_EVENT, $this->_calendarId));
	}
	
	/**
	 * Return instances of specific event
	 *
	 * @return array
	 */
	public function getInstances() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_INSTANCES, $this->_calendarId, $this->_eventId));
	}
	
	/**
	 * Delete Calendar specific events
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CALENDAR, $this->_calendarId, $this->_eventId), $url);
	}
	
	/**
	 * Creates an event based on a simple text string
	 *
	 * @return array
	 */
	public function quickCreate($text) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		//populate fields
		$query = array(self::TEXT => $text);
		
		return $this->_customPost(sprintf(self::URL_QUICK_CREATE_EVENT, $this->_calendarId), $query);
	}
	
	/**
	 * Moves an event to another calendar
	 *
	 * @return array
	 */
	public function moveEvent() {
		//populate fields
		$query = array(self::DESTINATION => $this->_destination);
		
		return $this->_customPost(sprintf(self::URL_CALENDAR_MOVE, $this->_calendarId, $this->_eventId), $query);
	}
	
	/**
	 * Create event
	 *
	 * @return array
	 */
	public function create() {
		//populate fields
		$query = array(
			self::SUMMARY	=> $this->_summary,
			self::LOCATION	=> $this->_location,
			self::START		=> $this->_start,
			self::END		=> $this->_end,
			self::ATTENDEES	=> $this->_attendees);
		
		return $this->_post(sprintf(self::URL_CALENDAR_EVENT, $this->_calendarId), $query);
	}
	
	/**
	 * Update Calendar specific events
	 *
	 * @return array
	 */
	public function update() {
		//populate fields
		$query = array(
			self::END			=> $this->_end,
			self::START			=> $this->_start,
			self::DESCRIPTION	=> $this->_description,
			self::COLOR_ID		=> $this->_colorId,
			self::CREATOR		=> $this->_creator,
			self::KIND			=> $this->_kind,
			self::LOCATION		=> $this->_location,
			self::ORGANIZER		=> $this->_organizer,
			self::REMINDERS		=> $this->_reminders,
			self::STATUS		=> $this->_status);
		
		return $this->_put(sprintf(self::URL_CALENDAR, urlencode($this->_calendarId), urlencode($this->_eventId)), $query);
	}
	
	/**
	 * Updates an entry on the user's calendar list. 
	 * This method supports patch semantics.
	 *
	 * @return array
	 */
	public function patch() {
		//populate fields
		$query = array(
			self::END			=> $this->_end,
			self::START			=> $this->_start,
			self::DESCRIPTION	=> $this->_description,
			self::COLOR_ID		=> $this->_colorId,
			self::CREATOR		=> $this->_creator,
			self::KIND			=> $this->_kind,
			self::LOCATION		=> $this->_location,
			self::ORGANIZER		=> $this->_organizer,
			self::REMINDERS		=> $this->_reminders,
			self::STATUS		=> $this->_status);
		
		return $this->_patch(sprintf(self::URL_CALENDAR, urlencode($this->_calendarId), urlencode($this->_eventId)), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}