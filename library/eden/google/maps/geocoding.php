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
class Eden_Google_Maps_Geocoding extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_GEOCODING	= 'http://maps.googleapis.com/maps/api/geocode/json';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey		= NULL;
	protected $_latlng		= NULL;
	protected $_address		= NULL;
	protected $_bounds		= NULL;
	protected $_language	= NULL;
	protected $_region		= NULL;
	protected $_sensor		= 'false';
	
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
	 * The textual latitude/longitude value for which you wish to obtain the closest.
	 *
	 * @param string|int|float
	 * @param string|int|float
	 * @return this
	 */
	public function setLocation($latitude, $longtitude) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string', 'int', 'float')		//argument 1 must be a string, integer or float
			->argument(2, 'string', 'int', 'float');	//argument 2 must be a string, integer or float
		
		$this->_latlng = $latitude.','.$longtitude;
		
		return $this;
	}
	
	/**
	 * The address that you want to geocode. 
	 *
	 * @param string|int
	 * @return this
	 */
	public function setAddress($address) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'integer');		
		
		$this->_address = $address;
		
		return $this;
	}
	
	/**
	 * The bounding box of the viewport within which to bias geocode results more prominently.
	 *
	 * @param string
	 * @return this
	 */
	public function setBounds($bounds) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_bounds = $bounds;
		
		return $this;
	}
	
	/**
	 * The language in which to return results. 
	 *
	 * @param string
	 * @return this
	 */
	public function setLanguage($language) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_language = $language;
		
		return $this;
	}
	
	/**
	 * The region code
	 *
	 * @param string
	 * @return this
	 */
	public function setRegion($region) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_region = $region;
		
		return $this;
	}
	
	/**
	 * Indicates whether or not the geocoding request
	 * comes from a device with a location sensor
	 *
	 * @return this
	 */
	public function setSensor() {
		$this->_sensor  = 'true';
		
		return $this;
	}
	
	/**
	 * Returns geocode information
	 *
	 * @return array
	 */
	public function getGeocode() {
		//populate paramenter
		$query = array(
			'address'	=> $this->_address,		//required
			'latlng'	=> $this->_latlng,		//required
			'sensor'	=> $this->_sensor,		//required
			'bounds'	=> $this->_bounds,
			'language'	=> $this->_language,
			'region'	=> $this->_region);	
	
		return $this->_getResponse(self::URL_MAP_GEOCODING, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}