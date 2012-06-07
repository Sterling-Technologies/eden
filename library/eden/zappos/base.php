<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zappos base
 *
 * @package    Eden
 * @category   zappos
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Zappos_Base extends Eden_Oauth_Base {
	/* Constants
	-------------------------------*/
	const URL_SEARCH	= 'http://api.zappos.com/Search';
	const URL_IMAGE		= 'http://api.zappos.com/Image';
	const URL_PRODUCT	= 'http://api.zappos.com/Product';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_apiKey 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($apiKey) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');		
		
		$this->_apiKey 	= $apiKey; 
	}
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	protected function _getResponse($method, array $query = array()) {
		//Argument 1 must be a string
		Eden_Zappos_Error::i()->argument(1, 'string');
		
		//Our request parameters
		$default = array(
			'key' => $this->_apiKey);
		
		//generate URL-encoded query string to build our NVP string
		$query = http_build_query($query + $default);

  		$curl = $this->Eden_Curl()
			->setUrl($method.'?'.$query)
			->setReturnTransfer(TRUE)
			->setHeader(false);
			
		$results = $curl->getQueryResponse();
		
		foreach($results as $key => $value) {
			
			if(!empty($value) && isset($value)) {
		
				foreach($value as $k => $v) {
					
					$response = json_decode($k.']}', false);
					
					if(empty($response)) {
						$response = json_decode($k, false);
					}
					
					break;
				}
			} else {
			
				return $key;
			}
		}
		return $response;
	}
	
	/* Private Methods
	-------------------------------*/
}