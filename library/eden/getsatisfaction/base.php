<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Get Satisfaction base
 *
 * @package    Eden
 * @category   getsatisfaction
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Getsatisfaction_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_consumerKey 	= NULL;
	protected $_consumerSecret 	= NULL;
	protected $_accessToken 	= NULL;
	protected $_accessSecret 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret) {
		//argument test
		Eden_Getsatisfaction_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string')		//Argument 2 must be a string
			->argument(3, 'string')		//Argument 3 must be a string
			->argument(4, 'string');	//Argument 4 must be a string
			
		$this->_consumerKey 	= $consumerKey;
		$this->_consumerSecret 	= $consumerSecret;
		$this->_accessToken 	= $accessToken;
		$this->_accessSecret 	= $accessSecret;
	}
	
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
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setToken($this->_accessToken, $this->_accessSecret)
			->setSignatureToHmacSha1();
		
		$response = $rest->getJsonResponse($query);
			
		$this->_meta = $rest->getMeta();
		
		return $response;
	}
	
	protected function _post($url, $query = array(), $jsonEncode = false) {
		$rest = Eden_Oauth::i()
			->consumer($url, $this->_consumerKey, $this->_consumerSecret)
			->setToken($this->_accessToken, $this->_accessSecret)
			->setMethodToPost()
			->useAuthorization()
			->setSignatureToHmacSha1();
		
		if($jsonEncode) {
			$rest->jsonEncodeQuery();
		}
		
		$response = $rest->getJsonResponse($query);
			
		$this->_meta = $rest->getMeta();
		
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}