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
class Eden_Google_Calendar_Acl extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_ADD_ACCESS_RULE 			= 'https://www.googleapis.com/calendar/v3/calendars/%s/acl';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_type		= NULL;
	protected $_value		= NULL;
	protected $_role		= NULL;
	protected $_kind		= NULL;
	protected $_tag			= NULL;
	protected $_ruleId		= NULL;
	protected $_calendarId	= Eden_Google_Calendar::DEFAULT_CALENDAR;
	
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
	 * set scope type
	 *
	 * @param string
	 * @return this
	 */
	public function setType($type) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_type = $type;
		
		return $this;
	}
	
	/**
	 * set scope alue
	 *
	 * @param string
	 * @return this
	 */
	public function setValue($value) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_value = $value;
		
		return $this;
	}
	
	/**
	 * set ruleId
	 *
	 * @param string
	 * @return this
	 */
	public function setRuleId($ruleId) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_ruleId = $ruleId;
		
		return $this;
	}
	
	/**
	 * set role
	 *
	 * @param string
	 * @return this
	 */
	public function setRole($role) {
			Eden_Google_Error::i()->argument(1, 'string');
			$this->_role= $role;
			
			return $this;
	}
	
	/**
	 * set kind
	 *
	 * @param string
	 * @return this
	 */
	public function setKind($kind) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_kind = $kind;
		
		return $this;
	}
	
	/**
	 * set tag
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
	 * set rule Id
	 *
	 * @param string
	 * @return this
	 */
	public function setId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_id = $id;
		
		return $this;
	}
	
	/**
	 * set calendar Id
	 *
	 * @param string
	 * @return this
	 */
	public function setCalendarId($id = Eden_Google_Calendar::DEFAULT_CALENDAR) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calendarId = $id;
		
		return $this;
	}
	
	/**
	 * Creates new access rules
	 *
	 * @return this
	 */
	public function create() {
		$query = array(
			Eden_Google_Calendar::SCOPE 	=> array(
				Eden_Google_Calendar::TYPE		=> $this->_type,
				Eden_Google_Calendar::VALUE		=> $this->_value),
			Eden_Google_Calendar::ROLE		=> $this->_role);
		
		return $this->_post(sprintf(self::URL_ADD_ACCESS_RULE, $this->_calendarId), $query);
	}
	
	/**
	 * Update access rules
	 *
	 * TODO: fix update
	 * @return this
	 */
	public function update() {
		$query = array(
			Eden_Google_Calendar::KIND		=> $this->_kind,
			Eden_Google_Calendar::ETAG		=> $this->_tag,
			Eden_Google_Calendar::ID		=> $this->_id,
			Eden_Gdu oogle_Calendar::SCOPE 	=> array(
							Eden_Google_Calendar::TYPE	=> $this->_type,
							Eden_Google_Calendar::VALUE	=> $this->_value),
			Eden_Google_Calendar::ROLE		=> $this->_role);
		
		$url = sprintf(self::URL_ADD_ACCESS_RULE, $this->_calendarId).'/'.$this->_id;
		
		return $this->_put($url, $query);
	}
	
	/**
	 * Delete access rules
	 *
	 * @return this
	 */
	public function delete($ruleId = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()->argument(1, 'string');
		if($ruleId) {
			$this->_ruleId = $ruleId;
		}
		
		if($calendarId) {
			$this->_calendarId = $calendarId;
		}
		
		$url = sprintf(self::URL_ADD_ACCESS_RULE, $this->_calendarId).'/'.$this->_ruleId;
		
		return $this->_delete($url);
	}
	
	/**
	 * Retrieving access control
	 *
	 * @param string|bool
	 * @param string
	 * @return array
	 */
	public function get($ruleId = NULL, $calendarId = NULL) {
		Eden_Google_Error::i()
			->argument(1, 'string', 'null')
			->argument(2, 'string', 'null');
			
		if($ruleId) {
			$this->_ruleId = $ruleId;
		}
		
		if(!$calendarId) {
			$calendarId = Eden_Google_Calendar::DEFAULT_CALENDAR;
		}
		
		$this->_calendarId = $calendarId;
		$url = sprintf(self::URL_ADD_ACCESS_RULE, $this->_calendarId);
		if( $this->_ruleId ){
			$url = $url.'/'.$this->_ruleId;
		}
		
		return $this->_getResponse($url);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}