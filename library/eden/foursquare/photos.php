<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Four square photos
 *
 * @package    Eden
 * @category   four square
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Photos extends Eden_Foursquare_Base {
	/* Constants
	-------------------------------*/
	const URL_PHOTOS_GET 	= 'https://api.foursquare.com/v2/photos/%s';
	
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
		Eden_Foursquare_Error::i()->argument(1, 'string');
		$this->_token 	= $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Get details of a photo.
	 * 
	 * @param string The ID of the photo to retrieve additional information for.
	 * @return array
	 */
	public function getDetail($photoId) {
		//argument 1 must be a string
		Eden_Foursquare_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_PHOTOS_GET, $photoId));
	}	 
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}