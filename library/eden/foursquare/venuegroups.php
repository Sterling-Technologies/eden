<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square Venue groups
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Venuegroups extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_VENUE_GROUPS_ADD 			= 'https://api.foursquare.com/v2/venuegroups/add';
	const URL_VENUE_GROUPS_DELETE 		= 'https://api.foursquare.com/v2/venuegroups/%s/delete';
	const URL_VENUE_GROUPS_LIST 		= 'https://api.foursquare.com/v2/venuegroups/list';
	const URL_VENUE_GROUPS_TIMESERIES 	= 'https://api.foursquare.com/v2/venuegroups/%s/timeseries';
	const URL_VENUE_GROUPS_ADDVENUE 	= 'https://api.foursquare.com/v2/venuegroups/%s/addvenue';
	const URL_VENUE_GROUPS_CAMPAIGNS	= 'https://api.foursquare.com/v2/venuegroups/%s/campaigns';
	const URL_VENUE_GROUPS_EDIT_VENUE	= 'https://api.foursquare.com/v2/venuegroups/%s/edit';
	const URL_VENUE_GROUPS_REMOVE		= 'https://api.foursquare.com/v2/venuegroups/%s/removevenue';
	const URL_VENUE_GROUPS_UPDATE		= 'https://api.foursquare.com/v2/venuegroups/%s/update';
	
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
	 * Set venue Id
	 * 
	 * @param string
	 * @return this
	 */
	public function setVenueId($venueId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');		
		$this->_query['venueId'] = $venueId;
		
		return $this;
	}
	
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
	 * The end of the time range to retrieve stats for
	 * 
	 * @param string
	 * @return this
	 */
	public function setEndTime($endTime) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_query['endAt'] = strtotime($endTime);
		
		return $this;
	}
	
	/**
	 * Specifies which fields to return. May be one or more of totalCheckins, 
	 * newCheckins, uniqueVisitors, sharing, genders, ages, hours.
	 * 
	 * @param string
	 * @return this
	 */
	public function setFields($fields) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		//if the input value is not allowed
		if(!in_array($fields, array('totalCheckins', 'newCheckins', 'uniqueVisitors', 'sharing', 'genders', 'ages', 'hours'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_FIELDS) 
				->addVariable($fields)
				->trigger();
		}
		
		$this->_query['fields'] = $fields;
		
		return $this;
	}
	
	/**
	 * Create a venue group
	 * 
	 * @param string The name to give the group.
	 * @return array
	 */
	public function addVenueGroups($name) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$this->_query['name'] = $name;
		
		return $this->_post(self::URL_VENUE_GROUPS_ADD, $this->_query);
	}
	
	/**
	 * Delete a venue group
	 * 
	 * @param string The ID of the venue group to delete.
	 * @return array
	 */
	public function deleteVenueGroups($groupId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_post(sprintf(self::URL_VENUE_GROUPS_DELETE, $groupId));
	}
	
	/**
	 * Return all venue groups owned by the user.
	 * 
	 * @return array
	 */
	public function getList() {
			
		return $this->_getResponse(self::URL_VENUE_GROUPS_LIST);
	}
	
	/**
	 * Get daily venue stats for the venues in a group over a time range.
	 * 
	 * @param string The venue group to retrieve series data for.
	 * @param string The start of the time range to retrieve stats for. YYYY-MM-DD
	 * @return array
	 */
	public function getTimeSeries($groupId, $startTime) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['startAt'] = strtotime($startTime);
		
		return $this->_getResponse(sprintf(self::URL_VENUE_GROUPS_TIMESERIES, $groupId), $this->_query);
	}
	
	/**
	 * Add a venue to a venue group.
	 * 
	 * @param string The ID of the venue group to modify
	 * @param string Venue IDs to add to the group
	 * @return array
	 */
	public function addVenueToGroup($groupId, $venueId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query['venueId'] = $venueId;
		
		return $this->_post(sprintf(self::URL_VENUE_GROUPS_ADDVENUE, $groupId), $this->_query);
	}
	
	/**
	 * Make changes to all venues in a venue group
	 * 
	 * @param string The ID of the venue group to access
	 * @return array
	 */
	public function getCampaigns($groupId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_getResponse(sprintf(self::URL_VENUE_GROUPS_CAMPAIGNS, $groupId));
	}
	
	/**
	 * Make changes to a venue
	 * 
	 * @param string The venue id to edit
	 * @return array
	 */
	public function editVenue($venueGroupId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
			
		return $this->_post(sprintf(self::URL_VENUE_GROUPS_EDIT_VENUE, $venueGroupId), $this->_query);
	}
	
	/**
	 * Remove a venue from a venue group.
	 * 
	 * @param string The ID of the venue group to modify
	 * @return array
	 */
	public function removeVenue($groupId, $venueId) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query['venueId'] = $venueId;
		
		return $this->_post(sprintf(self::URL_VENUE_GROUPS_REMOVE, $groupId), $this->_query);
	}
	
	/**
	 * Updates a venue group
	 * 
	 * @param string The ID of the venue group to modify
	 * @param string Venue ID that will become the new set of venue IDs for the group.
	 * @param string The new name to give to the group.
	 * @return array
	 */
	public function updateVenueGroup($groupId, $venueId, $name) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string 
			
		$this->_query['venueId']	= $venueId;
		$this->_query['name'] 		= $name;
		
		return $this->_post(sprintf(self::URL_VENUE_GROUPS_UPDATE, $groupId), $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}