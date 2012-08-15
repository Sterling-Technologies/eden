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
		//return file_get_contents($this->_requestUrl);
		return $this->Eden_Curl()
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
	
	protected function _postRequest($query, $headers = array()) {
		
		$curl = Eden_Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl('https://'.$this->_host.'/')
			->setPost(true)
			->setHeaders($headers)
			->setPostFields($query);
		
		die($curl->getResponse());
		return $curl->getResponse();
	}
	
}