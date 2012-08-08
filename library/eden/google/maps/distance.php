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
class Eden_Google_Maps_Distance extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_DISTANCE = 'http://maps.googleapis.com/maps/api/distancematrix/json';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey			= NULL;
	protected $_origins			= NULL;
	protected $_destinations	= NULL;
	protected $_mode			= NULL;
	protected $_language 		= NULL;
	protected $_avoid 			= NULL;
	protected $_units 			= NULL;
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
	 * Returns elevation information
	 *
	 * @return array
	 */
	public function getDistance() {
		//populate paramenter
		$query = array(
			'origins'		=> $this->_origins,			//required
			'sensor'		=> $this->_sensor,			//required
			'destinations'	=> $this->_destinations,	//required
			'language'		=> $this->_language,
			'avoid'			=> $this->_avoid,
			'units'			=> $this->_units);	
		
		return $this->_getResponse(self::URL_MAP_DISTANCE, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}