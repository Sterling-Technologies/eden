<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite new or update event
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Event_Set extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_NEW 		= 'https://www.eventbrite.com/json/event_new';
	const URL_UPDATE 	= 'https://www.eventbrite.com/json/event_update';
	
	const DRAFT	= 'draft';
	const LIVE	= 'live';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set event to private
	 *
	 * @return this
	 */
	public function isPrivate() {
		$this->_query['privacy'] = 0;
		
		return $this;
	}
	
	/**
	 * Set the event to public 
	 *
	 * @return this
	 */
	public function isPublic() {
		$this->_query['privacy'] = 1;
		
		return $this;
	}
	
	/**
	 * Sends event off to be created or updated 
	 *
	 * @return this
	 */
	public function send() {
		if(!isset($this->_query['title'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::TITLE_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['start_date'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::START_NOT_SET)->trigger();
		}
		
		
		if(!isset($this->_query['end_date'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::END_NOT_SET)->trigger();
		}
		
		if(!isset($this->_query['timezone'])) {
			Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::ZONE_NOT_SET)->trigger();
		}
		
		$url = self::URL_NEW;
		
		if(isset($this->_query['event_id'])) {
			$url = self::URL_UPDATE;
			
			if(!isset($this->_query['privacy'])) {
				Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::PRIVACY_NOT_SET)->trigger();
			}
			
			if(!isset($this->_query['personalized_url'])) {
				Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::URL_NOT_SET)->trigger();
			}
			
			if(!isset($this->_query['organizer_id'])) {
				Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::ORGANIZER_NOT_SET)->trigger();
			}
			
			if(!isset($this->_query['venue_id'])) {
				Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::VENUE_NOT_SET)->trigger();
			}
			
			if(!isset($this->_query['capacity'])) {
				Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::CAPACITY_NOT_SET)->trigger();
			}
			
			if(!isset($this->_query['currency'])) {
				Eden_Eventbrite_Error::i()->setMessage(Eden_Eventbrite_Error::CURRENCY_NOT_SET)->trigger();
			}
		}
		
		return $this->_getJsonResponse($url, $this->_query);
	}
	
	/**
	 * Set the background color
	 *
	 * @param string
	 * @return this
	 */
	public function setBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['background_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Sets the border color
	 *
	 * @param string
	 * @return this
	 */
	public function setBorderColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['box_border_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Set the box background color
	 *
	 * @param string
	 * @return this
	 */
	public function setBoxBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['box_background_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Sets the box color
	 *
	 * @param string
	 * @return this
	 */
	public function setBoxColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['box_text_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Set the event capacity
	 *
	 * @param int
	 * @return this
	 */
	public function setCapacity($capacity) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$this->_query['capacity'] = $capacity;
		
		return $this;
	}
	
	/**
	 * Sets currency
	 *
	 * @param string
	 * @return this
	 */
	public function setCurrency($currency) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['currency'] = $currency;
		
		return $this;
	}
	
	/**
	 * Set the description
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['description'] = $description;
		
		return $this;
	}
	
	/**
	 * Sets status to draft
	 *
	 * @return this
	 */
	public function setDraft() {
		$this->_query['status'] = self::DRAFT;
		
		return $this;
	}
	
	/**
	 * Set the end time
	 *
	 * @param string|int
	 * @return this
	 */
	public function setEnd($end) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$end = date('Y-m-d H:i:s', $end);
		
		$this->_query['end_date'] = $end;
		
		return $this;
	}
	
	/**
	 * Set the footer HTML
	 *
	 * @param string
	 * @return this
	 */
	public function setFooter($html) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['custom_footer'] = $html;
		
		return $this;
	}
	
	/**
	 * Set the header HTML
	 *
	 * @param string
	 * @return this
	 */
	public function setHeader($html) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['custom_header'] = $html;
		
		return $this;
	}
	
	/**
	 * Sets the header background color
	 *
	 * @param string
	 * @return this
	 */
	public function setHeaderBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['box_header_background_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Sets color to Hexdecimal
	 *
	 * @param string
	 * @return this
	 */
	public function setHeaderColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['box_header_text_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Set the event ID. Set this if you want to 
	 * perform an update instead of an insert
	 *
	 * @param int
	 * @return this
	 */
	public function setId($id) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$this->_query['event_id'] = $id;
		
		return $this;
	}
	
	/**
	 * Set the link color
	 *
	 * @param string
	 * @return this
	 */
	public function setLinkColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['link_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Sets status to live
	 *
	 * @return this
	 */
	public function setLive() {
		$this->_query['status'] = self::LIVE;
		
		return $this;
	}
	
	/**
	 * Set the organizer ID
	 *
	 * @param int
	 * @return this
	 */
	public function setOrganizer($organizer) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$this->_query['organizer_id'] = $organizer;
		
		return $this;
	}
	
	/**
	 * Set the start time
	 *
	 * @param int|string
	 * @return this
	 */
	public function setStart($start) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$start = date('Y-m-d H:i:s', $start);
		
		$this->_query['start_date'] = $start;
		
		return $this;
	}
	
	/**
	 * Set the text color
	 *
	 * @param string
	 * @return this
	 */
	public function setTextColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['text_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Set the timezone in GMT format ie. GMT+01
	 *
	 * @param string
	 * @return this
	 */
	public function setTimezone($zone) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'gmt');
		
		$this->_query['timezone'] = $zone;
		
		return $this;
	}
	
	/**
	 * Set the title
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['title'] = $title;
		
		return $this;
	}
	
	/**
	 * Set the title color
	 *
	 * @param string
	 * @return this
	 */
	public function setTitleColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'hex');
		
		$this->_query['title_text_color'] = $color;
		
		return $this;
	}
	
	/**
	 * Set event URL
	 *
	 * @param string
	 * @return this
	 */
	public function setUrl($url) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'url');
		
		$this->_query['personalized_url'] = $url;
		
		return $this;
	}
	
	/**
	 * 
	 *
	 * @param int
	 * @return this
	 */
	public function setVenue($venue) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		
		$this->_query['venue_id'] = $venue;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}