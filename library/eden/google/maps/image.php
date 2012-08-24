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
	protected $_scale		= NULL;
	protected $_format		= NULL;
	protected $_maptype		= NULL;
	protected $_language	= NULL;
	protected $_region		= NULL;
	protected $_markers		= NULL;
	protected $_path		= NULL;
	protected $_visible		= NULL;
	protected $_style		= NULL;
	protected $_heading		= NULL;
	protected $_fov			= NULL;
	protected $_pitch		= NULL;
	
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
			
		//populate fields
		$query = array(
			'center'	=> $center,	
			'zoom'		=> $zoom,
			'size'		=> $size,
			'sensor' 	=> $sensor,		
			'scale'		=> $this->_scale,		//optional
			'format'	=> $this->_format,		//optional
			'maptype'	=> $this->_maptype,		//optional
			'language'	=> $this->_language,	//optional
			'region'	=> $this->_region,		//optional
			'markers'	=> $this->_markers,		//optional
			'path'		=> $this->_path,		//optional
			'visible'	=> $this->_visible,		//optional
			'style'		=> $this->_style);		//optional
	
		return $this->_getResponse(self::URL_MAP_IMAGE_STATIC, $query);
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
			
		//populate paramenter
		$query = array(
			'size'		=> $size,		
			'location'	=> $location,	
			'sensor'	=> $sensor,		
			'heading'	=> $this->_heading,	//optional
			'fov'		=> $this->_fov,		//optional
			'pitch'		=> $this->_pitch);	//optional
	
		return $this->_getResponse(self::URL_MAP_IMAGE_STREET, $query);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}