<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Class for updating calendar meta data
 *
 * @package    Eden
 * @category   google
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Google_Calendar_Meta_Update extends Eden_Google_Base {
	/* Constants
	-------------------------------*/	
	const URL_UPDATE_META = 'https://www.googleapis.com/calendar/v3/calendars/calendarId';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_kind 			= NULL;
	protected $_calendarTag		= NULL;
	protected $_calendarId		= Eden_Google_Calendar::DEFAULT_CALENDAR;
	protected $_summary			= NULL;
	protected $_timeZone		= NULL;
	
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
	 * Set Calendar Kind
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
	 * Set Calendar Tag
	 *
	 * @param string
	 * @return this
	 */
	public function setCalendarTag($tag) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_calendarTag = $tag;
		
		return $this;
	}
	
	/**
	 * Set Calendar Id
	 *
	 * @param string
	 * @return this
	 */
	public function setCalendarId($id) {
		Eden_Google_Error::i()->argument(1, 'string');
		if($id) {
			$this->_calendarId = $id;
		}
		
		return $this;
	}
	
	/**
	 * Set new Calendar Summary
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
	 * Set Calendar timezone
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
	 * Update calendar meta data
	 * TODO: fix
	 * @param string
	 * @return array
	 */
	public function update() {
		$this->_timeZone = ($this->_timeZone == NULL) ? date_default_timezone_get() : $this->_timeZone;
		
		$url = sprintf(self::URL_UPDATE_META, $this->_calendarId);
		
		$query = array(
			'kind'		=> $this->_kind,
			'etag'		=> $this->_calendarTag,
			'id'		=> $this->_calendarId,
			'summary'	=> $this->_summary,
			'timeZone'	=> $this->_timeZone);
		return $this->_put($url, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}