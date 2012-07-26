<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar Acl Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_Acl extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_ACL_GET		= 'https://www.googleapis.com/calendar/v3/calendars/%s/acl';
	const URL_CALENDAR_ACL_SPECIFIC	= 'https://www.googleapis.com/calendar/v3/calendars/%s/acl/%s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_calendarId			= NULL;
	protected $_ruleId				= NULL;
	protected $_role				= NULL;
	protected $_type				= NULL; 
	protected $_etag				= NULL;
	protected $_id					= NULL;
	protected $_kind				= NULL;
	
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
	 * Set rule id
	 *
	 * @param string
	 * @return this
	 */
	public function setRuleId($ruleId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_ruleId= $ruleId;
		
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
	 * Provides no access role.
	 *
	 * @return this
	 */
	public function setRoleToNone() {
		$this->_role = 'none';
		
		return $this;
	}
	
	/**
	 * Provides read access to free/busy information.
	 *
	 * @return this
	 */
	public function setRoleToFreeBusyReader() {
		$this->_role = 'freeBusyReader';
		
		return $this;
	}
	
	/**
	 * Provides read access to the calendar. 
	 * 1Private events will appear to users 
	 * with reader access, but event details 
	 * will be hidden.
	 *
	 * @return this
	 */
	public function setRoleToReader() {
		$this->_role = 'reader';
		
		return $this;
	}
	
	/**
	 * Provides read and write access to 
	 * the calendar. Private events will 
	 * appear to users with writer access, 
	 * and event details will be visible.
	 *
	 * @return this
	 */
	public function setRoleToWriter() {
		$this->_role = 'writer';
		
		return $this;
	}
	
	/**
	 * Provides ownership of the calendar. 
	 * This role has all of the permissions 
	 * of the writer role with the additional 
	 * ability to see and manipulate ACLs.
	 *
	 * @return this
	 */
	public function setRoleToOwner() {
		$this->_role = 'owner';
		
		return $this;
	}
	
	/**
	 * The type of the scope. Possible values are:
	 * "default" - The public scope. This is the default value.
	 * "user" - Limits the scope to a single user.
 	 * "group" - Limits the scope to a group.
	 * "domain" - Limits the scope to a domain.
	 *
	 * @return this
	 */
	public function setType($type) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_type = $type;
		
		return $this;
	}
	
	/**
	 * Returns the rules in the access 
	 * control list for the calendar. 
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_ACL_GET, $this->_calendarId));
	}
	
	/**
	 * Returns an access control rule. 
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_ACL_SPECIFIC, $this->_calendarId, $this->_ruleId));
	}
	
	/**
	 * Deletes an access control rule
	 *
	 * @return null
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CALENDAR_ACL_SPECIFIC, $this->_calendarId, $this->_ruleId));
	}
	
	/**
	 * Updates an access control rule
	 *
	 * @return array
	 */
	public function update() {
		//populate fields
		$query = array(
			self::ETAG	=> $this->_etag,
			self::ID	=> $this->_id,
			self::KIND	=> $this->_kind,
			self::ROLE	=> $this->_role,
			self::SCOPE	=> $scope = array(self::TYPE => $this->_type));
		
		return $this->_put(sprintf(self::URL_CALENDAR_ACL_SPECIFIC, $this->_calendarId, $this->_ruleId), $query);
	}
		
	/**
	 * Creates a secondary calendar.
	 *
	 * @return array
	 */
	public function create() {
		//populate fields
		$query = array(
			self::ETAG	=> $this->_etag,
			self::ID	=> $this->_id,
			self::KIND	=> $this->_kind,
			self::ROLE	=> $this->_role,
			self::SCOPE	=> $scope = array(self::TYPE => $this->_type));
		
		return $this->_post(sprintf(self::URL_CALENDAR_ACL_GET, $this->_calendarId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}