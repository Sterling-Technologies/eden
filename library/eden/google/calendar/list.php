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
	protected $_timeZone			= NULL;
	protected $_calendarId			= NULL;
	protected $_maxResults			= NULL;
	protected $_accessRole			= NULL;
	protected $_colorId				= NULL;
	protected $_etag				= NULL;
	protected $_id					= NULL;
	protected $_kind				= NULL;
	protected $_location			= NULL;
	protected $_summary				= NULL;
	protected $_defaultReminders	= NULL;
	protected $_description			= NULL;
	protected $_summaryOverride		= NULL;
	
	protected $_selected			= false;
	protected $_hidden				= false;
	
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
	 * Set query max results
	 *
	 * @param integer
	 * @return this
	 */
	public function setMaxResults($maxResults) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_maxResults = $maxResults; 
		
		return $this;
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
		$this->_accessRole = $accessRole;
		
		return $this;
	}
	
	/**
	 * Set color id
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
	 * Set default reminders
	 *
	 * @param string
	 * @return this
	 */
	public function setDefaultReminders($defaultReminders) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_defaultReminders = $defaultReminders;
		
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
	 * Set calendar hidden
	 *
	 * @return this
	 */
	public function setHidden() {
		$this->_hidden = true;
		
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
	 * Set selected
	 *
	 * @return this
	 */
	public function setSelected() {
		$this->_selected = true;
		
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
	 * Set summary override
	 *
	 * @param string
	 * @return this
	 */
	public function setSummaryOverride($summaryOverride) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_summaryOverride = $summaryOverride;
		
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
	 * Return all event fo calendar
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query = array(self::MAX_RESULTS => $this->_maxResults);
		
		return $this->_getResponse(self::URL_CALENDAR_LIST, $query);
	}
	
	/**
	 * Return all event fo calendar
	 *
	 * @return array
	 */
	public function getCalendar() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_GET, $this->_calendarId));
	}
	
	/**
	 * Return all event fo calendar
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CALENDAR_GET, $this->_calendarId));
	}
	
	/**
	 * Update Calendar
	 *
	 * @return array
	 */
	public function update() {
		//populate fields
		$query = array(
			self::ACCESS_ROLE		=> $this->_accessRole,
			self::COLOR_ID 			=> $this->_colorId,
			self::DEFAULT_REMINDERS	=> $this->_defaultReminders,
			self::DESCRIPTION		=> $this->_description,
			self::ETAG				=> $this->_etag,
			self::HIDDEN			=> $this->_hidden,
			self::ID				=> $this->_id,
			self::KIND				=> $this->_kind,
			self::LOCATION			=> $this->_location,
			self::SELECTED			=> $this->_selected,
			self::SUMMARY			=> $this->_summary,
			self::SUMMARY_OVERRIDE	=> $this->_summaryOverride,
			self::TIMEZONE			=> $this->_timeZone);
		
		return $this->_put(sprintf(self::URL_CALENDAR_GET, $this->_calendarId), $query);
	}
	
	/**
	 * Updates an entry on the user's calendar list. This method supports patch semantics. 
	 *
	 * @return array
	 */
	public function patch() {
		//populate fields
		$query = array(
			self::ACCESS_ROLE		=> $this->_accessRole,
			self::COLOR_ID 			=> $this->_colorId,
			self::DEFAULT_REMINDERS	=> $this->_defaultReminders,
			self::DESCRIPTION		=> $this->_description,
			self::ETAG				=> $this->_etag,
			self::HIDDEN			=> $this->_hidden,
			self::ID				=> $this->_id,
			self::KIND				=> $this->_kind,
			self::LOCATION			=> $this->_location,
			self::SELECTED			=> $this->_selected,
			self::SUMMARY			=> $this->_summary,
			self::SUMMARY_OVERRIDE	=> $this->_summaryOverride,
			self::TIMEZONE			=> $this->_timeZone);
		
		return $this->_patch(sprintf(self::URL_CALENDAR_GET, $this->_calendarId), $query);
	}
	
	/**
	 * Adds an entry to the user's calendar list.
	 *
	 * @return array
	 */
	public function create() {
		//populate fields
		$query = array(
			self::ACCESS_ROLE		=> $this->_accessRole,
			self::COLOR_ID 			=> $this->_colorId,
			self::DEFAULT_REMINDERS	=> $this->_defaultReminders,
			self::DESCRIPTION		=> $this->_description,
			self::ETAG				=> $this->_etag,
			self::HIDDEN			=> $this->_hidden,
			self::ID				=> $this->_id,
			self::KIND				=> $this->_kind,
			self::LOCATION			=> $this->_location,
			self::SELECTED			=> $this->_selected,
			self::SUMMARY			=> $this->_summary,
			self::SUMMARY_OVERRIDE	=> $this->_summaryOverride,
			self::TIMEZONE			=> $this->_timeZone);
		
		return $this->_post(self::URL_CALENDAR_LIST, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}