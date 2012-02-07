<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Class for updating Event on Google Calendar
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Calendar_Event_Update extends Eden_Google_Base {
	/* Constants
	-------------------------------*/	
	const URL_UPDATE_EVENT					= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s';
	const URL_CHANGE_ORGANIZER				= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s/move?destination=%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_summary					= NULL;
	protected $_location				= NULL;
	protected $_organizer				= NULL;
	protected $_calUId					= NULL;
	protected $_eventId					= NULL;
	protected $_etag					= NULL;
	protected $_created					= NULL;
	protected $_htmlLink				= NULL;
	protected $_updated					= NULL;
	protected $_creator					= array();
	protected $_start 					= array();
	protected $_end 					= array();
	protected $_attendees 				= array();
	protected $_calendarId 				= Eden_Google_Calendar::DEFAULT_CALENDAR;
	protected $_kind					= 'calendar#event';
	protected $_status					= 'confirmed';
	protected $_reminder				= true;
	protected $_guestsCanInviteOthers	= false;
	protected $_guestsCanSeeOtherGuests	= false;
	protected $_sequence				= 0;
	
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
	 * sets the kind for event
	 *
	 * @param string
	 * @return this
	 */
	public function setKind($kind = NULL) {
		Eden_Google_Error::i()->argument(1, 'string');
		if($kind != NULL) {
			$this->_kind = $kind;
		}
		
		return $this;
	}
	
	/**
	 * sets the eventId for event
	 *
	 * @param string
	 * @return this
	 */
	public function setEventId($id) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		$this->_eventId = $id;
		
		return $this;
	}
	
	/**
	 * sets the event tag for event
	 *
	 * @param string
	 * @return this
	 */
	public function setEventTag($tag) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_etag = $tag;
		
		return $this;
	}
	
	/**
	 * sets the status for event
	 *
	 * @param string
	 * @return this
	 */
	public function setSstatus($status = NULL) {
		Eden_Google_Error::i()->argument(1, 'string');
		if($status == NULL) {
			$this->_status = $status;
		}
		
		return $this;
	}
	
	/**
	 * sets the html link for event
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
	 * sets the created date for event
	 *
	 * @param string
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
	 * sets the updated date for event
	 *
	 * @param string
	 * @return this
	 */
	public function setUpdated($updated = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($updated) && $updated != NULL) {
			$updated = strtotime($updated);
			$this->_updated = date('c', $updated);
		}
		
		return $this;
	}
	
	/**
	 * sets the summary for event
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
	 * sets the location for event
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
	 * sets the creator of event
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
	 * sets the organizer of the event
	 *
	 * @param string
	 * @return this
	 */
	public function setOrganizer($email, $name = NULL) {
		Eden_Google_Error::i()->argument(1, 'string');
		Eden_Google_Error::i()->argument(2, 'string', 'bool');
		$this->_organizer = array(
				'email'			=> $email,
				'displayName'	=> $name);
	
		if($name == NULL) {
			unset($this->_organizer['displayName']);
		}
		
		
		return $this;
	}
	
	/**
	 * sets start for event
	 *
	 * @param string|int
	 * @return this
	 */
	public function setStart($start) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$this->_start['dateTime'] = '2012-02-03T10:00:00.000-07:00';
		
		return $this;
	}
	
	/**
	 * sets the end for event
	 *
	 * @param string|int
	 * @return this
	 */
	public function setEnd($end) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$this->_end['dateTime'] = '2012-02-03T10:25:00.000-07:00';
		
		return $this;
	}
	
	/**
	 * sets the calendar id for event
	 *
	 * @param int
	 * @return this
	 */
	public function setCalUId($id) {
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		$this->_calUId = $id;
		
		return $this;
	}
	
	/**
	 * sets the calendar id for event
	 *
	 * @param int
	 * @return this
	 */
	public function setSequence($sequence) {
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_sequence = $sequence;
		
		return $this;
	}
	
	/**
	 * sets the attendees for event
	 *
	 * @param string
	 * @return this
	 */
	public function addAttendee($email, $name, $reponseStatus, $organizer = false, $self = false) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'bool')
			->argument(3, 'string', 'bool')
			->argument(4, 'bool')
			->argument(5, 'bool');
			
		$attendee = array(
			'email'			=> $email,
			'displayName'	=> $name,
			'reponseStatus'	=> $reponseStatus,
			'organizer'		=> $organizer,
			'self'			=> $self);
		
		if($organizer == false) {
			unset($attendee['organizer']);	
		}
		
		if($self == false) {
			unset($attendee['self']);
		}
		
		if($name = false) {
			unset($attendee['displayName']);
		}
		
		$this->_attendees[] = $attendee;

		return $this;
	}
	
	/**
	 * sets the calendar id for event
	 *
	 * @param int
	 * @return this
	 */
	public function setCalendar($id) {
		Eden_Google_Error::i()->argument(1, 'int', 'string');
		$this->_calendarId = $id;
		
		return $this;
	}
	
	/**
	 * sets if guests can invite others on this event
	 *
	 * @param int
	 * @return this
	 */
	public function guestCanInviteOthers($canInvite = false) {
		Eden_Google_Error::i()->argument(1, 'bool');
		if($canInvite != false) {
			$this->_guestsCanInviteOthers = $canInvite;
		}
		
		return $this;
	}
	
	/**
	 * sets if guests can invite others on this event
	 *
	 * @param int
	 * @return this
	 */
	public function guestsCanSeeOtherGuests($guestsCanseeOtherGuests = false) {
		Eden_Google_Error::i()->argument(1, 'bool');
		if($guestsCanseeOtherGuests != false) {
			$this->_guestsCanSeeOtherGuests = $guestsCanseeOtherGuests;
		}
		
		return $this;
	}
	
	/**
	 * sets if guests can invite others on this event
	 *
	 * @param int
	 * @return this
	 */
	public function setReminder($reminder = false) {
		Eden_Google_Error::i()->argument(1, 'bool');
		if($reminder != false) {
			$this->_reminder = $reminder;
		}
		
		return $this;
	}
	
	/**
	 * update event
	 * TODO: fix
	 * @return array
	 */
	public function update() {
		$query = array(
			'kind'						=> $this->_kind,
			'id'						=> $this->_eventId,
			'etag'						=> $this->_etag,
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
			'reminder'					=> array('useDefault' => $this->_reminder)
			);
		
		return $this->_put(sprintf(self::URL_UPDATE_EVENT, $this->_calendarId, $this->_eventId), $query);
	}
	
	public function changeOrganizer($destinationId) {
		Eden_Google_Error::i()->argument(1, 'string');
		
		$query = array(
			'kind'						=> $this->_kind,
			'id'						=> $this->_eventId,
			'etag'						=> $this->_etag,
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
			'reminder'					=> array('useDefault' => $this->_reminder)
			);
		
		return $this->_post(sprintf(self::URL_UPDATE_EVENT, $this->_calendarId, $this->_eventId, $destinationId), $query);
	}
			
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}