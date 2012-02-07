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
class Eden_Google_Calendar_Event extends Eden_Google_Base {
	/* Constants
	-------------------------------*/	
	const URL_CREATE_EVENT					= 'https://www.googleapis.com/calendar/v3/calendars/%s/events';
	const URL_QUICK_CREATE_EVENT			= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/quickAdd?text=%s';
	const URL_CHANGE_ORGANIZER				= 'https://www.googleapis.com/calendar/v3/calendars/%s/events/%s/move?destination=%s';
	const URL_GET_RECURRING_INSTANCES		= 'https://www.googleapis.com/calendar/v3/%s/events/%s/instances';
	const SEARCH_QUERY						= 'q';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_summary						= NULL;
	protected $_location					= NULL;
	protected $_start 						= array();
	protected $_end 						= array();
	protected $_attendees 					= array();
	protected $_calendarId 					= Eden_Google_Calendar::DEFAULT_CALENDAR;
	protected $_organizer					= NULL;
	protected $_calUId						= NULL;
	protected $_eventId 					= NULL;
	protected $_kind						= NULL;
	protected $_instanceId					= NULL;
	protected $_instanceTag					= NULL;
	protected $_status						= NULL;
	protected $_htmlLink					= NULL;
	protected $_created						= NULL;
	protected $_updated						= NULL;
	protected $_creator						= NULL;
	protected $_recurringEventId			= NULL;
	protected $_originalStartTime			= NULL;
	protected $_sequence					= NULL;
	protected $_guestsCanInviteOthers		= false;
	protected $_guestsCanSeeOtherGuests		= false;
	protected $_reminder 					= array();
	protected $_etag						= NULL;
	protected $_destinationId				= NULL;
	protected $_text						= NULL;
	
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
		Eden_Google_Error::i()->argument(1, 'string');
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
	 * sets status of event
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
	 * sets the created date for event
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
	 * sets the updated date for event
	 *
	 * @param string|int
	 * @return this
	 */
	public function setUpdated($updated) {
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
		$this->_creator = array(Eden_Google_Calendar::EMAIL => $creator);
		
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
		
		$this->_start[Eden_Google_Calendar::DATETIME] = date('c', $start);
		
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
		
		$this->_end[Eden_Google_Calendar::DATETIME] = date('c', $end);
		
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
	 * @param string|null
	 * @param string|null
	 * @param string|bool
	 * @param string|bool
	 * @return this
	 */
	public function addAttendee($email, $name = NULL, $reponseStatus = NULL, $organizer = false, $self = false) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null')
			->argument(3, 'string', 'null')
			->argument(4, 'bool')
			->argument(5, 'bool');
			
		$attendee = array(
			Eden_Google_Calendar::EMAIL				=> $email,
			Eden_Google_Calendar::DISPLAYNAME		=> $name,
			Eden_Google_Calendar::RESPONSESTATUS	=> $reponseStatus,
			Eden_Google_Calendar::ORGANIZER			=> $organizer,
			Eden_Google_Calendar::SELF				=> $self);
		
		if($organizer == false) {
			unset($attendee[Eden_Google_Calendar::ORGANIZER]);	
		}
		
		if($self == false) {
			unset($attendee[Eden_Google_Calendar::SELF]);
		}
		
		if($name = false) {
			unset($attendee[Eden_Google_Calendar::DISPLAYNAME]);
		}
		
		$this->_attendees[] = $attendee;

		return $this;
	}
	
	/**
	 * sets the calendar id for event
	 *
	 * @param string
	 * @return this
	 */
	public function setCalendarId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calendarId = $id;
		
		return $this;
	}
	
	/**
	 * sets the organizer of the event
	 *
	 * @param string
	 * @param string|null
	 * @return this
	 */
	public function setOrganizer($email, $name = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string', 'null');
		
		$this->_organizer = array(
			Eden_Google_Calendar::EMAIL			=> $email,
			Eden_Google_Calendar::DISPLAYNAME	=> $name);
		
		if(!$name) {
			unset($this->_organizer[Eden_Google_Calendar::DISPLAYNAME]);
		}
		
		return $this;
	}
	
	
	/**
	 * sets the calendar id for event
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
	 * sets if guests can invite others on this event
	 *
	 * @param bool
	 * @return this
	 */
	public function guestCanInviteOthers($canInvite = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		if($canInvite != false) {
			$this->_guestsCanInviteOthers = $canInvite;
		}
		
		return $this;
	}
	
	/**
	 * sets if guests can invite others on this event
	 *
	 * @param bool
	 * @return this
	 */
	public function guestsCanSeeOtherGuests($guestsCanseeOtherGuests = true) {
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
	public function setReminder($reminder = true) {
		Eden_Google_Error::i()->argument(1, 'bool');
		if($reminder != false) {
			$this->_reminder = $reminder;
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
	 * Changing an event's organizer
	 * 
	 * @param string
	 * @return array
	 */
	 public function setDestinationId($destinationId) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_destinationId = $destinationId;
		
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
	 * sets the instance tag
	 *
	 * @param string
	 * @return this
	 */
	 public function setText($text) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_text = $text;
		 
		 return $this;
	 }
	 
	/**
	 * Returns multiple or single event on calendar
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function get($eventId = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
			
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		if($eventId) {
			$this->_eventId = $eventId;
		}
		
		$url = sprintf(self::URL_CREATE_EVENT, $this->_calendarId);
		
		if($this->_eventId) { // if is set eventId. add /eventId to the url
			$url = $url.'/'.$this->_eventId;
		}
		
		return $this->_getResponse($url);
	}
	
	/**
	 * Create event
	 *
	 * @return array
	 */
	public function create($calendarId = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		$query = array(
			Eden_Google_Calendar::SUMMARY		=> $this->_summary,
			Eden_Google_Calendar::LOCATION		=> $this->_location,
			Eden_Google_Calendar::START			=> $this->_start,
			Eden_Google_Calendar::END			=> $this->_end,
			Eden_Google_Calendar::ATTENDEES		=> $this->_attendees);
		
		return $this->_post(sprintf(self::URL_CREATE_EVENT, $this->_calendarId), $query);
	}
	
	/**
	 * Quick create event
	 *
	 * @return array
	 */
	public function quickCreate($text = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(1, 'string');
		
		if($text) {
			$this->_text = $text;
		}
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		$url = sprintf(self::URL_QUICK_CREATE_EVENT, $this->_calendarId, urlencode($this->_text));
		
		return $this->_post($url, array());
	}
	
	/**
	 * import event
	 *
	 * @return array
	 */
	public function import() {
		$query = array(
			Eden_Google_Calendar::SUMMARY		=> $this->_summary,
			Eden_Google_Calendar::LOCATION		=> $this->_location,
			Eden_Google_Calendar::ORGANIZER		=> $this->_organizer,
			Eden_Google_Calendar::START			=> $this->_start,
			Eden_Google_Calendar::END			=> $this->_end,
			Eden_Google_Calendar::ATTENDEES		=> $this->_attendees,
			Eden_Google_Calendar::ICALUID		=> $this->_calUId);
		
		return $this->_post(sprintf(self::URL_CREATE_EVENT, $this->_calendarId).'/import', $query);
	}
	
	/**
	 * update event
	 * TODO: fix
	 * @return array
	 */
	public function update() {
		$query = array(
			Eden_Google_Calendar::KIND						=> $this->_kind,
			Eden_Google_Calendar::ID						=> $this->_eventId,
			Eden_Google_Calendar::ETAG						=> $this->_etag,
			Eden_Google_Calendar::STATUS					=> $this->_status,
			Eden_Google_Calendar::HTMLLINK					=> $this->_htmlLink,
			Eden_Google_Calendar::CREATED					=> $this->_created,
			Eden_Google_Calendar::UPDATED					=> $this->_updated,
			Eden_Google_Calendar::SUMMARY					=> $this->_summary,
			Eden_Google_Calendar::LOCATION					=> $this->_location,
			Eden_Google_Calendar::CREATOR					=> $this->_creator,
			Eden_Google_Calendar::ORGANIZER					=> $this->_organizer,
			Eden_Google_Calendar::START						=> $this->_start,
			Eden_Google_Calendar::END						=> $this->_end,
			Eden_Google_Calendar::ICALUID					=> $this->_calUId,
			Eden_Google_Calendar::SEQUENCE					=> $this->_sequence,
			Eden_Google_Calendar::ATTENDEES					=> $this->_attendees,
			Eden_Google_Calendar::GUESTSCANINVITEOTHERS		=> $this->_guestsCanInviteOthers,
			Eden_Google_Calendar::GUESTSCANSEEOTHERGUESTS	=> $this->_guestsCanSeeOtherGuests,
			Eden_Google_Calendar::REMINDER					=> array(Eden_Google_Calendar::USEDEFAULT => $this->_reminder));
		
		return $this->_put(sprintf(self::URL_CREATE_EVENT, $this->_calendarId).'/'. $this->_eventId, $query);
	}
	 
	/**
	 * Changing an event's organizer
	 * 
	 * @param string|null
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function changeOrganizer($eventId = NULL, $destinationId = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null')
			->argument(3, 'string', 'null');
						
		if($eventId) {
			$this->_eventId = $eventId;
		}
		
		if($destinationId) {
			$this->_destinationId = $destinationId;
		}
		
		if($calendarId) {
			$this->$this->_calendarId = $calendarId;
		}
		
		return $this->_post(sprintf(self::URL_CHANGE_ORGANIZER, $this->_calendarId, $this->_eventId, $this->_destinationId), '');
	}
	
	/**
	 * will delete existing event.
	 * Upon success, the server responds
	 * with an HTTP 204 No Content status code.
	 *
	 * @param string|null
	 * @param string
	 * @return array
	 */
	public function delete($eventId = NULL, $calendarId = NULL) {
		//Argument 1 must be a string
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($eventId) {
			$this->_eventId = $eventId;
		}
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		$url = sprintf(self::URL_CREATE_EVENT, $this->_calendarId). '/'. $this->_eventId;
		return $this->_delete($url);
	}
	
	/**
	 * gets the recurring instaces
	 *
	 * @param string|null
	 * @param string|null
	 * @return this
	 */
	public function getRecurringInstances($eventId = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($eventId) {
			$this->_eventId = $eventId;
		}
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		$url = sprintf(self::URL_GET_RECURRING_INSTANCES, $this->_calendarId, $this->_eventId);

		return $this->_getResponse($url);
	}
	
	/**
	 * creates exception
	 * 
	 * TODO: fix
	 * @return this
	 */ 
	public function createException() {
			$query = array(
				Eden_Google_Calendar::KIND						=> $this->_kind,
				Eden_Google_Calendar::ID						=> $this->_instanceId,
				Eden_Google_Calendar::ETAG						=> $this->_instanceTag,
				Eden_Google_Calendar::STATUS					=> $this->_status,
				Eden_Google_Calendar::HTMLLINK					=> $this->_htmlLink,
				Eden_Google_Calendar::CREATED					=> $this->_created,
				Eden_Google_Calendar::UPDATED					=> $this->_updated,
				Eden_Google_Calendar::SUMMARY					=> $this->_summary,
				Eden_Google_Calendar::LOCATION					=> $this->_location,
				Eden_Google_Calendar::CREATOR					=> $this->_creator,
				Eden_Google_Calendar::ORGANIZER					=> $this->_organizer,
				Eden_Google_Calendar::START						=> $this->_start,
				Eden_Google_Calendar::END						=> $this->_end,
				Eden_Google_Calendar::ICALUID					=> $this->_calUId,
				Eden_Google_Calendar::SEQUENCE					=> $this->_sequence,
				Eden_Google_Calendar::ATTENDEES					=> $this->_attendees,
				Eden_Google_Calendar::GUESTSCANINVITEOTHERS		=> $this->_guestsCanInviteOthers,
				Eden_Google_Calendar::GUESTSCANSEEOTHERGUESTS	=> $this->_guestsCanSeeOtherGuests,
				Eden_Google_Calendar::REMINDER					=> array(Eden_Google_Calendar::USEDEFAULT => $this->_reminder));
			
			
			$url = sprintf(self::URL_CREATE_EVENT, $this->_calendarId). '/'. $this->_instanceId;
			
			return $this->_put($url, $query);
	}
	
	/**
	 * Search for event on specific calendar
	 * if calendarId not speciified, then use
	 * default calendarId 'primary'
	 * 
	 * @param string|null
	 * @param string|null
	 * @return this
	 */ 
	public function search($text = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($text) { //if text is not empty, store $this->_text get $text
			$this->_text = $text;
		}
		
		if($calendarId) { //if text is not empty, store $this->_calendarId get $calendarId
			$this->_calendarId = $calendarId;
		}
		
		$query = array();
		$query[self::SEARCH_QUERY] = $this->_text;
		$url = sprintf(self::URL_CREATE_EVENT, $this->_calendarId);
		
		return $this->_getResponse($url, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}