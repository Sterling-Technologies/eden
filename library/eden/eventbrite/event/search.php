<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite search
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Eventbrite_Event_Search extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL = 'https://www.eventbrite.com/json/event_search';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function setKeywords($keywords) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['keywords'] = $keywords;
		
		return $this;
	}
	
	public function setCategory($category) {
		//Argument 1 must be a string or array
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'array');
		
		if(is_array($tickets)) {
			$tickets = implode(',', $tickets);
		}
		
		$query['category'] = $category;
		
		return $this;
	}
	
	public function setAddress($address) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['address'] = $address;
		
		return $this;
	}
	
	public function setCity($city) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['city'] = $city;
		
		return $this;
	}
	
	public function setRegion($region) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['region'] = $region;
		
		return $this;
	}
	
	public function setPostal($postal) {
		//Argument 1 must be a string or integer
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		$query['postal_code'] = $postal;
		
		return $this;
	}
	
	public function setCountry($country) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['country'] = $country;
		
		return $this;
	}
	
	public function setWithin($within) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['within'] = $within;
		
		return $this;
	}
	
	public function setWithinUnit($unit) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['within_unit'] = $unit;
		
		return $this;
	}
	
	public function setLatitude($latitude) {
		//Argument 1 must be a float
		Eden_Eventbrite_Error::i()->argument(1, 'float');
		
		$query['latitude'] = $latitude;
		
		return $this;
	}
	
	public function setLongitude($longitude) {
		//Argument 1 must be a float
		Eden_Eventbrite_Error::i()->argument(1, 'float');
		
		$query['longitude'] = $longitude;
		
		return $this;
	}
	
	public function setDate($date) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['date'] = $date;
		
		return $this;
	}
	
	public function setDateCreated($date) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['date_created'] = $date;
		
		return $this;
	}
	
	public function setDateModified($date) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['date_modified'] = $date;
		
		return $this;
	}
	
	public function setOrganizer($organizer) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['organizer'] = $organizer;
		
		return $this;
	}
	
	public function setMax($max) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		if($max > 100) {
			$max = 100;
		}
		
		$query['max'] = $max;
		
		return $this;
	}
	
	public function countOnly() {
		$query['count_only'] = 'true';
		
		return $this;
	}
	
	public function sort($column) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		if(in_array($column, $this->_validSort)) {
			$query['sort_by'] = $column;
		}
		
		return $this;
	}
	
	public function setPage($page) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['page'] = $page;
		
		return $this;
	}

	public function setSince($since) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['since_id'] = $since;
		
		return $this;
	}
	
	public function setTracking($tracking) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['tracking_link'] = $tracking;
		
		return $this;
	}
	
	public function send() {
		return $this->_getJsonResponse(self::URL, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}