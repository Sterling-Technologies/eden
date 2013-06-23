<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square Venue
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Venue extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_VENUE				= 'https://api.foursquare.com/v2/venues/%s';
	const URL_VENUE_ADD			= 'https://api.foursquare.com/v2/venues/add';
	const URL_VENUE_CATEGORY	= 'https://api.foursquare.com/v2/venues/categories';
	const URL_VENUE_MANAGE		= 'https://api.foursquare.com/v2/venues/managed';
	const URL_VENUE_TIME		= 'https://api.foursquare.com/v2/venues/timeseries';
	const URL_VENUE_SEARCH		= 'https://api.foursquare.com/v2/venues/search';
	const URL_VENUE_TRENDING	= 'https://api.foursquare.com/v2/venues/trending';
	const URL_VENUE_EVENTS		= 'https://api.foursquare.com/v2/venues/%s/events';
	const URL_VENUE_LIST		= 'https://api.foursquare.com/v2/venues/%s/listed';
	const URL_VENUE_MENU		= 'https://api.foursquare.com/v2/venues/%s/menu';
	const URL_VENUE_PHOTOS		= 'https://api.foursquare.com/v2/venues/%s/photos';
	const URL_VENUE_SIMILAR		= 'https://api.foursquare.com/v2/venues/%s/similar';
	const URL_VENUE_STATS		= 'https://api.foursquare.com/v2/venues/%s/stats';
	const URL_VENUE_TIPS		= 'https://api.foursquare.com/v2/venues/%s/tips';
	
	const URL_VENUE_EDIT			= 'https://api.foursquare.com/v2/venues/%s/edit';
	const URL_VENUE_FLAG			= 'https://api.foursquare.com/v2/venues/%s/flag';
	const URL_VENUE_MARK			= 'https://api.foursquare.com/v2/venues/%s/marktodo';
	const URL_VENUE_PROPOSE_EDIT	= 'https://api.foursquare.com/v2/venues/%s/proposeedit';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set name of the venue 
	 * 
	 * @param string
	 * @return this
	 */
	public function setVenueName($venueName) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');			
		$this->_query['name'] = $venueName;
		
		return $this;
	}
	
	/**
	 * Set text of the tip
	 * 
	 * @param string
	 * @return this
	 */
	public function setText($text) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		$this->_query['text'] = $text;
		
		return $this;
	}
	
	/**
	 * Set address of the venue 
	 * 
	 * @param string
	 * @return this
	 */
	public function setVenueAddress($venueAddress) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['address'] = $address;
		
		return $this;
	}
	
	
	/**
	 * Set location by setting longtitide 
	 * and latitude
	 * 
	 * @param int|float
	 * @param int|float
	 * @return this
	 */
	public function setLocation($longtitude, $latitude) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'int', 'float')	//argument 1 must be an integer or float
			->argument(2, 'int', 'float');	//argument 2 must be an integer or float
			
		$this->_query['ll'] = $longtitude.', '.$latitude; 
		
		return $this;
	}
	
	/**
	 * Set twitter account
	 * 
	 * @param string
	 * @return this
	 */
	public function setTwitter($twitter) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_query['twitter'] = $twitter;
		
		return $this;
	}
	
	/**
	 * Set category id
	 * 
	 * @param string
	 * @return this
	 */
	public function setCategoryId($categoryId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_query['categoryId'] = $categoryId;
		
		return $this;
	}
	
	/**
	 * The nearest intersecting street or streets. 
	 * 
	 * @param string
	 * @return this
	 */
	public function setCrossStreet($crossStreet) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['crossStreet'] = $crossStreet;
		
		return $this; 
	}
	
	/**
	 * The city name where this venue is.
	 * 
	 * @param string
	 * @return this
	 */
	public function setCity($city) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['city'] = $city;
		
		return $this;
	}
	
	/**
	 * The nearest state or province to the venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setState($state) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['state'] = $state;
		
		return $this;
	}
	
	/**
	 * The zip or postal code for the venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setZip($zip) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['zip'] = $zip;
		
		return $this;
	}
	
	/**
	 * The phone number of the venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setPhone($phone) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['phone'] = $phone;
		
		return $this;
	}
	
	/**
	 * The ID of the category to which you want to assign this venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setPrimaryCategoryId($primaryCategoryId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
		$this->_query['primaryCategoryId'] = $primaryCategoryId;
		
		return $this;
	}
	
	/**
	 * A freeform description of the venue, up to 300 characters.
	 * 
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['description'] = $description;
		
		return $this;
	}
	
	/**
	 * The url of the homepage of the venue.
	 * 
	 * @param string
	 * @return this
	 */
	public function setUrl($url) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['url'] = $url;
		
		return $this;
	}
	
	/**
	 * Number of results to return, up to 50.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'int');		
		$this->_query['limit'] = $limit;
		
		return $this;
	}
	
	/**
	 * Radius in meters, up to approximately 2000 meters.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setRadius($radius) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'int');	
		$this->_query['radius'] = $radius;
		
		return $this;
	}
	
	/**
	 * The start of the time range to retrieve stats for 
	 * (seconds since epoch). If omitted, all-time stats will be returned.
	 * 
	 * @param integer|integer 
	 * @return this
	 */
	public function setStartTime($startTime) {
		//argument 1 must be a string or integer
		Eden_Foursquare_Error::i()->argument(1, 'string', 'int');	
		$this->_query['startAt'] = $startTime;
		
		return $this;
	}
	
	/**
	 * The end of the time range to retrieve stats for 
	 * (seconds since epoch). If omitted, the current time is assumed.
	 * 
	 * @param integer|integer 
	 * @return this
	 */
	public function setEndTime($endTime) {
		//argument 1 must be a string or integer
		Eden_Foursquare_Error::i()->argument(1, 'string', 'int');	
		$this->_query['endAt'] = $endTime;
		
		return $this;
	}
	
	/**
	 * A search term to be applied against venue names.
	 * 
	 * @param integer|integer 
	 * @return this
	 */
	public function setQuery($venueName) {
		//argument 1 must be a string or integer
		Eden_Foursquare_Error::i()->argument(1, 'string', 'int');	
		$this->_query['query'] = $venueName;
		
		return $this;
	}
	
	/**
	 * Allows users to add a new venue. 
	 * 
	 * @param string
	 * @param string|integer|float
	 * @param string|integer|float
	 * @return array
	 */
	public function addVenue($venueName, $latitude, $longtitude) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')						//argument 1 must be a string
			->argument(2, 'string', 'int', 'float')		//argument 2 must be a string or integer or float
			->argument(3, 'string', 'int', 'float');	//argument 3 must be a string or integer or float
		
		$this->_query['name'] 	= $venueName;
		$this->_query['ll']		= $latitude.','.$longtitude;
		
		return $this->_post(self::URL_VENUE_ADD, $this->_query);
	}
	
	/**
	 * Returns a hierarchical list of categories applied to venues.
	 * 
	 * @return array
	 */
	public function getVenueCategories() {
		
		return $this->_getResponse(self::URL_VENUE_CATEGORY);
	}
	
	/**
	 * Returns a list of venues the current user manages.
	 * 
	 * @return array
	 */
	public function getManagedVenues() {
		
		return $this->_getResponse(self::URL_VENUE_MANAGE);
	}
	
	/**
	 * Returns a list of venues near the current location, 
	 * optionally matching the search term. 
	 * 
	 * @param string|null Required unless longtitude and latitude is provided
	 * @param string|integer|float|null Required unless near is provided
	 * @param string|integer|float|null Required unless near is provided
	 * @return array
	 */
	public function search($near = NULL, $latitude = NULL, $longtitude = NULL) {
		//argument test 
		Eden_Foursquare_Error::i()
			->argument(1, 'string', 'null')						//argument 1 must be a string or null
			->argument(2, 'string', 'int', 'float', 'null')		//argument 2 must be a string, integer, float or null
			->argument(3, 'string', 'int', 'float', 'null');	//argument 3 must be a string, integer, float or null
		
		$this->_query['near'] 	= $near;	
		$this->_query['ll']		= $latitude.','.$longtitude;
		
		return $this->_getResponse(self::URL_VENUE_SEARCH, $this->_query);
	}
	 
	/**
	 * Get daily venue stats for a list of venues over a time range.
	 * 
	 * @param string|integer The start of the time range to retrieve stats. Example: YYYY-MM-DD
	 * @param string 
	 * @return array
	 */
	public function getDailyVenueStats($startTime, $venueId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string', 'int')	//argument 1 must be a string or integer
			->argument(2, 'string');		//argument 2 must be a string
		
		$this->_query['startAt'] = strtotime($startTime);
		$this->_query['venueId'] = $venueId;
		
		return $this->_getResponse(self::URL_VENUE_TIME, $this->_query);
	}
	
	/**
	 * Returns a list of venues near the current location with the most people currently checked in. 
	 * 
	 * @param string|integer|float
	 * @param string|integer|float
	 * @return array
	 */
	public function getTrending($latitude, $longtitude) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string', 'int', 'float')		//argument 1 must be a string or integer or float
			->argument(2, 'string', 'int', 'float');	//argument 2 must be a string or integer or float
		
		$this->_query['ll'] = $latitude.','.$longtitude;
		
		return $this->_getResponse(self::URL_VENUE_TRENDING, $this->_query);
	}
	
	/**
	 * Allows you to access information about the current events at a place. 
	 * 
	 * @param string The venue id for which events are being requested.
	 * @return array
	 */
	public function getVenueEventInfo($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
			
		return $this->_getResponse(sprintf(self::URL_VENUE_EVENT, $venueId));
	}
	
	/**
	 * The lists that this venue appears on 
	 * 
	 * @param string Identity of a venue to get lists for.
	 * @return array
	 */
	public function getVenueList($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		
		return $this->_getResponse(sprintf(self::URL_VENUE_LIST, $venueId), $this->_query);
	}
	
	/**
	 * Returns menu information for a venue 
	 * 
	 * @param string The venue id for which menu is being requested.
	 * @return array
	 */
	public function getVenueMenu($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
			
		return $this->_getResponse(sprintf(self::URL_VENUE_MENU, $venueId));
	}
	
	/**
	 * Returns menu information for a venue 
	 * 
	 * @param string The venue you want photos for.
	 * @param string checkin or venue
	 * @return array
	 */
	public function getVenuePhoto($venueId, $group) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//if the input value is not allowed
		if(!in_array($group, array('checkin', 'venue'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_GROUPS) 
				->addVariable($group)
				->trigger();
		}
		
		$this->_query['group'] = $group;		
		
		return $this->_getResponse(sprintf(self::URL_VENUE_PHOTOS, $venueId), $this->_query);
	}
	
	/**
	 * Returns a list of venues similar to the specified venue. 
	 * 
	 * @param string The venue you want similar venues for.
	 * @return array
	 */
	public function getSimilarVenues($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
			
		return $this->_getResponse(sprintf(self::URL_VENUE_SIMILAR, $venueId));
	}
	
	/**
	 * Returns venue stats over a given time range.
	 * 
	 * @param string The venue you want similar venues for.
	 * @return array
	 */
	public function getVenueStats($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');	
			
		return $this->_getResponse(sprintf(self::URL_VENUE_STATS, $venueId), $this->_query);
	}
	
	/**
	 * Returns tips for a venue. 
	 * 
	 * @param string The venue you want tips for.
	 * @return array
	 */
	public function getVenueTips($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_getResponse(sprintf(self::URL_VENUE_STATS, $venueId), $this->_query);
	} 
	
	/**
	 * Make changes to a venue
	 * 
	 * @param string The venue id to edit
	 * @return array
	 */
	public function editVenue($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['VENUE_ID'] = $venueId;
		
		return $this->_post(sprintf(self::URL_VENUE_EDIT, $venueId), $this->_query);
	}
	
	/**
	 * Allows users to indicate a venue is incorrect in some way. 
	 * 
	 * @param string The venue id for which an edit is being proposed
	 * @param string One of mislocated, closed, duplicate, inappropriate, doesnt_exist, event_over
	 * @return array
	 */
	public function flagVenue($venueId, $problem) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//if the input value is not allowed
		if(!in_array($problem, array('mislocated', 'closed', 'duplicate', 'inappropriate', 'doesnt_exist', 'event_over'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_PROBLEM) 
				->addVariable($problem)
				->trigger();
		}
		
		$this->_query['VENUE_ID'] 	= $venueId;
		$this->_query['problem']	= $problem;
		
		return $this->_post(sprintf(self::URL_VENUE_FLAG, $venueId), $this->_query);
	}
	
	/**
	 * Allows you to mark a venue to-do, with optional text.  
	 * 
	 * @param string The venue id for which an edit is being proposed
	 * @param string One of mislocated, closed, duplicate, inappropriate, doesnt_exist, event_over
	 * @return array
	 */
	public function markVenue($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['VENUE_ID'] = $venueId;
		
		return $this->_post(sprintf(self::URL_VENUE_MARK, $venueId), $this->_query);
	}
	
	/**
	 * Make changes to a venue
	 * 
	 * @param string The venue id to edit
	 * @return array
	 */
	public function proposeEdit($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['VENUE_ID'] = $venueId;
		
		return $this->_post(sprintf(self::URL_VENUE_PROPOSE_EDIT, $venueId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
