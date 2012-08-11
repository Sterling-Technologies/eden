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
	protected $_location	= NULL;
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
	 * Create event
	 *
	 * @param string* Title of the calendar
	 * @param string* Calendar identifier.
	 * @return array
	 */
	public function create($summary, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(
			self::SUMMARY	=> $summary,
			self::LOCATION	=> $this->_location,	//optional
			self::START		=> $this->_start,		//optional
			self::END		=> $this->_end,			//optional
			self::ATTENDEES	=> $this->_attendees);	//optional
		
		return $this->_post(sprintf(self::URL_CALENDAR_EVENT, $calendarId), $query);
	}
	
	/**
	 * Delete Calendar specific events
	 *
	 * @param string Event identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function delete($eventId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_CALENDAR, $calendarId, $eventId), $url);
	}
	
	/**
	 * Return all event fo calendar
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getEvent($calendarId = self::PRIMARY) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_EVENT, $calendarId));
	}
	
	/**
	 * Return instances of specific event
	 *
	 * @param string Event identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getInstances($eventId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_INSTANCES, $calendarId, $eventId));
	}
	
	/**
	 * Return specific event
	 *
	 * @param string Event identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getSpecificEvent($eventId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR, $calendarId, $eventId));
	}
	
	/**
	 * Import an event of a calendar
	 *
	 * @param  string|integer The (exclusive) start time of the event
	 * @param  string|integer The (exclusive) end time of the event
	 * @param  string Event ID in the iCalendar format.
	 * @param  string Calendar identifier
	 * @return array
	 */
	public function importEvent($start, $end, $importId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string', 'int')	//argument 1 must be a string or integer
			->argument(2, 'string', 'int')	//argument 2 must be a string or integer
			->argument(3, 'string')			//argument 3 must be a string
			->argument(4, 'string');		//argument 4 must be a string
		
		if(is_string($start) ) {
			$start = strtotime($start);
		}
		
		if(is_string($end) ) {
			$end = strtotime($end);
		}
		
		$end['dateTime']	= date('c', $end);
		$start['dateTime']	= date('c', $start);
		
		//populate fields
		$query = array(
			self::START	=> $start,
			self::END	=> $end,
			self::UID	=> $importId);
		
		return $this->_post(sprintf(self::URL_CALENDAR_IMPORT, $calendarId), $query);
	}	
	
	/**
	 * Moves an event to another calendar
	 *
	 * @param string Calendar identifier of the target calendar where the event is to be moved to.
	 * @param string Event identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function moveEvent($destination, $eventId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
			
		//populate fields
		$query = array(self::DESTINATION => $destination);
		
		return $this->_customPost(sprintf(self::URL_CALENDAR_MOVE, $calendarId, $eventId), $query);
	}
	
	/**
	 * Updates an entry on the user's calendar list. 
	 * This method supports patch semantics.
	 *
	 * @param string Event identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function patch($eventId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(
			self::END			=> $this->_end,			//optional
			self::START			=> $this->_start,		//optional
			self::DESCRIPTION	=> $this->_description,	//optional
			self::COLOR_ID		=> $this->_colorId,		//optional
			self::CREATOR		=> $this->_creator,		//optional
			self::KIND			=> $this->_kind,		//optional
			self::LOCATION		=> $this->_location,	//optional
			self::ORGANIZER		=> $this->_organizer,	//optional
			self::REMINDERS		=> $this->_reminders,	//optional
			self::STATUS		=> $this->_status);		//optional
		
		return $this->_patch(sprintf(self::URL_CALENDAR, $calendarId, $eventId), $query);
	}
	
	/**
	 * Creates an event based on a simple text string
	 *
	 * @param string The text describing the event to be created.
	 * @param string Calendar identifier
	 * @return array
	 */
	public function quickCreate($text, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//populate fields
		$query = array(self::TEXT => $text);
		
		return $this->_customPost(sprintf(self::URL_QUICK_CREATE_EVENT, $calendarId), $query);
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
	 * Set the color of the event.
	 *
	 * @param string ID referring to an entry in the "event" section of the colors definition 
	 * @return this
	 */
	public function setCreator($creator) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_creator = $creator;
		
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
	 * Update Calendar specific events
	 *
	 * @param string Event identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function update($eventId, $calendarId = self::PRIMARY) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//populate fields
		$query = array(
			self::END			=> $this->_end,			//optional
			self::START			=> $this->_start,		//optional
			self::DESCRIPTION	=> $this->_description,	//optional
			self::COLOR_ID		=> $this->_colorId,		//optional
			self::CREATOR		=> $this->_creator,		//optional
			self::KIND			=> $this->_kind,		//optional
			self::LOCATION		=> $this->_location,	//optional
			self::ORGANIZER		=> $this->_organizer,	//optional
			self::REMINDERS		=> $this->_reminders,	//optional
			self::STATUS		=> $this->_status);		//optional
		
		return $this->_put(sprintf(self::URL_CALENDAR, $calendarId, $eventId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}