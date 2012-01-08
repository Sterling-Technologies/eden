<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Eventbrite oauth
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Eventbrite_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_user 	= NULL;
	protected $_api 	= NULL;
	protected $_meta	= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i($user, $api) {
		return self::_getMultiple(__CLASS__, $user, $api);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct($user, $api) {
		//argument test
		Eden_Eventbrite_Error::i()
			->argument(1, 'string','array')	//Argument 1 must be a string or array
			->argument(2, 'string');		//Argument 2 must be a string
			
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
		Eden_Google_Error::i()->argument(1, 'string', 'null');
		
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
	
	protected function _getXmlResponse($url, array $query = array()) {
		$response = $this->_getResponse($url, $query);
		return simplexml_load_string($response);
	}
	
	protected function _getResponse($url, array $query = array()) {
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		
		$query['app_key'] = $this->_api;
		if(is_array($this->_user)) {
			$query['user'] = $this->_user[0];
			$query['password'] = $this->_user[1];
		} else {
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
	
	/* Private Methods
	-------------------------------*/
}