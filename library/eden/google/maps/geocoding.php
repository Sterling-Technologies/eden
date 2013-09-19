<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Map geocoding Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Maps_Geocoding extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_GEOCODING	= 'http://maps.googleapis.com/maps/api/geocode/json';
	
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
	 * The bounding box of the viewport within which to bias geocode results more prominently.
	 *
	 * @param string
	 * @return Eden_Google_Maps_Geocoding
	 */
	public function setBounds($bounds) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		$this->_query['bounds'] = $bounds;
		
		return $this;
	}
	
	/**
	 * Specify the Latitude & Longitude of the location to geocode
	 * 
	 * @param float Latitude
	 * @param float Longitude
	 * @return Eden_Google_Maps_Geocoding
	 */
	public function setLatLng($lat,$lng){
		// arguments 1 & 2 must be floats
		Eden_Google_Error::i()
			->argument(1, 'float')
			->argument(2, 'float');
		$this->_query['latlng'] = "{$lat},{$lng}";
		return $this;
	}
	
	/**
	 * The language in which to return results. 
	 *
	 * @param string
	 * @return Eden_Google_Maps_Geocoding
	 */
	public function setLanguage($language) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		$this->_query['language'] = $language;
		
		return $this;
	}
	
	/**
	 * The region code
	 *
	 * @param string
	 * @return Eden_Google_Maps_Geocoding
	 */
	public function setRegion($region) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		$this->_query['region'] = $region;
		
		return $this;
	}
	
	/**
	 * Set the address to geocode
	 * 
	 * @param string $address
	 * @return Eden_Google_Maps_Geocoding
	 */
	public function setAddress($address){
		// argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query['address'] = $address;
		return $this;
	}
	
	/**
	 * Set the state of the sensor flag
	 * 
	 * @param string $sensor 'true'|'false'
	 * @return Eden_Google_Maps_Geocoding
	 */
	public function setSensor($sensor = 'false'){
		// argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query['sensor']	= $sensor;
		return $this;
	}
	
	/**
	 * Returns geocode information
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getResponse($address = null, $sensor = null) {
		if($address){
			$this->setAddress($address);
		}
		if($sensor){
			$this->setSensor($sensor);
		}
		
		if(!isset($this->_query['sensor'])){
			throw Eden_Google_Error::i("Cannot make google maps api request without sensor parameter");
		}
		
		return $this->_getResponse(self::URL_MAP_GEOCODING, $this->_query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}