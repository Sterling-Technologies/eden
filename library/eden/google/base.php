<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 *  Google oauth
 *
 * @package    Eden
 * @category   google
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Google_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const ACCESS_TOKEN = 'access_token';
	
	const FORM_HEADER	= 'application/x-www-form-urlencoded';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token = NULL;
	
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
	
	/* Protected Methods
	-------------------------------*/
	protected function _getResponse($url, array $query = array()) {
		$query[self::ACCESS_TOKEN] = $this->_token;
		$url .= '?'.http_build_query($query);
		
		return $this->Eden_Curl()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60)
			->getJsonResponse();
	}
	
	/**
	 * Returns the token from the server
	 *
	 * @param array
	 * @return array
	 */
	protected function _post($url, $query = array()) {
		$headers = array();
		$headers[] = self::FORM_HEADER;
		$headers[] = 'Content-Type: application/json';
		
		$separator = '?';
		if(strpos($url, '?') !== false) {
			$separator = '&';
		}
		
		if(is_array($query)) {
			$query = json_encode($query);
		}
		
		$url .= $separator.self::ACCESS_TOKEN.'='.$this->_token;
		
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