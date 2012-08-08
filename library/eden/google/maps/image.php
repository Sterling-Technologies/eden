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
	protected $_apiKey		= NULL;
	protected $_center		= NULL;
	protected $_zoom		= NULL;
	protected $_size		= NULL; 
	protected $_scale		= NULL;
	protected $_format		= NULL;
	protected $_maptype		= NULL;
	protected $_language	= NULL;
	protected $_region		= NULL;
	protected $_markers		= NULL;
	protected $_path		= NULL;
	protected $_visible		= NULL;
	protected $_style		= NULL;
	protected $_location	= NULL;
	protected $_heading		= NULL;
	protected $_fov			= NULL;
	protected $_pitch		= NULL;
	protected $_sensor		= 'false';
	
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
	 * Defines the center of the map, 
	 * equidistant from all edges of the map.
	 *
	 * @param string|int|float
	 * @param string|int|float
	 * @return this
	 */
	public function setCenter($latitude, $longtitude) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'string', 'int', 'float')		//argument 1 must be a string, integer or float
			->argument(2, 'string', 'int', 'float');	//argument 2 must be a string, integer or float
		
		$this->_center = $latitude.', '.$longtitude;
		
		return $this;
	}
	
	/**
	 * Defines the zoom level of the map, 
	 * which determines the magnification level of the map.
	 *
	 * @param int|float
	 * @return this
	 */
	public function setZoom($zoom) {
		//argument 1 must be a integer or float
		Eden_Google_Error::i()->argument(1, 'int', 'float');		
		
		$this->_zoom = $zoom;
		
		return $this;
	}
	
	/**
	 * Defines the rectangular dimensions of the map image.
	 *
	 * @param integer
	 * @param integer
	 * @return this
	 */
	public function setSize($horizontal, $vertical) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'int')	//argument 1 must be a integer 
			->argument(2, 'int');	//argument 2 must be a integer 	
		
		$this->_size = $horizontal.'x'.$vertical;
		
		return $this;
	}
	
	/**
	 * Affects the number of pixels that are returned.
	 *
	 * @param integer
	 * @return this
	 */
	public function setScale($scale) {
		//argument 1 must be a integer 	
		Eden_Google_Error::i()->argument(1, 'int');	
		
		$this->_scale = $scale;
		
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
		
		$this->_format = $format;
		
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
	public function setToRoadMap() {
		$this->_maptype  = 'roadmap';
		
		return $this;
	}
	
	/**
	 * Specifies a satellite image
	 *
	 * @return this
	 */
	public function setToSatelliteMap() {
		$this->_maptype  = 'satellite';
		
		return $this;
	}
	
	/**
	 * Specifies a physical relief map image, 
	 * showing terrain and vegetation.
	 *
	 * @return this
	 */
	public function setToTerrainMap() {
		$this->_maptype  = 'terrain';
		
		return $this;
	}
	
	/**
	 * Specifies a hybrid of the satellite and 
	 * roadmap image, showing a transparent layer 
	 * of major streets and place names on the satellite image.
	 *
	 * @return this
	 */
	public function setToHybridMap() {
		$this->_maptype  = 'hybrid';
		
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
		
		$this->_language = $language;
		
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
		
		$this->_region = $region;
		
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
		
		$this->_markers = $markers;
		
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
		
		$this->_path  = $path;
		
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
		
		$this->_visible  = $visible;
		
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
		
		$this->_style  = $style;
		
		return $this;
	}
	
	/**
	 * The street location
	 *
	 * @param integer|string|float
	 * @param integer|string|float
	 * @return this
	 */
	public function setLocation($longtitude, $latitude) {
		//argument testing
		Eden_Google_Error::i()
			->argument(1, 'int', 'string', 'float')		//argument 1 must be a integer, string or float 
			->argument(2, 'int', 'string', 'float');	//argument 2 must be a integer, string or float
		
		$this->_location = $longtitude.','.$latitude;
		
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
		
		$this->_heading  = $heading;
		
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
		
		$this->_fov  = $fov;
		
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
		
		$this->_pitch  = $pitch;
		
		return $this;
	}
	
	/**
	 * specifies whether the application requesting the static 
	 * map is using a sensor to determine the user's location.
	 *
	 * @return this
	 */
	public function setSensor() {
		
		$this->_sensor  = 'true';
		
		return $this;
	}
	
	/**
	 * Return url of the image map
	 *
	 * @return url
	 */
	public function getStaticMap() {
		//location Parameters
		$location = array(
			'center'	=> $this->_center,	//required
			'zoom'		=> $this->_zoom);	//required
		
		//map Parameters
		$map = array(
			'size'		=> $this->_size,	//required	
			'scale'		=> $this->_scale,
			'format'	=> $this->_format,
			'maptype'	=> $this->_maptype,
			'language'	=> $this->_language,
			'region'	=> $this->_region);
		
		//feature Parameters
		$feature = array(
			'markers'	=> $this->_markers,
			'path'		=> $this->_path,
			'visible'	=> $this->_visible,
			'style'		=> $this->_style);
		
		//reporting Parameters
		$reporting = array('sensor' => $this->_sensor); //required
		
		//make a query
		$query = array_merge($location, $map, $feature, $reporting);
		
		return $this->_getResponse(self::URL_MAP_IMAGE_STATIC, $query);
	}
	
	/**
	 * Return url of the street map
	 *
	 * @return url
	 */
	public function getStreetMap() {
		//populate paramenter
		$query = array(
			'size'		=> $this->_size,		//required
			'location'	=> $this->_location,	//required
			'sensor'	=> $this->_sensor,		//required
			'heading'	=> $this->_heading,
			'fov'		=> $this->_fov,
			'pitch'		=> $this->_pitch);	
	
		return $this->_getResponse(self::URL_MAP_IMAGE_STREET, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}