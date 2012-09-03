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
	 * Creates a secondary calendar.
	 *
	 * @param string The role assigned to the scope
	 * @param string The type of the scope
	 * @param string Calendar identifier
	 * @return array
	 */
	public function create($role, $type, $calendarId = self::PRIMARY) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query[self::ROLE]	= $role;
		$this->_query[self::SCOPE]	= array(self::TYPE => $type);
		
		return $this->_post(sprintf(self::URL_CALENDAR_ACL_GET, $calendarId), $this->_query);
	}
	
	/**
	 * Deletes an access control rule
	 *
	 * @param string ACL rule identifier
	 * @param string Calendar identifier
	 * @return null
	 */
	public function delete($ruleId, $calendarId = self::PRIMARY) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
		
		return $this->_delete(sprintf(self::URL_CALENDAR_ACL_SPECIFIC, $calendarId, $ruleId));
	}
	
	/**
	 * Returns the rules in the access 
	 * control list for the calendar. 
	 *
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getList($calendarId = self::PRIMARY) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_ACL_GET, $calendarId));
	}
	
	/**
	 * Returns an access control rule. 
	 *
	 * @param string ACL rule identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function getSpecific($ruleId, $calendarId = self::PRIMARY) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
		
		return $this->_getResponse(sprintf(self::URL_CALENDAR_ACL_SPECIFIC, $calendarId, $ruleId));
	}
	
	/**
	 * Set etag
	 *
	 * @param string ETag of the resource.
	 * @return this
	 */
	public function setEtag($etag) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::ETAG] = $etag;
		
		return $this;
	}
	
	/**
	 * Set id
	 *
	 * @param string|integer Identifier of the ACL rule.
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
	 * @param string Type of the resource ("calendar#aclRule").
	 * @return this
	 */
	public function setKind($kind) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query[self::KIND] = $kind;
		
		return $this;
	}
	
	/**
	 * Provides read access to free/busy information.
	 *
	 * @return this
	 */
	public function setRoleToFreeBusyReader() {
		$this->_query[self::ROLE] = 'freeBusyReader';
		
		return $this;
	}
	
	/**
	 * Provides no access role.
	 *
	 * @return this
	 */
	public function setRoleToNone() {
		$this->_query[self::ROLE] = 'none';
		
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
		$this->_query[self::ROLE] = 'reader';
		
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
		$this->_query[self::ROLE] = 'writer';
		
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
		$this->_query[self::ROLE] = 'owner';
		
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
		$this->_query[self::TYPE] = $type;
		
		return $this;
	}
	
	/**
	 * Updates an access control rule
	 *
	 * @param string ACL rule identifier
	 * @param string Calendar identifier
	 * @return array
	 */
	public function update($ruleId, $calendarId = self::PRIMARY) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string
			
		return $this->_put(sprintf(self::URL_CALENDAR_ACL_SPECIFIC, $calendarId, $ruleId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}