<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Class for adding Event on Google Calendar
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Calendar_Event_Recurring extends Eden_Google_Base {
	/* Constants
	-------------------------------*/	
	const URL_GET_RECURRING_INSTANCES		= 'https://www.googleapis.com/calendar/v3/%s/events/%s/instances';
	const URL_CREATE_EXEPTIONS				= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_calendarId 					= Eden_Google_Calendar::DEFAULT_CALENDAR;
	protected $_eventId 					= NULL;
	protected $_kind						= NULL;
	protected $_instanceId					= NULL;
	protected $_instanceTag					= NULL;
	protected $_status						= NULL;
	protected $_htmlLink					= NULL;
	protected $_created						= NULL;
	protected $_updated						= NULL;
	protected $_summary						= NULL;
	protected $_location					= NULL;
	protected $_creator						= NULL;
	protected $_recurringEventId			= NULL;
	protected $_originalStartTime			= NULL;
	protected $_organizer					= array();
	protected $_start						= array();
	protected $_end							= array();
	protected $_calUid						= NULL;
	protected $_sequence					= NULL;
	protected $_attendees					= array();
	protected $_guestsCanInviteOthers		= false;
	protected $_guestsCanSeeOtherGuests		= false;
	protected $_reminder 					= array();
	
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
	
	/**
	 * sets the event kind
	 *
	 * @param bool
	 * @return this
	 */
	public function setKind($kind = false) {
		Eden_Google_Error::i()->argument(1, 'bool');
		if($kind != false) {
			$this->_kind = $kind;
		}
		
		return $this;
	}
	
	/**
	 * sets the instance id
	 *
	 * @param string
	 * @return this
	 */
	public function setInstanceId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_instanceId = $id;
		
		return $this;
	}
	
	/**
	 * sets the instance tag
	 *
	 * @param string
	 * @return this
	 */
	public function setInstanceTag($tag) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_instanceTag = $tag;
		
		return $this;
	}
	
	/**
	 * sets the event status
	 *
	 * @param string
	 * @return this
	 */
	public function setStatus($status) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_status = $status;
		
		return $this;
	}
	
	/**
	 * sets the event html link
	 *
	 * @param string
	 * @return this
	 */
	public function setHtmlLink($link) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_htmlLink = $link;
		
		return $this;
	}
	
	/**
	 * sets the event date created
	 *
	 * @param string|int
	 * @return this
	 */
	public function setCreated($created) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($created)) {
			$created = strtotime($created);
		}
		
		$this->_created = date('c', $created);
		
		return $this;
	}
	
	/**
	 * sets the event date updated
	 *
	 * @param string|int
	 * @return this
	 */
	public function setUpdated($updated) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($updated)) {
			$update = strtotime($updated);
		}
		
		$this->_updated = date('c', $updated);
		
		return $this;
	}
	
	/**
	 * sets the event summary
	 *
	 * @param string
	 * @return this
	 */
	public function setSummary($summary) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_summary = $summary;
		
		return $this;
	}
	
	/**
	 * sets the event location
	 *
	 * @param string
	 * @return this
	 */
	public function setLocation($location) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_location = $location;
		
		return $this;
	}
	
	/**
	 * sets the event creator
	 *
	 * @param string
	 * @return this
	 */
	public function setCreator($creator) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_creator = array('email' => $creator);
		
		return $this;
	}
	
	/**
	 * sets the reecurring event id
	 *
	 * @param string
	 * @return this
	 */
	public function setRecurringEventId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_recurringEventId = $id;
		
		return $this;
	}
	
	/**
	 * sets the event original start time
	 *
	 * @param string
	 * @return this
	 */
	public function setOriginalStartTime($start) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$this->_originalStartTime = date('c', $start);
		
		return $this;
	}
	
	/**
	 * sets the event organizer
	 *
	 * @param string
	 * @param string|bool
	 * @return this
	 */
	public function setOrganizer($email, $name = false) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'bool', 'string');
		$this->_organizer = array(
				'email'			=> $email,
				'displayName'	=> $name);
		
		if(!$name) {
			unset($this->_organizer['displayName']);
		}
		
		return $this;
	}
	
	/**
	 * sets the event start time
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setStart($start) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$this->_start = array('dateTime' => date('c', $start));
		
		return $this;
	}
	
	/**
	 * sets the event end time
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setEnd($end) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$this->_end = array('dateTimee' => date('c', $end));
		
		return $this;
	}
	
	/**
	 * sets the event iCalUID
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setCalUId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calUId = $id;
		
		return $this;
	}
	
	/**
	 * sets the event sequence
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setSequence($sequence = '0') {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		$this->_sequence = $sequence;
		
		return $this;
	}
	
	/**
	 * add event attendee
	 *
	 * @param string
	 * @param string|bool
	 * @param string|bool
	 * @param bool
	 * @param bool
	 * @return this
	 */
	 
	public function addAttendee($email, $name = false, $responseStatus = false, $organizer = false, $self = false) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'bool')
			->argument(3, 'string', 'bool')
			->argument(4, 'bool')
			->argument(5, 'bool');
			
		$attendee = array(
			'email'				=> $email,
			'displayName'		=> $name,
			'responseStatus'	=> $responseStatus,
			'organizer'			=> $organizer,
			'self'				=> $self);
		
		
		if(!$name) {
			unset($attendee['displayName']);
		}
		
		if(!$responseStatus) {
			unset($attendee['responseStatus']);
		}
		
		if(!$organizer) {
			unset($attendee['organizer']);
		}
		
		if(!$self) {
			unset($attendee['self']);
		}
		
		$this->_attendees[] = $attendee;
		
		return $this;
	}
	
	/**
	 * sets if guests can invite others on event
	 *
	 * @param bool
	 * @return this
	 */
	 
	public function guestsCanInviteOthers($canInvite = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		$this->_guestsCanInviteOthers = $canInvite;
		
		return $this;
	}
	
	/**
	 * sets if guests can see other guests on event
	 *
	 * @param bool
	 * @return this
	 */
	 
	public function guestsCanSeeOtherGuests($canSee = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		$this->_guestsCanSeeOtherGuests = $canSee;	
		
		return $this;
	}
	
	/**
	 * sets the event id
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setReminders($reminders = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		$this->_reminders = array('useDefault' => $reminders);	
		
		return $this;
	}
	
	/**
	 * sets the event id
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setEventId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_eventId = $id;
		
		return $this;
	}
	
	/**
	 * sets the calendar id
	 *
	 * @param string
	 * @return this
	 */
	 
	public function setCalendarId($id = false) {
		Eden_Google_Error::i()->argument(1, 'string');
		if($id) {
			$this->_calendarId = $id;	
		}
		
		return $this;
	}
	
	/**
	 * crate exception
	 * TODO: fix
	 * @return this
	 */
	 
	public function createException() {
			$query = array(
			'kind'						=> $this->_kind,
			'id'						=> $this->_instanceId,
			'etag'						=> $this->_instanceTag,
			'status'					=> $this->_status,
			'htmlLink'					=> $this->_htmlLink,
			'created'					=> $this->_created,
			'updated'					=> $this->_updated,
			'summary'					=> $this->_summary,
			'location'					=> $this->_location,
			'creator'					=> $this->_creator,
			'organizer'					=> $this->_organizer,
			'start'						=> $this->_start,
			'end'						=> $this->_end,
			'iCalUID'					=> $this->_calUId,
			'sequence'					=> $this->_sequence,
			'attendees'					=> $this->_attendees,
			'guestsCanInviteOthers'		=> $this->_guestsCanInviteOthers,
			'guestsCanSeeOtherGuests'	=> $this->_guestsCanSeeOtherGuests,
			'reminder'					=> array('useDefault' => $this->_reminder));
			
			
			$url = sprintf(self::URL_CREATE_EXEPTIONS, $this->_calendarId, $this->_instanceId);
			
			return $this->_put($url, $query);
	}
	
	/**
	 * gets the recurring instaces
	 *
	 * @return this
	 */
	public function getRecurringInstances() {
		$url = sprintf(self::URL_GET_RECURRING_INSTANCES, $this->_calendarId, $this->_eventId);

		return $this->_getResponse($url);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}