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
class Eden_Google_Maps_Elevation extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_ELEVATION	= 'http://maps.googleapis.com/maps/api/elevation/json';
	
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
		
		$this->_query['path'] = $latitude.', '.$longtitude;
		
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
		
		$this->_query['samples'] = $samples;
		
		return $this;
	}
	
	/**
	 * Returns elevation information
	 *
	 * @param string latitude,longitude pair in string(e.g. "40.714728,-73.998672") 
	 * @return array
	 */
	public function getResponse($location, $sensor = 'false') {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string	
		
		$this->_query['locations']	= $location;	
		$this->_query['sensor']		= $sensor;
		
		return $this->_getResponse(self::URL_MAP_ELEVATION, $this->_query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}