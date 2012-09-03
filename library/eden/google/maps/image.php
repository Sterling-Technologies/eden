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
class Eden_Google_Maps_Image extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_MAP_IMAGE_STATIC	= 'http://maps.googleapis.com/maps/api/staticmap';
	const URL_MAP_IMAGE_STREET	= 'http://maps.googleapis.com/maps/api/streetview';
	
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
	
	public function __construct($apiKey) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_apiKey = $apiKey; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Affects the number of pixels that are returned.
	 *
	 * @param integer
	 * @return this
	 */
	public function setScale($scale) {
		//argument 1 must be a integer 	
		Eden_Google_Error::i()->argument(1, 'int');	
		
		$this->_query['scale'] = $scale;
		
		return $this;
	}
	
	/**
	 * Defines the format of the resulting image. 
	 * By default, the Static Maps API creates PNG images.
	 *
	 * @param string
	 * @return this
	 */
	public function setFormat($format) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['format'] = $format;
		
		return $this;
	}
	
	/**
	 * Defines the language to use for display of labels on map tiles
	 *
	 * @param string
	 * @return this
	 */
	public function setLanguage($language) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['language'] = $language;
		
		return $this;
	}
	
	/**
	 * Defines the appropriate borders to display, 
	 * based on geo-political sensitivities.
	 *
	 * @param string
	 * @return this
	 */
	public function setRegion($region) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['region'] = $region;
		
		return $this;
	}
	
	/**
	 * Define one or more markers to attach to the image at
	 * specified locations. 
	 *
	 * @param string
	 * @return this
	 */
	public function setMarkers($markers) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['markers'] = $markers;
		
		return $this;
	}
	
	/**
	 * Defines a single path of two or more connected points 
	 * to overlay on the image at specified locations.
	 *
	 * @param string
	 * @return this
	 */
	public function setPath($path) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['path']  = $path;
		
		return $this;
	}
	
	/**
	 * Specifies one or more locations that should remain 
	 * visible on the map, though no markers or other 
	 * indicators will be displayed.
	 *
	 * @param string
	 * @return this
	 */
	public function setVisible($visible) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['visible']  = $visible;
		
		return $this;
	}
	
	/**
	 * Defines a custom style to alter the presentation of a 
	 * specific feature (road, park, etc.) of the map.
	 *
	 * @param string
	 * @return this
	 */
	public function setStyle($style) {
		//argument 1 must be a string 	
		Eden_Google_Error::i()->argument(1, 'string');	
		
		$this->_query['style']  = $style;
		
		return $this;
	}
	
	/**
	 * Indicates the compass heading of the camera. 
	 * Accepted values are from 0 to 360 (both values 
	 * indicating North, with 90 indicating East, and 180 South).
	 *
	 * @param integer
	 * @return this
	 */
	public function setHeading($heading) {
		//argument 1 must be a integer	
		Eden_Google_Error::i()->argument(1, 'int');	
		
		$this->_query['heading']  = $heading;
		
		return $this;
	}
	
	/**
	 * Determines the horizontal field of view of the image. 
	 * The field of view is expressed in degrees, with a 
	 * maximum allowed value of 120. 
	 *
	 * @param integer
	 * @return this
	 */
	public function setFov($fov) {
		//argument 1 must be a integer	
		Eden_Google_Error::i()->argument(1, 'int');	
		
		$this->_query['fov']  = $fov;
		
		return $this;
	}
	
	/**
	 * specifies the up or down angle of the camera relative 
	 * to the Street View vehicle.
	 *
	 * @param integer
	 * @return this
	 */
	public function setPitch($pitch) {
		//argument 1 must be a integer	
		Eden_Google_Error::i()->argument(1, 'int');	
		
		$this->_query['pitch']  = $pitch;
		
		return $this;
	}
	
	/**
	 * Specifies a standard roadmap image, as is normally 
	 * shown on the Google Maps website. If no maptype 
	 * value is specified, the Static Maps API serves 
	 * roadmap tiles by default.
	 *
	 * @return this
	 */
	public function useRoadMap() {
		$this->_query['maptype']  = 'roadmap';
		
		return $this;
	}
	
	/**
	 * Specifies a satellite image
	 *
	 * @return this
	 */
	public function useSatelliteMap() {
		$this->_query['maptype']  = 'satellite';
		
		return $this;
	}
	
	/**
	 * Specifies a physical relief map image, 
	 * showing terrain and vegetation.
	 *
	 * @return this
	 */
	public function useTerrainMap() {
		$this->_query['maptype']  = 'terrain';
		
		return $this;
	}
	
	/**
	 * Specifies a hybrid of the satellite and 
	 * roadmap image, showing a transparent layer 
	 * of major streets and place names on the satellite image.
	 *
	 * @return this
	 */
	public function useHybridMap() {
		$this->_query['maptype']  = 'hybrid';
		
		return $this;
	}
	
	/**
	 * Return url of the image map
	 *
	 * @param string Defines the center of the map, latitude,longitude pai or address pair
	 * @param string Defines the zoom level of the map, which determines the magnification level of the map
	 * @param string This parameter takes a string of the form {horizontal_value}x{vertical_value}
	 * @param string
	 * @return url
	 */
	public function getStaticMap($center, $zoom, $size, $sensor = 'false') {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string')		//argument 3 must be a string
			->argument(4, 'string');	//argument 4 must be a string	
			
		$this->_query['center']	= $center;
		$this->_query['zoom']	= $zoom;
		$this->_query['size']	= $size;
		$this->_query['sensor'] = $sensor;		
		
		return $this->_getResponse(self::URL_MAP_IMAGE_STATIC, $this->_query);
	}
	
	/**
	 * Return url of the street map
	 *
	 * @param string Latitude,longitude pai or address pair
	 * @param string Size is specified as {width}x{height}
	 * @param string
	 * @return url
	 */
	public function getStreetMap($location, $size, $sensor = 'false') {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
			
		$this->_query['size']		= $size;		
		$this->_query['location']	= $location;	
		$this->_query['sensor']		= $sensor;		
		
		return $this->_getResponse(self::URL_MAP_IMAGE_STREET, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}