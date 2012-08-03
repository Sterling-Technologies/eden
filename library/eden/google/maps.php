<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Maps
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Google_Maps extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
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
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns Google maps direction
	 *
	 * @return Eden_Google_Map_Direction
	 */
	public function direction() {
			
		return Eden_Google_Map_Direction::i($this->_token);
	}
	
	/**
	 * Returns Google maps distance
	 *
	 * @return Eden_Google_Map_Distance
	 */
	public function distance() {
			
		return Eden_Google_Map_Distance::i($this->_token);
	}
	
	/**
	 * Returns Google maps elevation
	 *
	 * @return Eden_Google_Map_Elevation
	 */
	public function elevation() {
			
		return Eden_Google_Map_Elevation::i($this->_token);
	}
	
	/**
	 * Returns Google maps geocoding
	 *
	 * @return Eden_Google_Map_Geocoding
	 */
	public function geocoding() {
			
		return Eden_Google_Map_Geocoding::i($this->_token);
	}
	
	/**
	 * Returns Google maps image
	 *
	 * @return Eden_Google_Map_Image
	 */
	public function image() {
			
		return Eden_Google_Map_Image::i($this->_token);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}