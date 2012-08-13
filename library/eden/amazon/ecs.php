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
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Amazon_Ecs extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_publicKey				= NULL;
	protected $_privateKey				= NULL;
	protected $_host					= 'ecs.amazonaws.';
	protected $_uri						= '/onca/xml';
	protected $_params 					= array();
	protected $_method					= 'GET';
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
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_privateKey = $privateKey;
		$this->_publicKey = $publicKey;
	}
	
	/* Public Methods
	-------------------------------*/
	public function setAssociateTag($tag) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['AssociateTag'] = $tag;
		
		return $this;
	}
	
	public function setCountry($country = 'com') {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_host = $this->_host.$country;
		
		return $this;
	}
	
	public function setIdType($type) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['IdType'] = $type;
		
		return $this;
	}
	
	public function setItemId($id) {
		Eden_Amazon_Error::i()->argument(1, 'string', 'int');
		$this->_params['ItemId'] = $id;
		
		return $this;
	}
	
	public function setKeyword($keyword) {
		Eden_Amazon_Error::i()->argument(1, 'string', 'int');
		$this->_params['Keywords'] = $keyword;
		
		return $this;
	}
	
	public function setMethod($method) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_method = $method;
		
		return $this;
	}
	
	public function setOperation($operation) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Operation'] = $operation;
		
		return $this;
	}
	
	public function setPage($page = 1) {
		Eden_Amazon_Error::i()->argument(1, 'int');
		$this->_params['ItemPage'] = $page;
		
		return $this;
	}
	
	public function getResponse() {
		$this->_params['AWSAccessKeyId'] = $this->_publicKey;
		
		ksort($this->_params);
		$canonicalizedQuery = array();
		foreach ($this->_params as $param => $value) {
			$param = str_replace("%7E", "~", rawurlencode($param));
			$value = str_replace("%7E", "~", rawurlencode($value));
			$canonicalizedQuery[] = $param."=".$value;
		}
		
		$this->_canonicalizedQuery = implode("&", $canonicalizedQuery);
		$this->_stringToSign = $this->_method."\n".$this->_host."\n".$this->_uri."\n".$this->_canonicalizedQuery;
		$this->_setSignature();
		$this->_requestUrl = 'http://'.$this->_host.$this->_uri.'?'.$this->_canonicalizedQuery.'&Signature='.$this->_signature;
		return $this->_sendRequest();
	}
	
	public function setResponseGroup($group) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['ResponseGroup'] = $group;
		
		return $this;
	}
	
	public function setSearchIndex($index = 'All') {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['SearchIndex'] = $index;
		
		return $this;
	}
	
	public function setService($service) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Service'] = $service;
		
		return $this;
	}
	
	public function setTimestamp($time = NULL) {
		Eden_Amazon_Error::i()->argument(1, 'string', 'int', 'null');
		if($time == NULL) {
			$time = time();
		}
		
		if(is_string($time)) {
			$time = strtotime($time);
		}
		
		$this->_params['Timestamp'] = gmdate("Y-m-d\TH:i:s\Z", $time);
		return $this;
	}
	
	public function setVersion($version) {
		Eden_Amazon_Error::i()->argument(1, 'string');
		$this->_params['Version'] = $version;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _sendRequest() {
		return Eden_Curl::i()
			->setUrl($this->_requestUrl)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60)
			->getResponse();
	}
	
	protected function _setSignature() {
		$this->_signature = base64_encode(hash_hmac("sha256", $this->_stringToSign, $this->_privateKey, True));
		$this->_signature = str_replace("%7E", "~", rawurlencode($this->_signature));
		
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}
