<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google calendar
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
abstract class Eden_Eventbrite_Event_Abstract extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function setTitle($title) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['title'] = $title;
		
		return $this;
	}
	
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['description'] = $description;
		
		return $this;
	}
	
	public function setStart($start) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string', 'int');
		
		if(is_string($start)) {
			$start = strtotime($start);
		}
		
		$start = date('Y-m-d H:i:s', $start);
		
		$query['start_date'] = $start;
		
		return $this;
	}
	
	public function setEnd($end) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string', 'int');
		
		if(is_string($end)) {
			$end = strtotime($end);
		}
		
		$end = date('Y-m-d H:i:s', $end);
		
		$query['end_date'] = $end;
		
		return $this;
	}
	
	public function setTimezone($zone) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		if(strpos($zone, 'GMT') !== 0) {
			$zone = 'GMT'.$zone;
		}
		
		$query['timezone'] = $zone;
		
		return $this;
	}
	
	public function isPublic() {
		$query['privacy'] = 1;
		
		return $this;
	}
	
	public function setUrl($url) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['personalized_url'] = $url;
		
		return $this;
	}
	
	public function setVenue($venue) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::get()->argument(1, 'numeric');
		
		$query['venue'] = $venue;
		
		return $this;
	}
	
	public function setOrganizer($organizer) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::get()->argument(1, 'numeric');
		
		$query['organizer'] = $organizer;
		
		return $this;
	}
	
	public function setCapacity($capacity) {
		//Argument 1 must be a numeric
		Eden_Eventbrite_Error::get()->argument(1, 'numeric');
		
		$query['capacity'] = $capacity;
		
		return $this;
	}
	
	public function setCurrency($currency) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['currency'] = $currency;
		
		return $this;
	}
	
	public function setStatus($status) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['status'] = $status;
		
		return $this;
	}
	
	public function setHeader($html) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['custom_header'] = $html;
		
		return $this;
	}
	
	public function setFooter($html) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['custom_footer'] = $html;
		
		return $this;
	}
	
	public function setBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['background_color'] = $color;
		
		return $this;
	}
	
	public function setTextColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['text_color'] = $color;
		
		return $this;
	}
	
	public function setLinkColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['link_color'] = $color;
		
		return $this;
	}
	
	public function setTitleColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['title_text_color'] = $color;
		
		return $this;
	}
	
	public function setBoxBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['box_background_color'] = $color;
		
		return $this;
	}
	
	public function setBoxColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['box_text_color'] = $color;
		
		return $this;
	}
	
	public function setBorderColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['box_border_color'] = $color;
		
		return $this;
	}
	
	public function setHeaderBackground($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['box_header_background_color'] = $color;
		
		return $this;
	}
	
	public function setHeaderColor($color) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::get()->argument(1, 'string');
		
		$query['box_header_text_color'] = $color;
		
		return $this;
	}
	
	abstract public function send();
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}