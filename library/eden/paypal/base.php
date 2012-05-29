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
	const LIVE_URL		= 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL	= 'https://test.authorize.net/gateway/transact.dll';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta		= array();
	protected $_paypalUrl	= NULL;
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
		
		$this->_paypalUrl	= self::TEST_URL;
		if($live) {
			$this->_paypalUrl = self::LIVE_URL;
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
	protected function _request($method, array $query = array()) {
      	//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');
		
		//Our request parameters
		$default = array(
			'METHOD'	=> $method,
			'VERSION'	=> self::VERSION,
			'USER'		=> $this->_user,
			'PWD'		=> $this->_password,
			'SIGNATURE' => $this->_signature);
		
		//generate URL-encoded query string to build our NVP string
		$query = http_build_query($query + $default);
  	
  		$curl = $this->Eden_Curl()
			->setUrl($this->_paypalUrl)
			->setVerbose(true)
			->setCaInfo($this->_certificate)
			->setPost(true)
			->setPostFields($query);
			
		$response = $curl->getQueryResponse();
  		$this->_meta = $curl->getMeta();
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}