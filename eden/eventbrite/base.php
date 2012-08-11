<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite Base
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ACCESS_HEADER = 'Authorization: Bearer %s';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_user 	= NULL;
	protected $_api 	= NULL;
	protected $_meta	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($user, $api = NULL) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string')				//Argument 1 must be a string
			->argument(2, 'string', 'null');	//Argument 2 must be a string or null
			
		$this->_api = $api; 
		$this->_user = $user; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL) {
		Eden_Eventbrite_Error::i()->argument(1, 'string', 'null');
		
		if(isset($this->_meta[$key])) {
			return $this->_meta[$key];
		}
		
		return $this->_meta;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getJsonResponse($url, array $query = array()) {
		$response = $this->_getResponse($url, $query);
		return json_decode($response, true);
	}
	
	protected function _getResponse($url, array $query = array()) {
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		
		//if api key is null
		if(is_null($this->_api)) {
			//we must have an oauth token
			$headers[] = sprintf(self::ACCESS_HEADER, $this->_user);
		} else {
			$query['app_key'] = $this->_api;
			$query['user_key'] = $this->_user;
		}
		
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
	
	protected function _getXmlResponse($url, array $query = array()) {
		$response = $this->_getResponse($url, $query);
		return simplexml_load_string($response);
	}
	
	/* Private Methods
	-------------------------------*/
}