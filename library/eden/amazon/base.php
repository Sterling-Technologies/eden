<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon S3
 *
 * @package    Eden
 * @category   amazon
 * @author     Clark Galgo cgalgo@openovate.com
 */
class Eden_Amazon_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_host					= 'ecs.amazonaws.';
	protected $_uri						= '/onca/xml';
	protected $_params 					= array();
	protected $_method					= 'GET';
	protected $_publicKey				= NULL;
	protected $_privateKey				= NULL;
	protected $_canonicalizedQuery		= NULL;
	protected $_stringToSign			= NULL;
	protected $_signature				= NULL;
	protected $_requestUrl				= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($privateKey, $publicKey) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_privateKey	= $privateKey;
		$this->_publicKey	= $publicKey;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta() {
	
		return $this->_meta;
	}
	
	/* Set timestamp
	 * 
	 * @param string|null
	 * @return this
	 */
	public function setTimestamp($time = NULL) {
		//argument 1 must be a string, integer or null
		Eden_Amazon_Error::i()->argument(1, 'string', 'int', 'null');
		//if they dont set time
		if($time == NULL) {
			//set the time for crrent time
			$time = time();
		}
		//if it is string
		if(is_string($time)) {
			//comvert it to integer
			$time = strtotime($time);
		}
		//well format time
		$this->_params['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z", $time);
		
		return $this;
	}
	
	/* Set api version
	 * 
	 * @param string
	 * @return this
	 */
	public function setVersion($version) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Version'] = $version;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _sendRequest() {
		//set curl
		return $this->Eden_Curl()
			->setUrl($this->_requestUrl)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60)
			->getResponse();
	}
	
	protected function _setSignature($date = NULL) {
		//if date is not set
		if(is_null($date) || empty($date)) {
			$this->_signature = base64_encode(hash_hmac("sha256", $this->_stringToSign, $this->_privateKey, True));
			$this->_signature = str_replace("%7E", "~", rawurlencode($this->_signature));
		//else date is set
		} else {
			//encode signature using HmacSHA256 for SES
			$this->_signature = base64_encode(hash_hmac('sha256', $date, $this->_privateKey, true));
		
		}
		return $this;
	}
	
	protected function _postRequest($query, $headers = array()) {
		//set url
		$url = 'https://'.$this->_host.'/';
		//set curl
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setHeaders($headers)
			->setPostFields($query);
		
		$response = $curl->getResponse();
		//get curl infomation
		$this->_meta['url']			= $url;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		
		return $response;

	}
	
	protected function _getResponse() {
		//each params
		foreach ($this->_params as $param => $value) {
			//this is my custom url encode
			if(is_array($value)) {
				foreach($value as $k => $v) {
					$canonicalizedQuery[] = str_replace("%7E", "~", rawurlencode($param.'.'.$k)).'='.str_replace("%7E", "~", rawurlencode($v));
				}
				
			} else {
				$canonicalizedQuery[] = str_replace("%7E", "~", rawurlencode($param)).'='.str_replace("%7E", "~", rawurlencode($value));
			}
		}
		
		//sort parameter query
		sort($canonicalizedQuery, SORT_STRING);
		$date = gmdate('D, d M Y H:i:s e');
		//implode it to make a string of query
		$this->_canonicalizedQuery = implode("&", $canonicalizedQuery);
		//set signature
		$this->_setSignature($date);
		$query = $this->_canonicalizedQuery;
		//auth is the authentication string. we'll use that on the header of our curl request
		$auth = 'AWS3-HTTPS AWSAccessKeyId='.$this->_publicKey;
		$auth .= ',Algorithm=HmacSHA256,Signature='.$this->_signature;
		
		//assigning header variables including the authentication string
		$headers = array('X-Amzn-Authorization: '.$auth, 'Date: '.$date, 'Host: '.$this->_host);
		
		//send post request
		return $this->_postRequest($query, $headers);
	}
}
