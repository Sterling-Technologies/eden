<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Map Static Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Map_Direction extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_DIRECTION = 'http://maps.googleapis.com/maps/api/directions/json';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey			= NULL;
	protected $_origins			= NULL;
	protected $_destinations	= NULL;
	protected $_samples			= NULL;
	protected $_mode			= NULL;
	protected $_language 		= NULL;
	protected $_avoid 			= NULL;
	protected $_units 			= NULL;
	protected $_waypoints 		= NULL;
	protected $_alternatives	= NULL;
	protected $_departureTime	= NULL;
	protected $_arrivalTime		= NULL;
	protected $_region			= NULL;
	protected $_sensor 			= 'false';
	
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
	 * Sets origin of direction
	 *
	 * @param string|int|float
	 * @return this
	 */
	public function setOrigins($origins) {
		//argument 1 must be a string, integer or float
		Eden_Google_Error::i()->argument(1, 'string', 'int', 'float');	
		
		$this->_origins = $origins;
		
		return $this;
	}
	
	/**
	 * Sets destination of direction
	 *
	 * @param string|int|float
	 * @return this
	 */
	public function setDestinations($destination) {
		//argument 1 must be a string, integer or float
		Eden_Google_Error::i()->argument(1, 'string', 'int', 'float');	
		
		$this->_destinations = $destination;
		
		return $this;
	}
	
	/**
	 * Specifies the mode of transport to use when 
	 * calculating directions is driving.
	 *
	 * @return this
	 */
	public function setModeToDriving() {
		$this->_mode  = 'driving';
		
		return $this;
	}
	
	/**
	 * Specifies the mode of transport to use when 
	 * calculating directions is walking.
	 *
	 * @return this
	 */
	public function setModeToWalking() {
		$this->_mode  = 'walking';
		
		return $this;
	}
	
	/**
	 * Specifies the mode of transport to use when 
	 * calculating directions is bicycling.
	 *
	 * @return this
	 */
	public function setModeToBicycling() {
		$this->_mode  = 'bicycling';
		
		return $this;
	}
	
	/**
	 * Requests directions via public transit 
	 * routes. Both arrivalTime and departureTime are 
	 * only valid when mode is set to "transit".
	 *
	 * @return this
	 */
	public function setModeToTransit() {
		$this->_mode  = 'transit';
		
		return $this;
	}
	
	/**
	 * The language in which to return results.
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setLanguage($language) {
		//argument 1 must be a string or integer	
		Eden_Google_Error::i()->argument(1, 'string', 'int');	
		
		$this->_language = $language;
		
		return $this;
	}
	
	/**
	 * Waypoints alter a route by routing it through the specified location(s)
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setWaypoints($waypoint) {
		//argument 1 must be a string or integer	
		Eden_Google_Error::i()->argument(1, 'string', 'int');	
		
		$this->_waypoint = $waypoint;
		
		return $this;
	}
	
	/**
	 * The region code
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setRegion($region) {
		//argument 1 must be a string or integer	
		Eden_Google_Error::i()->argument(1, 'string', 'int');	
		
		$this->_region = $region;
		
		return $this;
	}
	
	/**
	 * Set Distance to avoid tolls
	 *
	 * @return this
	 */
	public function setAvoidToTolls() {
		$this->_avoid  = 'tolls';
		
		return $this;
	}
	
	/**
	 * Set Distance to avoid highways
	 *
	 * @return this
	 */
	public function setAvoidToHighways() {
		$this->_avoid  = 'highways';
		
		return $this;
	}
	
	/**
	 * Returns distances in miles and feet.
	 *
	 * @return this
	 */
	public function setUnitToImperial() {
		$this->_units  = 'imperial';
		
		return $this;
	}
	
	/**
	 * Specifies whether the application requesting 
	 * elevation data is using a sensor (such as a GPS device) 
	 * to determine the user's location
	 *
	 * @return this
	 */
	public function setSensor() {
		$this->_sensor  = 'true';
		
		return $this;
	}
	
	/**
	 * Specifies that the Directions service may 
	 * provide more than one route alternative in the response.
	 *
	 * @return this
	 */
	public function setAlternatives() {
		$this->_Alternatives  = 'true';
		
		return $this;
	}
	
	/**
	 * Specifies the desired time of departure for transit directions as seconds
	 * -timespamp
	 *
	 * @param string|int
	 * @return this
	 */
	public function setDepartureTime($departureTime) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		$this->_departureTime = $departureTime;
		
		return $this;
	}
	
	/**
	 * specifies the desired time of arrival for transit directions as seconds
	 * -timespamp
	 *
	 * @param string|int
	 * @return this
	 */
	public function setArrivalTime($arrivalTime) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		$this->_arrivalTime = $arrivalTime;
		
		return $this;
	}
	
	/**
	 * Returns elevation information
	 *
	 * @return array
	 */
	public function getDirection() {
		//populate paramenter
		$query = array(
			'origin'		=> $this->_origins,			//required
			'sensor'		=> $this->_sensor,			//required
			'destination'	=> $this->_destinations,	//required
			'alternatives'	=> $this->_alternatives,
			'region'		=> $this->_region,
			'departureTime'	=> $this->_departureTime,
			'arrivalTime'	=> $this->_arrivalTime,
			'language'		=> $this->_language,
			'avoid'			=> $this->_avoid,
			'units'			=> $this->_units);	
		

		return $this->_getResponse(self::URL_MAP_DIRECTION, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}