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
	const ACCESS_TOKEN	= 'access_token';
	const KEY			= 'key'; 
	const MAX_RESULTS	= 'maxResults';
	const FORM_HEADER	= 'application/x-www-form-urlencoded';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_token			= NULL;
	protected $_maxResult		= NULL;
	
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
		$query[self::ACCESS_TOKEN] = $this->_token;
		$query[self::KEY] = Eden_Google_Oauth::i()->getApiKey();
		$query[self::MAX_RESULTS] = $this->_maxResult;
		//prevent sending fields with no value
		$query = $this->_accessKey($query);
		
		$url .= '?'.http_build_query($query);
		
		return $this->Eden_Curl()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60)
			->getResponse();
	}
	
	protected function _post($url, $query = array()) {
		$headers = array();
		$headers[] = self::FORM_HEADER;
		$headers[] = 'Content-Type: application/json';
		
		$separator = '?';
		if(strpos($url, '?') !== false) {
			$separator = '&';
		}
		
		if(is_array($query)) {
			$query = $this->_accessKey($query);//prevent sending fields with no value
			$query = json_encode($query);
		}
		
		$url .= $separator.self::ACCESS_TOKEN.'='.$this->_token;
		$url .= '&'.self::KEY.'='.Eden_Google_Oauth::i()->getApiKey();
		$url .= ($this->_maxResult)? '&'.self::MAX_RESULTS.'='.$this->_maxResult: NULL;
		
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

	protected function _put($url, $query = array()) {
		$separator = '?';
		if(strpos($url, '?') !== false) {
			$separator = '&';
		}
		
		if(is_array($query)) {
			$query = $this->_accessKey($query); //prevent sending fields with no value
			$query = json_encode($query);
		}
		
		$url .= $separator.self::ACCESS_TOKEN.'='.$this->_token;
		$url .= '&'.self::KEY.'='.Eden_Google_Oauth::i()->getApiKey();
		$url .= ($this->_maxResult)? '&'.self::MAX_RESULTS.'='.$this->_maxResult: NULL;
		
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPut(true)
			->setPost(true)
			->setPostFields($query);
			
		//get the response
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['query'] 			= $query;
		
		return $response;
	}
	
	protected function _delete($url) {
		$headers = array();
		$headers[] = self::FORM_HEADER;
		$headers[] = 'Content-Type: application/json';
		
		$separator = '?';
		if(strpos($url, '?') !== false) {
			$separator = '&';
		}
		
		$url .= $separator.self::ACCESS_TOKEN.'='.$this->_token;
		$url .= '&'.self::KEY.'='.Eden_Google_Oauth::i()->getApiKey();
		$url .= ($this->_maxResult)? '&'.self::MAX_RESULTS.'='.$this->_maxResult: NULL;
		
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setHeaders($headers)
			->setCustomRequest(Eden_Curl::DELETE);
			
		//get the response
		$response = $curl->getResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $headers;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}