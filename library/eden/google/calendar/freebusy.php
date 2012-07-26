<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Calendar Freebusy Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Calendar_Freebusy extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CALENDAR_FREEBUSY = 'https://www.googleapis.com/calendar/v3/freeBusy';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_timeMin					= NULL;
	protected $_timeMax					= NULL;
	protected $_timeZone				= NULL;
	protected $_groupExpansionMax		= NULL;
	protected $_calendarExpansionMax	= NULL;
	protected $_items					= NULL;
	
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
	 * Sets Minimum time
	 *
	 * @param string|int
	 * @return this
	 */
	public function setTimeMin($time) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->_timeMin = $time;
		
		return $this;
	}
	
	/**
	 * Sets Maximun time
	 *
	 * @param string|int
	 * @return this
	 */
	public function setTimeMax($time) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->_timeMax = $time;
		
		return $this;
	}
	
	/**
	 * Set items
	 *
	 * @param string|intger
	 * @return this
	 */
	public function setItem($item) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		$this->_items = $item;
		
		return $this;
	}
	
	/**
	 * Set group expansion max
	 *
	 * @param intger
	 * @return this
	 */
	public function setGroupExpansionMax($groupExpansionMax) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_groupExpansionMax = $groupExpansionMax;
		
		return $this;
	}
	
	/**
	 * Set calendar expansion max
	 *
	 * @param intger
	 * @return this
	 */
	public function setCalendarExpansionMax($calendarExpansionMax) {
		//argument 1 must be a integer
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_calendarExpansionMax = $calendarExpansionMax;
		
		return $this;
	}
	
	/**
	 * Returns free/busy information 
	 * for a set of calendars
	 *
	 * @return array
	 */
	public function query() {
		//populate fields
		$query = array(
			self::TIMEMIN				=> $this->_timeMin,
			self::TIMEMAX				=> $this->_timeMax,
			self::TIMEZONE				=> $this->_timeZone
			self::GROUP_EXPANSION		=> $this->_groupExpansionMax,
			self::CALENDAR_EXPANSION	=> $this->_calendarExpansionMax,
			self::ITEMS					=> $id = array(self::ID => $this->_items));
		
		return $this->_post(self::URL_CALENDAR_FREEBUSY, $query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}