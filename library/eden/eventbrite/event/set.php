<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite new or update event
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Eventbrite_Event_Set extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL_NEW = 'https://www.eventbrite.com/json/event_new';
	const URL_UPDATE = 'https://www.eventbrite.com/json/event_update';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function setId($id) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['event_id'] = $id;
		
		return $this;
	}
	
	public function setTitle($title) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['title'] = $title;
		
		return $this;
	}
	
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['description'] = $description;
		
		return $this;
	}
	
	public function setStart($start) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$start = date('Y-m-d H:i:s', $start);
		
		$query['start_date'] = $start;
		
		return $this;
	}
	
	public function setEnd($end) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$end = date('Y-m-d H:i:s', $end);
		
		$query['end_date'] = $end;
		
		return $this;
	}
	
	public function setTimezone($zone) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['timezone'] = $zone;
		
		return $this;
	}
	
	public function isPublic() {
		$query['privacy'] = 1;
		
		return $this;
	}
	
	public function isPrivate() {
		$query['privacy'] = 0;
		
		return $this;
	}
	
	public function setUrl($url) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['personalized_url'] = $url;
		
		return $this;
	}
	
	public function setVenue($venue) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		
		$query['venue_id'] = $venue;
		
		return $this;
	}
	
	public function setOrganizer($organizer) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		
		$query['organizer_id'] = $organizer;
		
		return $this;
	}
	
	public function setCapacity($capacity) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::i()->argument(1, 'numeric');
		
		$query['capacity'] = $capacity;
		
		return $this;
	}
	
	public function setCurrency($currency) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['currency'] = $currency;
		
		return $this;
	}
	
	public function setStatus($status) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['status'] = $status;
		
		return $this;
	}
	
	public function setHeader($html) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['custom_header'] = $html;
		
		return $this;
	}
	
	public function setFooter($html) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['custom_footer'] = $html;
		
		return $this;
	}
	
	public function setBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['background_color'] = $color;
		
		return $this;
	}
	
	public function setTextColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['text_color'] = $color;
		
		return $this;
	}
	
	public function setLinkColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['link_color'] = $color;
		
		return $this;
	}
	
	public function setTitleColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['title_text_color'] = $color;
		
		return $this;
	}
	
	public function setBoxBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['box_background_color'] = $color;
		
		return $this;
	}
	
	public function setBoxColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['box_text_color'] = $color;
		
		return $this;
	}
	
	public function setBorderColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['box_border_color'] = $color;
		
		return $this;
	}
	
	public function setHeaderBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['box_header_background_color'] = $color;
		
		return $this;
	}
	
	public function setHeaderColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['box_header_text_color'] = $color;
		
		return $this;
	}
	
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}