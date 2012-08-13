<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Twitter places and geo
 *
 * @package    Eden
 * @category   twitter
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Twitter_Geo extends Eden_Twitter_Base {
	/* Constants
	-------------------------------*/
	const URL_GET_PLACE				= 'https://api.twitter.com/1/geo/id/%d.json';
	const URL_GET_GEOCODE			= 'https://api.twitter.com/1/geo/reverse_geocode.json';
	const URL_SEARCH				= 'https://api.twitter.com/1/geo/search.json';
	const URL_GET_SIMILAR_PLACES	= 'https://api.twitter.com/1/geo/similar_places.json';
	const URL_CREATE_PLACE			= 'https://api.twitter.com/1/geo/place.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_accuracy	= NULL;
	protected $_granularity	= NULL;
	protected $_max			= NULL;
	protected $_callback	= NULL;
	protected $_latitude	= NULL;
	protected $_longtitude	= NULL;
	protected $_input		= NULL;
	protected $_ip			= NULL;
	protected $_contained	= NULL;
	protected $_address		= NULL;
	
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
	 * Creates a new place object at the given 
	 * latitude and longitude.
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @param float
	 * @param float
	 * @return array
	 */
	public function createPlace($name, $contained, $token, $lat, $long) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'string')	//Argument 1 must be a string
			->argument(2, 'string')	//Argument 2 must be a string
			->argument(3, 'string')	//Argument 3 must be a string
			->argument(4, 'float')	//Argument 4 must be a float
			->argument(5, 'float');	//Argument 5 must be a float
			
		//populate fields
		$query = array(
			'name'						=> $name,
			'contained_within'			=> $contained,
			'token'						=> $token,
			'lat'						=> $lat,
			'long'						=> $long,
			'attribute:street_address'	=> $this->_address,
			'callback'					=> $this->_callback);
		
		return $this->_post(self::URL_CREATE_PLACE, $query);
	}
	
	/**
	 * Given a latitude and a longitude, searches 
	 * for up to 20 places that can be used as a 
	 * place_id when updating a status
	 *
	 * @param float
	 * @param float
	 * @return array
	 */
	public function getGeocode($lat, $long) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'float')	//Argument 1 must be a float 
			->argument(2, 'float');	//Argument 2 must be a float 
			
		//populate fields
		$query = array(
			'lat' 			=> $lat,
			'long' 			=> $long,
			'accuracy'		=> $this->_accuracy,
			'granularity'	=> $this->_granularity,
			'max_results'	=> $this->_max,
			'callback'		=> $this->_callback);
		
		return $this->_getResponse(self::URL_GET_GEOCODE, $query);
	}
	
	/**
	 * Returns all the information about a known place.
	 *
	 * @param int place ID
	 * @return array
	 */
	public function getPlace($id) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');	
		
		$query = array('place_id' => $id);
		
		return $this->_getResponse(self::URL_GET_PLACE, $query);
	}
	
	/**
	 * Locates places near the given coordinates
	 * which are similar in name. 
	 *
	 * @param float
	 * @param float
	 * @param string
	 * @return array
	 */
	public function getSimilarPlaces($lat, $long, $name) {
		//Argument Test
		Eden_Twitter_Error::i()
			->argument(1, 'float')		//Argument 1 must be a float
			->argument(2, 'float')		//Argument 2 must be a float
			->argument(3, 'string');	//Argument 3 must be a string
			
		//populate fields	
		$query = array(
			'lat'						=> $lat,
			'long'						=> $long,
			'name'						=> $name,
			'contained_within'			=>	$this->_contained,
			'attribute:street_address'	=>	$this->_address,
			'callback'					=>	$this->_callback);
		
		return $this->_getResponse(self::URL_GET_SIMILAR_PLACES, $query);
	}
	
	/**
	 * Search for places that can be attached 
	 * to a statuses/update. 
	 *
	 * @return array
	 */
	public function search() {
		//populate fields
		$query = array(
			'lat'						=> $this->_latitude,
			'long'						=> $this->_longtitude,
			'query'						=> $this->_input,
			'accuracy'					=> $this->_accuracy,
			'granularity'				=> $this->_granularity,
			'max_results'				=> $this->_max,
			'contained_within'			=> $this->_contained,
			'attribute:street_address'	=> $this->_address,
			'callback'					=> $this->_callback);
		
		return $this->_getResponse(self::URL_SEARCH, $query);
	}
	
	/**
	 * Set accuracy
	 *
	 * @param string
	 * @return this
	 */
	public function setAccuracy($accuracy) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_accuracy = $accuracy;
		return $this;
	}
	
	/**
	 * Set street address
	 *
	 * @param string
	 * @return this
	 */
	public function setAddress($address) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_address = $address;
		return $this;
	}
	
	/**
	 * Set callback
	 *
	 * @param string
	 * @return this
	 */
	public function setCallback($callback) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_callback = $callback;
		return $this;
	}
	
	/**
	 * Set contained within
	 *
	 * @param string
	 * @return this
	 */
	public function setContained($contained) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_contained = $contained;
		return $this;
	}
	
	/**
	 * Set granularity
	 *
	 * @param string
	 * @return this
	 */
	public function setGranularity($granularity) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_granularity = $granularity;
		return $this;
	}
	
	/**
	 * Set query
	 *
	 * @param string
	 * @return this
	 */
	public function setInput($input) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_input = $input;
		return $this;
	}
	
	/**
	 * Set ip address
	 *
	 * @param string
	 * @return this
	 */
	public function setIp($ip) {
		//Argument 1 must be a string
		Eden_Twitter_Error::i()->argument(1, 'string');
		
		$this->_ip = $ip;
		return $this;
	}
	
	/**
	 * Set latitude
	 *
	 * @param float
	 * @return this
	 */
	public function setLatitude($latitude) {
		//Argument 1 must be a float 
		Eden_Twitter_Error::i()->argument(1, 'float');
		
		$this->_latitude = $latitude;
		return $this;
	}
	
	/**
	 * Set longtitude
	 *
	 * @param float
	 * @return this
	 */
	public function setLongtitude($longtitude) {
		//Argument 1 must be a float 
		Eden_Twitter_Error::i()->argument(1, 'float');
		
		$this->_longtitude = $longtitude;
		return $this;
	}
	
	/**
	 * Set max results
	 *
	 * @param integer
	 * @return this
	 */
	public function setMax($max) {
		//Argument 1 must be an integer
		Eden_Twitter_Error::i()->argument(1, 'int');
		
		$this->_max = $max;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}