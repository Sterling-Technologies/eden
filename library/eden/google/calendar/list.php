<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar List Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_List extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_LIST		= 'https://www.googleapis.com/calendar/v3/users/me/calendarList';
	const URL_CALENDAR_GET		= 'https://www.googleapis.com/calendar/v3/users/me/calendarList/%s';
	
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
	 * Adds an entry to the user's calendar list.
	 *
	 * @param string Identifier of the calendar
	 * @return array
	 */
	public function create($id) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::ID] = $id;
		
		return $this->_post(self::URL_CALENDAR_LIST, $this->_query);
	}
	
	/**
	 * Return all event of calendar
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function delete($calendarId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_delete(sprintf(self::URL_CALENDAR_GET, $calendarId));
	}
	
	/**
	 * Return all event fo calendar
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getCalendar($calendarId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_GET, $calendarId));
	}
	
	/**
	 * Return all event fo calendar
	 *
	 * @return array
	 */
	public function getList() {
	
		return $this->_getResponse(self::URL_CALENDAR_LIST, $this->_query);
	}
	
	/**
	 * Updates an entry on the user's calendar list. This method supports patch semantics. 
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function patch($calendarId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_patch(sprintf(self::URL_CALENDAR_GET, $calendarId), $this->_query);
	}
	
	/**
	 * Set Access Role
	 *
	 * @param string
	 * @return this
	 */
	public function setAccessRole($accessRole) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[se::ACCESS_ROLE] = $accessRole;
		
		return $this;
	}
	
	/**
	 * Set color id
	 *
	 * @param integer ID referring to an entry in the "calendar" section of the colors definition
	 * @return this
	 */
	public function setColorId($colorId) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_query[self::COLOR_ID] = $colorId;
		
		return $this;
	}
	
	/**
	 * Set default reminders
	 *
	 * @param string
	 * @return this
	 */
	public function setDefaultReminders($defaultReminders) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::DEFAULT_REMINDERS] = $defaultReminders;
		
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
		$this->_query[self::DESCRIPTION] = $description;
		
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
		$this->_query[self::ETAG] = $etag;
		
		return $this;
	}
	
	/**
	 * Set calendar hidden
	 *
	 * @return this
	 */
	public function setHidden() {
		$this->_query[self::HIDDEN] = true;
		
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
		$this->_query[self::ID] = $id;
		
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
		$this->_query[self::KIND] = $kind;
		
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
		$this->_query[self::LOCATION] = $location;
		
		return $this;
	}
	
	/**
	 * Set query max results
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxResults($maxResults) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_query[self::MAX_RESULTS] = $maxResults; 
		
		return $this;
	}
	
	/**
	 * Set selected
	 *
	 * @return this
	 */
	public function setSelected() {
		$this->_query[self::SELECTED] = true;
		
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
	 * Set summary override
	 *
	 * @param string
	 * @return this
	 */
	public function setSummaryOverride($summaryOverride) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::SUMMARY_OVERRIDE] = $summaryOverride;
		
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
	public function update($calendarId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_put(sprintf(self::URL_CALENDAR_GET, $calendarId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}