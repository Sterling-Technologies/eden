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
class Eden_Google_Calendar_Event_Create extends Eden_Google_Base {
	/* Constants
	-------------------------------*/	
	const URL_CREATE_EVENT		= 'https://www.googleapis.com/calendar/v3/calendars/%s/events';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_summary		= NULL;
	protected $_location	= NULL;
	protected $_start 		= array();
	protected $_end 		= array();
	protected $_attendees 	= array();
	protected $_calendarId 	= Eden_Google_Calendar::DEFAULT_CALENDAR;
	
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
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($end)) {
			$start = strtotime($end);
		}
		
		$this->_end['dateTime'] = date('c', $end);
		
		return $this;
	}
	
	/**
	 * sets the attendees for event
	 *
	 * @param string
	 * @return this
	 */
	public function addAttendee($attendee) {
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
	 * @param int
	 * @return this
	 */
	public function setCalendar($id) {
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_calendarId = $id;
		
		return $this;
	}
	
	/**
	 * send event
	 *
	 * @return array
	 */
	public function send() {
		$query = array(
			'summary'		=> $this->_summary,
			'location'		=> $this->_location,
			'start'			=> $this->_start,
			'end'			=> $this->_end,
			'attendees'		=> $this->_attendees);
		
		return $this->_post(sprintf(self::URL_CREATE_EVENT, $this->_calendarId), $query);
	}
			
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}