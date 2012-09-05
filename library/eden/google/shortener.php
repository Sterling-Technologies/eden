<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google calendar
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Shortener extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const GOOGLE_SHORTENER_ANALYTICS	= 'https://www.googleapis.com/urlshortener/v1/url';
	const GOOGLE_SHORTENER_GET 			= 'https://www.googleapis.com/urlshortener/v1/url/history';
	const GOOGLE_SHORTENER_CREATE		= 'https://www.googleapis.com/urlshortener/v1/url';
	
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
	
	public function __construct($key, $token) {
		//Argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 1 must be a string
			
		$this->_apiKey 	= $key;
		$this->_token 	= $token;
	}
	
	/* Public Methods
	-------------------------------*/
	/** 
	 * Retrieves a list of URLs shortened by the authenticated user
	 *
	 * @return array
	 */
	public function getList() {
	
		return $this->_getResponse(self::GOOGLE_SHORTENER_GET, $this->_query);
	}
	
	/**
	 * Returns full analytics of this short url
	 *
	 * @param string short url
	 * @return array
	 */
	public function getAnalytics($url) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');		
		
		$this->_query['shortUrl'] = $url;
		
		return $this->_getResponse(self::GOOGLE_SHORTENER_ANALYTICS, $this->_query);
		
	} 
	
	/**
	 * Creates a new short URL
	 *
	 * @param string long url
	 * @return array
	 */
	public function createShortUrl($url) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');		
		
		$this->_query['longUrl'] = $url;
		
		return $this->_post(self::GOOGLE_SHORTENER_CREATE, $this->_query);
		
	}
	
	/**
	 * Set start token
	 *
	 * @param string 
	 * @return array
	 */
	public function setStartToken($startToken) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_query['start-token'] = $startToken;
		
		return $this;
	} 
	
	/**
	 * Acceptable values are:
	 * 'ANALYTICS_CLICKS' - Returns only click counts.
	 * 'ANALYTICS_TOP_STRINGS' - Returns only top string counts.
	 * 'FULL' - Returns the creation timestamp and all available analytics.
	 *
	 * @param string 
	 * @return array
	 */
	public function setProjection($projection) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');		
		$this->_query['projection'] = $projection;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}