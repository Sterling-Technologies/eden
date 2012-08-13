<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square pages
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Pages extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_PAGES_SEARCH 		= 'https://api.foursquare.com/v2/pages/search'; 
	const URL_PAGES_TIMESERIES 	= 'https://api.foursquare.com/v2/pages/%s/timeseries'; 
	const URL_PAGES_VENUES	 	= 'https://api.foursquare.com/v2/pages/%s/venues'; 
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_twitter		= NULL;
	protected $_fbId		= NULL;
	protected $_endAt		= NULL;
	protected $_fields		= NULL;
	protected $_location	= NULL;
	protected $_raduis		= NULL;
	protected $_offset		= NULL;
	protected $_limit		= NULL;
	
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
	 * Set twitter account
	 * 
	 * @param string
	 * @return this
	 */
	public function setTwitter($twitter) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_twitter  = $twitter; 
		
		return $this;
	}
	
	/**
	 * Set twitter account
	 * 
	 * @param string
	 * @return this
	 */
	public function setFacebookId($fbId) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_fbId  = $fbId; 
		
		return $this;
	}
	
	/**
	 * Specifies which fields to return. May be one or more of 
	 * totalCheckins, newCheckins, uniqueVisitors, sharing, 
	 * genders, ages, hours, 
	 * 
	 * @param string
	 * @return this
	 */
	public function setFields($fields) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		//if the input value is not allowed
		if(!in_array($fields, array('totalCheckins', 'newCheckins', 'uniqueVisitors', 'sharing', 'genders', 'ages', 'hours'))) {
			//throw error
			Eden_Foursquare_Error::i()
				->setMessage(Eden_Foursquare_Error::INVALID_FIELDS_PAGES) 
				->addVariable($fields)
				->trigger();
		}
		
		$this->_fields  = $fields; 
		
		return $this;
	}
	
	/**
	 * The end of the time range to retrieve stats for (seconds since epoch).
	 * If omitted, the current time is assumed.
	 * 
	 * @param string YYYY-MM-DD
	 * @return this
	 */
	public function setEndTime($endTime) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');						
		$this->_endAt = strtotime($endTime);
		
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
			
		$this->_location  = $longtitude.', '.$latitude; 
		
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
		$this->_radius = $radius;
		
		return $this;
	}
	
	/**
	 * The number of venues to return. Defaults to 20, max of 100.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setLimit($limit) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_limit = $limit;
		
		return $this;
	}
	
	/**
	 * The offset of which venues to return. Defaults to 0.
	 * 
	 * @param integer
	 * @return this
	 */
	public function setOffset($offset) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'int');						
		$this->_offset = $offset;
		
		return $this;
	}
	
	/**
	 * Returns a list of pages matching the search term.  
	 *  
	 * @param string A search term to be applied against page names.
	 * @return this
	 */
	public function search($name) {
		//argument test
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$query = array(
			'name'		=> $name,
			'twitter'	=> $this->_twitter,		//optional
			'fbid'		=> $this->_fbId);		//optionalc
		
		return $this->_getResponse(self::URL_PAGES_SEARCH, $query);
	}
	
	/**
	 * Get daily venue stats for venues managed by a page over a time range.
	 *  
	 * @param string The page whose venues to get timeseries data for
	 * @param string The start of the time range to retrieve stats for
	 * @return this
	 */
	public function getTimeSeries($pageId, $startAt) {
		//argument test
		Eden_Foursquare_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$query = array(
			'startAt'	=> strtotime($startAt),		
			'endAt'		=> $this->_endAt,		//optional
			'fields'	=> $this->_fields);		//optional
		
		return $this->_getResponse(sprintf(self::URL_PAGES_TIMESERIES, $pageId), $query);
	}
	
	/**
	 * Allows you to get the page's venues.
	 *  
	 * @param string The page id for which venues are being requested.
	 * @return this
	 */
	public function getVenue($pageId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		$query = array(
			'll'		=> $this->_location,	//optional	
			'radius'	=> $this->_radius,		//optional
			'offset'	=> $this->_offset,		//optional 
			'limit'		=> $this->_limit);		//optional
		
		return $this->_getResponse(sprintf(self::URL_PAGES_VENUES, $pageId), $query);
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}