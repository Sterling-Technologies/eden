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
class Eden_Google_Calendar_Freebusy extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_FREEBUSY_TIME	= 'https://www.googleapis.com/calendar/v3/freebusy';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_timeMin = NULL;
	protected $_timeMax = NULL;
	protected $_items	= array();
	
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
	 * sets timeMin
	 *
	 * @param string| int
	 * @return this
	 */
	public function setTimeMin($time) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->_timeMin = $time;
		
		return $this;
	}
	
	/**
	 * sets timeMax
	 *
	 * @param string| int
	 * @return this
	 */
	public function setTimeMax($time) {
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->_timeMax = $time;
		
		return $this;
	}
	
	/**
	 * add emails
	 *
	 * @param string
	 * @return this
	 */
	public function addItem($email) {
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_items[] = array(Eden_Google_Calendar::ID	=> $email);
		
		return $this;
	}
	
	/**
	 * get Free Busy Time
	 *
	 * @param string| int
	 * @return array
	 */
	public function get() {
		$query = array(
			Eden_Google_Calendar::TIMEMIN	=> $this->_timeMin,
			Eden_Google_Calendar::TIMEMAX	=> $this->_timeMax,
			Eden_Google_Calendar::ITEMS		=> $this->_items);
		
		return $this->_post(self::URL_FREEBUSY_TIME, $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}