<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google calendar
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Calendar extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_LIST 				= 'https://www.googleapis.com/calendar/v3/users/%s/calendarList';
	const URL_CREATE_CALENDAR				= 'https://www.googleapis.com/calendar/v3/calendars';
	const URL_CLEAR_PRIMARY_CALENDAR		= 'https://www.googleapis.com/calendar/v3/calendars/%s/clear';
	const URL_CLEAR_SECONDARY_CALENDAR		= 'https://www.googleapis.com/calendar/v3/calendars/%s';
	const URL_GET_CALENDAR					= 'https://www.googleapis.com/calendar/v3/users/%s/calendarList/%s';
	const URL_COLORS						= 'https://www.googleapis.com/calendar/v3/colors';
	const URL_SETTINGS						= 'https://www.googleapis.com/calendar/v3/users/%s/settings';
	
	const DEFAULT_USER						= 'me';
	const DEFAULT_CALENDAR					= 'primary';
	
	const KIND								= 'kind';
	const ID								= 'id';
	const ETAG								= 'etag';
	const STATUS							= 'status';
	const HTMLLINK							= 'htmlLink';
	const CREATED							= 'created';
	const UPDATED							= 'updated';
	const SUMMARY							= 'summary';
	const LOCATION							= 'location';
	const CREATOR							= 'creator';
	const ORGANIZER							= 'organizer';
	const START								= 'start';
	const END								= 'end';
	const ICALUID							= 'iCalUID';
	const SEQUENCE							= 'sequence';
	const ATTENDEES							= 'attendees';
	const GUESTSCANINVITEOTHERS				= 'guestsCanInviteOthers';
	const GUESTSCANSEEOTHERGUESTS			= 'guestsCanSeeOtherGuests';
	const REMINDER							= 'reminder';
	const USEDEFAULT						= 'useDefault';
	const EMAIL								= 'email';
	const DISPLAYNAME						= 'displayName';
	const SELF								= 'self';
	const RESPONSESTATUS					= 'responseStatus';
	const DATETIME							= 'dateTime';
	const SCOPE								= 'scope';
	const TYPE								= 'type';
	const VALUE								= 'value';
	const ROLE								= 'role';
	const TIMEMIN							= 'timeMin';
	const TIMEMAX							= 'timeMax';
	const ITEMS								= 'items';
	const TIMEZONE							= 'timeZone';
	const DESCRIPTION						= 'description';
	const COLORID							= 'colorId';
	const ACCESSROLE						= 'accessRole';
	const DEFAULTREMINDERS					= 'defaultReminders';
	const METHOD 							= 'method';
	const MINUTE							= 'minute';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_calendarId					= NULL;
	protected $_summary						= NULL;
	protected $_timeZone					= NULL;
	protected $_userId						= self::DEFAULT_USER;
	protected $_settingId					= NULL;
	protected $_kind						= NULL;
	protected $_tag							= NULL;
	protected $_description					= NULL;
	protected $_colorId						= NULL;
	protected $_accessRole					= NULL;
	protected $_reminder					= array();
	
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
	 *	Sets calendar ID
	 *
	 * @param string
	 * @return this
	 */
	public function setCalendarId($calendarId) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calendarId = $calendarId;
		
		return $this;
	}
	
	/**
	 *	Sets calendar summary
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
	 *	Sets calendar timezone
	 *
	 * @param string
	 * @return this
	 */
	 public function setTimeZone($timeZone) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_timeZone = $timeZone;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets calendar timezone
	 *
	 * @param string
	 * @return this
	 */
	 public function setSettingId($settingId) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_settingId = $settingId;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets calendar timezone
	 *
	 * @param string
	 * @return this
	 */
	 public function setUserId($userId) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_userId = $userId;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets calendar tag
	 *
	 * @param string
	 * @return this
	 */
	 public function setTag($tag) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_tag = $tag;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets calendar description
	 *
	 * @param string
	 * @return this
	 */
	 public function setDesciption($description) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_description = $description;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets color Id
	 *
	 * @param string
	 * @return this
	 */
	 public function setColorId($colorId) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_colorId = $colorId;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets calendar Access Role
	 *
	 * @param string
	 * @return this
	 */
	 public function setAccessRole($accessRole) {
		 Eden_Google_Error::i()->argument(1, 'string');
		 $this->_accessRole = $accessRole;
		 
		 return $this;
	 }
	 
	 /**
	 *	Sets calendar Reminders
	 *
	 * @param string
	 * @return this
	 */
	 public function setReminders($method, $minute) {
		 Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(1, 'string');
		
		 $this->_reminder = array(
						self::METHOD	=> $method,
						self::MINUTE	=> $minute);
		 
		 return $this;
	 }
	 
	/**
	 * Returns Google Calendar Event	 
	 *
	 * @return Eden_Google_Calendar_Event
	 */
	public function event() {
		return Eden_Google_Calendar_Event::i($this->_token);
	}
	
	/**
	 * Returns Google Calendar Meta Data	 
	 *
	 * @return Eden_Google_Calendar_Meta
	 */
	public function meta() {
		return Eden_Google_Calendar_Meta::i($this->_token);
	}
	
	/**
	 * AccessControl
	 *
	 * @return Eden_Google_Calendar_Acl
	 */
	public function acl() {
		return Eden_Google_Calendar_Acl::i($this->_token);
	}
	
	/**
	 * Returns Create Calendar
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function create($summary = NULL, $timeZone = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($summary) {
			$this->_summary = $summary;
		}
		
		if($timeZone == false) { //get default time zone
			$timeZone = date_default_timezone_get();
		}
		
		$this->_timeZone = $timeZone;
		
		
		$query = array(
			self::SUMMARY		=> $this->_summary,
			self::TIMEZONE		=> $this->_timeZone);
		
		return $this->_post(self::URL_CREATE_CALENDAR, $query);
	}
	
	/**
	 * delete secodary calendar
	 *
	 * @param string|null
	 * @return array
	 */
	public function delete($calendarId = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		$url = sprintf(self::URL_CLEAR_SECONDARY_CALENDAR, $this->_calendarId);
		return $this->_delete($url);
	}
	
	/**
	 * Update calendar
	 *
	 * TODO:fix
	 * @param string|null
	 * @return array
	 */
	public function update() {
		$url = sprintf(self::URL_GET_CALENDAR, $this->_userId, $this->_calendarId);
		$query = array(
			self::KIND				=> $this->_kind,
			self::ETAG				=> $this->_tag,
			self::ID				=> $this->_calendarId,
			self::SUMMARY			=> $this->_summary,
			self::DESCRIPTION		=> $this->_description,
			self::TIMEZONEE			=> $this->_timeZone,
			self::COLORID			=> $this->_colorId,
			self::ACCESSROLE		=> $this->_accessRole,
			self::DEFAULTREMINDERS	=> $this->_reminders);
		
		return $this->_put($url, $query);
	}
	
	/**
	 * Retrieving a single calendar list entry
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function getCalendar($calendarId = NULL, $userId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if(!$calendarId) {
			$calendarId = self::DEFAULT_CALENDAR;
		}
		
		if($userId) {
			$this->_userId = $userId;
		}
		
		$this->_calendarId = $calendarId;
		$url = sprintf(self::URL_GET_CALENDAR, $this->_userId, $this->_calendarId);
		
		return $this->_getResponse($url);
	}
	
	/**
	 * Adding calendars to a user's calendar list
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function addToList($calendarId = NULL, $userId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(1, 'string', 'null');
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		if($userId) {
			$this->_userId = $userId;
		}
		
		$url = sprintf(self::URL_CALENDAR_LIST, $this->_userId);
		$query = array(self::ID => $this->_calendarId);
		
		return $this->_post($url, $query);
	}
	
	/**
	 * Removing a calendar from a user's calendar list
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function removeFromList($calendarId = NULL, $userId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		if($userId) {
			$this->_userId = $userId;
		}
		
		$url = sprintf(self::URL_GET_CALENDAR, $this->_userId, $this->_calendarId);
		
		return $this->_delete($url);
	}
	
	/**
	 * Retrieving available colors
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getAvailableColors() {
		return $this->_getResponse(self::URL_COLORS);
	}
	
	/**
	 * Eden_Google_Calendar_Freebusy
	 *
	 * TODO: Test if it's working
	 * @return Eden_Google_Calendar_Freebusy
	 */
	public function freeBusyTime() {
		return Eden_Google_Calendar_Freebusy::i($this->_token);
	}
	
	/**
	 * Retrieving settings
	 *
	 * @param string|null
	 * @param string|null
	 * @return array
	 */
	public function getSettings($settingId = NULL, $userId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
		
		if($settingId) {
			$this->_settingId = $settingId;
		}
		
		if($userId) {
			$this->_userId = $userId;
		}
		
		$url = sprintf(self::URL_SETTINGS, $this->_userId);
		if($this->_settingId) {
			$url = $url.'/'.$this->_settingId;
			
		}
		
		return $this->_getResponse($url);
	}
	
	/**
	 * Returns calendar list
	 *
	 * @param string|int
	 * @return array
	 */
	public function getList($user = self::DEFAULT_USER) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$url = sprintf(self::URL_CALENDAR_LIST, $user);
		return $this->_getResponse($url);
	}
	
	/**
	 * clear all events in primary calendar
	 *
	 * @param string
	 * @return array
	 */
	public function clear($calendarId = self::DEFAULT_CALENDAR) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calendarId = $calendarId;
		$url = sprintf(self::URL_CLEAR_PRIMARY_CALENDAR, $this->_calendarId);
		
		return $this->_post($url);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}