<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Base
 *
 * @package    Eden
 * @category   paypal
 * @author     Christian Symon M. Buenavista <sbuenavista@openovate.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
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
	public function __construct($user, $password, $signature, $certificate) {
		$this->_user		= $user;
		$this->_password	= $password;
		$this->_signature	= $signature;
		$this->_certificate	= $certificate;
		$this->_url			= self::TEST_URL;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set to API to test mode
	 *
	 * @return this
	 */
	public function setTestMode() {
		$this->_url = self::TEST_URL;
		return $this;
	}
	
	/**
	 * Set to API to Live mode
	 *
	 * @return this
	 */
	public function setLiveMode() {
		$this->_url = self::LIVE_URL;
		return $this;
	}
	
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
			->setUrl($this->_url)
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