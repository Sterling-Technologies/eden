<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite search
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
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
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Only return the number of results found
	 *
	 * @param string
	 * @return this
	 */
	public function countOnly() {
		$query['count_only'] = 'true';
		
		return $this;
	}
	
	/**
	 * Retrieves response
	 *
	 * @return array
	 */
	public function send() {
		return $this->_getJsonResponse(self::URL, $this->_query);
	}
	
	/**
	 * Filters by address
	 *
	 * @param string
	 * @return this
	 */
	public function setAddress($address) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['address'] = $address;
		
		return $this;
	}
	
	/**
	 * Filters by categories
	 *
	 * @param string|array
	 * @return this
	 */
	public function setCategory($category) {
		//Argument 1 must be a string or array
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'array');
		
		if(is_array($tickets)) {
			$tickets = implode(',', $tickets);
		}
		
		$query['category'] = $category;
		
		return $this;
	}
	
	/**
	 * Filters by country
	 *
	 * @param string
	 * @return this
	 */
	public function setCountry($country) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['country'] = $country;
		
		return $this;
	}
	
	/**
	 * Filters by city
	 *
	 * @param string
	 * @return this
	 */
	public function setCity($city) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['city'] = $city;
		
		return $this;
	}
	
	/**
	 * Filters by event date. Limit the list of results to a 
	 * date range, specified by a label or by exact dates. 
	 * Currently supported labels include: All, Future, 
	 * Past, Today, Yesterday, Last Week, This Week, 
	 * Next week, This Month, Next Month and months by 
	 * name like October. Exact date ranges take the 
	 * form 2008-04-25 2008-04-27.
	 *
	 * @param string
	 * @return this
	 */
	public function setDate($date) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['date'] = $date;
		
		return $this;
	}
	
	/**
	 * Filters by when the event was created. Limit the 
	 * list of results to a date range, specified by a 
	 * label or by exact dates. Currently supported 
	 * labels include: All, Future, Past, Today, 
	 * Yesterday, Last Week, This Week, Next week, 
	 * This Month, Next Month and months by name like 
	 * October. Exact date ranges take the form 
	 * 2008-04-25 2008-04-27.
	 *
	 * @param string
	 * @return this
	 */
	public function setDateCreated($date) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['date_created'] = $date;
		
		return $this;
	}
	
	/**
	 * Filters by when the event was modified. Limit the 
	 * list of results to a date range, specified by a 
	 * label or by exact dates. Currently supported 
	 * labels include: All, Future, Past, Today, 
	 * Yesterday, Last Week, This Week, Next week, 
	 * This Month, Next Month and months by name like 
	 * October. Exact date ranges take the form 
	 * 2008-04-25 2008-04-27.
	 *
	 * @param string
	 * @return this
	 */
	public function setDateModified($date) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['date_modified'] = $date;
		
		return $this;
	}
	
	/**
	 * Filters by keywords
	 *
	 * @param string
	 * @return this
	 */
	public function setKeywords($keywords) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['keywords'] = $keywords;
		
		return $this;
	}
	
	/**
	 * Filters by latitude
	 *
	 * @param float
	 * @return this
	 */
	public function setLatitude($latitude) {
		//Argument 1 must be a float
		Eden_Eventbrite_Error::i()->argument(1, 'float');
		
		$query['latitude'] = $latitude;
		
		return $this;
	}
	
	/**
	 * Filters by longitude
	 *
	 * @param float
	 * @return this
	 */
	public function setLongitude($longitude) {
		//Argument 1 must be a float
		Eden_Eventbrite_Error::i()->argument(1, 'float');
		
		$query['longitude'] = $longitude;
		
		return $this;
	}
	
	/**
	 * Set number of results
	 *
	 * @param int
	 * @return this
	 */
	public function setMax($max) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		if($max > 100) {
			$max = 100;
		}
		
		$query['max'] = $max;
		
		return $this;
	}
	
	/**
	 * Filters by organizer
	 *
	 * @param string
	 * @return this
	 */
	public function setOrganizer($organizer) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['organizer'] = $organizer;
		
		return $this;
	}
	
	/**
	 * Filters by postal/zip code
	 *
	 * @param string|int
	 * @return this
	 */
	public function setPostal($postal) {
		//Argument 1 must be a string or integer
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'int');
		
		$query['postal_code'] = $postal;
		
		return $this;
	}
	
	/**
	 * Filters by region
	 *
	 * @param string
	 * @return this
	 */
	public function setRegion($region) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['region'] = $region;
		
		return $this;
	}
	
	/**
	 * Filters within a specified area
	 *
	 * @param int
	 * @return this
	 */
	public function setWithin($within) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['within'] = $within;
		
		return $this;
	}
	
	/**
	 * Filters within an area unit
	 *
	 * @param string
	 * @return this
	 */
	public function setWithinUnit($unit) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['within_unit'] = $unit;
		
		return $this;
	}
	
	/**
	 * Sort by city
	 *
	 * @return this
	 */
	public function sortByCity() {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['sort_by'] = 'city';
		
		return $this;
	}
	
	/**
	 * Sort by event date
	 *
	 * @return this
	 */
	public function sortByDate() {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['sort_by'] = 'date';
		
		return $this;
	}
	
	/**
	 * Sort by event id
	 *
	 * @return this
	 */
	public function sortById() {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['sort_by'] = 'id';
		
		return $this;
	}
	
	/**
	 * Sort by event name
	 *
	 * @return this
	 */
	public function sortByName() {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['sort_by'] = 'name';
		
		return $this;
	}
	
	/**
	 * Set pagination
	 *
	 * @param int
	 * @return this
	 */
	public function setPage($page) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['page'] = $page;
		
		return $this;
	}

	/**
	 * Filter by event ids greater than specified
	 *
	 * @param int
	 * @return this
	 */
	public function setSince($since) {
		//Argument 1 must be a int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['since_id'] = $since;
		
		return $this;
	}
	
	/**
	 * Sets a tranking link
	 *
	 * @param string
	 * @return this
	 */
	public function setTracking($tracking) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['tracking_link'] = $tracking;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}