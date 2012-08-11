<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Base
 *
 * @package    Eden
 * @category   paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const VERSION		= '84.0';
	const TEST_URL		= 'https://api-3t.sandbox.paypal.com/nvp';
	const LIVE_URL		= 'https://api-3t.paypal.com/nvp';
    const SANDBOX_URL	= 'https://test.authorize.net/gateway/transact.dll';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta		= array();
	protected $_url			= NULL;
	protected $_user		= NULL;
	protected $_password	= NULL;
	protected $_signature	= NULL;
	protected $_certificate	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($user, $password, $signature, $certificate, $live = false) {
		$this->_user		= $user;
		$this->_password	= $password;
		$this->_signature	= $signature;
		$this->_certificate	= $certificate; 
		
		$this->_url	= self::TEST_URL;
		$this->_baseUrl = self::TEST_URL;
		if($live) {
			$this->_url = self::LIVE_URL;
			$this->_baseUrl = self::LIVE_URL;
		}
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Populates after a request has been sent
	 *
	 * @return array
	 */
	public function getMeta() {
		return $this->_meta;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _accessKey($array) {
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			
			if($val == false || $val == NULL || empty($val) || !$val) {
				unset($array[$key]);
			}
			
		}
		
		return $array;
	}
	
	protected function _request($method, array $query = array(), $post = true) {
      	//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');
		
		//Our request parameters
		$default = array(
			'USER'		=> $this->_user,
			'PWD'		=> $this->_password,
			'SIGNATURE' => $this->_signature,
			'VERSION'	=> self::VERSION,
			'METHOD'	=> $method);
		
		//generate URL-encoded query string to build our NVP string
		$query = http_build_query($query + $default);
		
		$curl = Eden_Curl::i()
			->setUrl($this->_baseUrl)
			->setVerbose(true)
			->setCaInfo($this->_certificate)
			->setPost(true)
			->setPostFields($query);
			
		$response = $curl->getQueryResponse();
		
		$this->_meta['url']			= $this->_baseUrl;
		$this->_meta['query']		= $query;
		$this->_meta['curl']		= $curl->getMeta();
		$this->_meta['response']	= $response;
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}