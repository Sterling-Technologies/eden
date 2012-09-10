<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Four Square base
 *
 * @package    Eden
 * @category   foursquare
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Foursquare_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ACCESS_TOKEN	= 'oauth_token';
	const KEY			= 'key'; 
	const MAX_RESULTS	= 'maxResults';
	const FORM_HEADER	= 'application/x-www-form-urlencoded';
	const CONTENT_TYPE	= 'Content-Type: application/json';
	const SELF			= 'self';
	const VERIFY		= 'v';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token		= NULL;
	protected $_maxResult	= NULL;
	protected $_headers		= array(self::FORM_HEADER, self::CONTENT_TYPE);
	protected $_query		= array();
	protected $_meta		= array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/	
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
	
	/**
	 * Set Maximum results of query
	 *
	 * @param int
	 * @return array
	 */
	public function setMaxResult($maxResult) {
		Eden_Google_Error::i()->argument(1, 'int');
		$this->_maxResult = $maxResult;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _reset() {
		//foreach this as key => value
		foreach ($this as $key => $value) {
			//if the value of key is not array
			if(!is_array($this->$key)) {
				//if key name starts at underscore, probably it is protected variable
				if(preg_match('/^_/', $key)) {
					//if the protected variable is not equal to token
					//we dont want to unset the access token
					if($key != '_token') {
						//reset all protected variables that currently use
						$this->$key = NULL;
					}
				}
			} 
        } 
		
		return $this;
	}
	
	protected function _accessKey($array) {
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			
			if($val == false || $val == NULL || empty($val)) {
				unset($array[$key]);
			}
			
		}
		
		return $array;
	}
	
	protected function _getResponse($url, array $query = array()) {
		//add access token to query
		$query[self::ACCESS_TOKEN] = $this->_token;
		//add current date for verification
		$query[self::VERIFY] = date('Ymd', time());
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//build url query
		$url .= '?'.http_build_query($query);
		//reset variables
		unset($this->_query);
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60);
			
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	protected function _post($url, array $query = array()) {
		//add access token to query
		$url = $url.'?'.self::ACCESS_TOKEN.'='.$this->_token;
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		//add current date for verification
		$query[self::VERIFY] = date('Ymd', time());
		//build a to string query
		$query = http_build_query($query);
		//reset variables
		unset($this->_query);

		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPostFields($query);
		
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}