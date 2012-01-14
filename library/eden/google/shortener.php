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
 */
class Eden_Google_Shortener extends Eden_Class {
	/* Constants
	-------------------------------*/
	const URL = 'https://www.googleapis.com/urlshortener/v1/url';
	const SERVICE_URL = 'http://goo.gl/';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_key 	= NULL;
	protected $_meta	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($key) {
		//Argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
			
		$this->_key = $key; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the short url version for a long url
	 *
	 * @param string long url
	 * @return string | false
	 */
	public function getShortUrl($url) {
		$query = array('longUrl' => $url);
		$response = $this->_post(self::URL, $query);
		$response = json_decode($response, true);
		
		if(!is_array($response) || !isset($response['id'])) {
			return false;	
		}
		
		return $response['id'];
	} 
	
	/**
	 * Returns the short id for a long url
	 *
	 * @param string long url
	 * @return string | false
	 */
	public function getId($url) {
		$url = $this->getShortUrl($url);
		
		if(!$url) {
			return false;
		}
		
		return substr($url, strlen(self::SERVICE_URL));
	}
	
	/**
	 * Returns the long version of this short url
	 *
	 * @param string short url
	 * @return string | false
	 */
	public function getLongUrl($url) {
		$response = $this->getAnalytics($url);
		
		if(!is_array($response) || !isset($response['longUrl'])) {
			return false;	
		}
		
		return $response['longUrl'];
	} 
	
	/**
	 * Returns full analytics of this short url
	 *
	 * @param string short url
	 * @return array
	 */
	public function getAnalytics($url) {
		
		if(strpos($url, self::SERVICE_URL) !== 0) {
			$url  = self::SERVICE_URL.$url;
		}
		
		$query = array('shortUrl' => $url, 'projection'=>'FULL');
		
		$response = $this->_getResponse(self::URL, $query);
		
		return json_decode($response, true);
	} 
	
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getResponse($url, array $query = array()) {
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		
		$query['key'] = $this->_key;
		$query 	= http_build_query($query);
		
		//determine the conector
		$connector = NULL;
		
		//if there is no question mark
		if(strpos($url, '?') === false) {
			$connector = '?';
		//if the redirect doesn't end with a question mark
		} else if(substr($url, -1) != '?') {
			$connector = '&';
		}
		
		//now add the authorization to the url
		$url .= $connector.$query;

		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	protected function _post($url, $query = array()) {
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		
		$query 	= json_encode($query);
		
		//determine the conector
		$connector = NULL;
		
		//if there is no question mark
		if(strpos($url, '?') === false) {
			$connector = '?';
		//if the redirect doesn't end with a question mark
		} else if(substr($url, -1) != '?') {
			$connector = '&';
		}
		
		//now add the authorization to the url
		$url .= $connector.'key='.$this->_key;
		
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $headers;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}