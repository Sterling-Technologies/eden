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
	 * Returns free/busy information 
	 * for a set of calendars
	 *
	 * @param string|integer The start of the interval
	 * @param string|integer The end of the interval
	 * @return array
	 */
	public function query($startTime, $endTime) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string', 'int')		//argument 1 must be a string or integer
			->argument(2, 'string', 'int');		//argument 2 must be a string or integer
		
		if(is_string($startTime)) {
			$startTime = strtotime($startTime);
		}
		
		if(is_string($endTime)) {
			$endTime = strtotime($endTime);
		}
		
		//populate fields
		$query = array(
			self::TIMEMIN				=> $startTime,
			self::TIMEMAX				=> $endTime,
			self::TIMEZONE				=> $this->_timeZone,
			self::GROUP_EXPANSION		=> $this->_groupExpansionMax,
			self::CALENDAR_EXPANSION	=> $this->_calendarExpansionMax,
			self::ITEMS					=> $id = array(self::ID => $this->_items));
		
		return $this->_post(self::URL_CALENDAR_FREEBUSY, $query);
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}