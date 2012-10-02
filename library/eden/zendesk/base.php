<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk base 
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const CONTENT_TYPE	= 'Content-Type: application/json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta		= array();
	protected $_headers		= array(self::CONTENT_TYPE);
	protected $_subdomain	= NULL;
	protected $_email		= NULL;
	protected $_token		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($subdomain, $email, $token) {
		//argument test
		Eden_ZenDesk_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_subdomain 	= $subdomain;
		$this->_email 		= $email;
		$this->_token 		= $token;
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	protected function _accessKey($array) {
		
		foreach($array as $key => $val) {
			// if value is array
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			//if value in null
			if($val == NULL || empty($val)) {
				//remove it from query
				unset($array[$key]);
			}
		}
		return $array;
	}
	
	
	protected function _delete($url, array $query = array()) {
		 //if query is set
		if(!empty($query)) { 
			//prevent sending fields with no value
			$query = $this->_accessKey($query);
			//generate a url
			$url = $url.'?'.http_build_query($query);
		}
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUserPwd($this->_email.'/token:'.$this->_token)
			->setUrl($url)
			->setHeaders($this->_headers)
			->setCustomRequest('DELETE');
			
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 				= $curl->getMeta();
		$this->_meta['url'] 		= $url;
		$this->_meta['headers'] 	= $this->_headers;
		$this->_meta['query'] 		= $query;
		$this->_meta['response'] 	= $response;
		print_r($this->_meta);
		//reset protected variables
		unset($this->_query); 
		
		return $response;
	}
		
	protected function _getResponse($url, array $query = array()) {
		//if query is set
		if(!empty($query)) { 
			//prevent sending fields with no value
			$query = $this->_accessKey($query);
			//generate a url
			$url = $url.'?'.http_build_query($query);
		}
		//set curl
		$curl =  Eden_Curl::i()
			->setUrl($url)
			->setUserPwd($this->_email.'/token:'.$this->_token)
			->verifyHost(false)
			->verifyPeer(false)
			->setUserAgent('MozillaXYZ/1.0')
			->setTimeout(60);
		//get response from curl
		$response = $curl->getJsonResponse();
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		//reset protected variables
		unset($this->_query); 
		
		return $response; 
		
	}
	
	protected function _post($url, array $query = array()) {
		//if query is set
		if(!empty($query)) {
			//prevent sending fields with no value
			$query = $this->_accessKey($query);
			//json encode query
			$query = json_encode($query);
		}
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setUserPwd($this->_email.'/token:'.$this->_token)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($this->_headers);
		//get response form curl
		$response = $curl->getJsonResponse();		
		
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['url'] 		= $url;
		$this->_meta['headers'] 	= $this->_headers;
		$this->_meta['query'] 		= $query;
		$this->_meta['response']	= $response;
		//reset protected variables
		unset($this->_query); 
		print_r($this->_meta);
		return $response;
	}
	
	protected function _upload($url, array $query = array(), $type) {
		//build URL with query
		$url = $url.'?'.http_build_query($query);
		//seperate the files from query
		foreach($query as $value) {
			//get the raw files
			$files = file_get_contents($value);
		}
		//make a post headers
		$headers = array('Content-type:  '.$type, 'Content-Length:  '.strlen($files));
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setUserPwd($this->_email.'/token:'.$this->_token)
			->setPost(true)
			->setPostFields($files)
			->setHeaders($headers);
		//get response form curl
		$response = $curl->getJsonResponse();		
		
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['url'] 		= $url;
		$this->_meta['headers'] 	= $headers;
		$this->_meta['query'] 		= $query;
		$this->_meta['response']	= $response;
		//reset protected variables
		unset($this->_query); 
		
		return $response;
	}
	
	protected function _put($url, array $query = array()) {
		//prevent sending fields with no value
		$query = $this->_accessKey($query); 
		//covent query to json format
		$query = json_encode($query);
		//add access token to the url
		
		
		//Open a file resource using the php://memory stream
		$fh = fopen('php://memory', 'rw');
		// Write the data to the file
		fwrite($fh, $query);
		// Move back to the beginning of the file
		rewind($fh); 
	
		//start curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setHeaders($this->_headers)
			->setPut(true)
			->setUrl($url)
			->setUserPwd($this->_email.'/token:'.$this->_token)
			->setInFile($fh)
			->setInFileSize(strlen($query));
			
		//get the response
		$response = $curl->getJsonResponse();
		
		$this->_meta 					= $curl->getMeta();
		$this->_meta['url'] 			= $url;
		$this->_meta['headers'] 		= $this->_headers;
		$this->_meta['query'] 			= $query;
		print_r($this->_meta);
		//reset protected variables
		unset($this->_query); 

		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}