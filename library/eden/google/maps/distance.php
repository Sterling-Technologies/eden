<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Map distance Class
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
	 * Set Distance to avoid highways
	 *
	 * @return this
	 */
	public function avoidHighways() {
		$this->_query['avoid'] = 'highways';
		return $this;
	}
	
	/**
	 * Set Distance to avoid tolls
	 *
	 * @return this
	 */
	public function avoidTolls() {
		$this->_query['avoid']  = 'tolls';
		return $this;
	}
	
	/**
	 * Specifies the mode of transport to use when 
	 * calculating directions is bicycling.
	 *
	 * @return this
	 */
	public function bicycling() {
		$this->_query['mode']  = 'bicycling';
		return $this;
	}
	
	/**
	 * Specifies the mode of transport to use when 
	 * calculating directions is driving.
	 *
	 * @return this
	 */
	public function driving() {
		$this->_query['mode']  = 'driving';
		return $this;
	}
	
	/**
	 * Specifies the mode of transport to use when 
	 * calculating directions is walking.
	 *
	 * @return this
	 */
	public function walking() {
		$this->_query['mode']  = 'walking';
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
		$this->_query['language'] = $language;
		
		return $this;
	}
	
	/**
	 * Returns distances in miles and feet.
	 *
	 * @return this
	 */
	public function setUnitToImperial() {
		$this->_query['units']  = 'imperial';
		
		return $this;
	}
	
	/**
	 * Returns travel distance and time for a matrix of origins and destinations
	 *
	 * @param string|integer|float
	 * @param string|integer|float
	 * @param string
	 * @return array
	 */
	public function getResponse($origin, $destination, $sensor = 'false') {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string', 'int', 'float')		//argument 1 must be a string, integer or float
			->argument(2, 'string', 'int', 'float')		//argument 2 must be a string, integer or float
			->argument(3, 'string');					//argument 3 must be a string	
			
		$this->_query['origin'] 		= $origin;
		$this->_query['sensor'] 		= $sensor;
		$this->_query['destinations']	= $destination;
		
		return $this->_getResponse(self::URL_MAP_DISTANCE, $this->_query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}