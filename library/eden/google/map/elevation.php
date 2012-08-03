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
class Eden_Google_Map_Elevation extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_ELEVATION	= 'http://maps.googleapis.com/maps/api/elevation/json';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey		= NULL;
	protected $_locations	= NULL;
	protected $_path		= NULL;
	protected $_samples		= NULL;
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
	 * Defines the location(s) on the earth from which to return elevation data.
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
		
		$this->_locations = $latitude.','.$longtitude;
		
		return $this;
	}
	
	/**
	 * Defines a path on the earth for which to return elevation data.
	 *
	 * @param string|int|float
	 * @param string|int|float
	 * @return this
	 */
	public function setPath($latitude, $longtitude) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string', 'int', 'float')		//argument 1 must be a string, integer or float
			->argument(2, 'string', 'int', 'float');	//argument 2 must be a string, integer or float
		
		$this->_path = $latitude.', '.$longtitude;
		
		return $this;
	}
	
	/**
	 * Specifies the number of sample points along a 
	 * path for which to return elevation data.
	 *
	 * @param string|integer
	 * @return this
	 */
	public function setSamples($samples) {
		//argument 1 must be a string or integer	
		Eden_Google_Error::i()->argument(1, 'string', 'int');	
		
		$this->_samples = $samples;
		
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
	public function getElevation() {
		//populate paramenter
		$query = array(
			'locations'	=> $this->_locations,	//required
			'sensor'	=> $this->_sensor,		//required
			'path'		=> $this->_path,
			'samples'	=> $this->_samples);	
		
		return $this->_getResponse(self::URL_MAP_ELEVATION, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}