<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Authorize Base - Sends requests to the Authorize.Net gateways.
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const LIVE_URL		= 'https://secure.authorize.net/gateway/transact.dll';
    const TEST_URL		= 'https://test.authorize.net/gateway/transact.dll';
	const LIVE_XML_URL	= 'https://api.authorize.net/xml/v1/request.api';
	const TEST_XML_URL	= 'https://apitest.authorize.net/xml/v1/request.api';
	const VERSION		= '3.1';
	const XML			= 'xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"';
	const MERCHANT		= 'merchantAuthentication';
	const NAME			= 'name';
	const KEY			= 'transactionKey';
	const XMLNS			= 'xmlns';
	const SCHEMA		= 'AnetApi/xml/v1/schema/AnetApiSchema.xsd';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_xmlUrl 			= self::TEST_XML_URL;
	protected $_url				= self::TEST_URL;
	protected $_isLive			= false;
	protected $_apiLogin		= NULL;
    protected $_transactionKey	= NULL;
	protected $_certificate		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct($apiLogin, $transactionKey, $certificate, $live = false){
		//Argument test
		Eden_Authorizenet_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string') 	//Argument 2 must be a string
			->argument(3, 'string') 	//Argument 3 must be a string
			->argument(4, 'bool');		//Argument 4 must ba a boolean
			
		$this->_isLive			= $live;	
        $this->_time			= time();
		$this->_sequence		= '123'.$this->_time;
		$this->_apiLogin		= $apiLogin;
        $this->_transactionKey	= $transactionKey;
		$this->_certificate		= $certificate;	
    }
	
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/	
	protected function _constructXml($requestType) {	
        $this->_xml = new SimpleXMLElement('<'.$requestType.'/>');
		$this->_xml->addAttribute(self::XMLNS, self::SCHEMA);

        $merchant = $this->_xml->addChild(self::MERCHANT);
        $merchant->addChild(self::NAME,$this->_apiLogin);
        $merchant->addChild(self::KEY, $this->_transactionKey);
		
		return $this;
    }
	 
	protected function _getFingerprint($amount){
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'float','int');		

		$signature = sprintf('%s^%s^%s^%s^', $this->_apiLogin, $this->_sequence, $this->_time, $amount);
		
		return hash_hmac('md5', $signature, $this->_transactionKey); 
	}

	protected function _process($xml) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
	
		//If it is in live mode
		if($this->_isLive) {
			$this->_xmlUrl = self::LIVE_XML_URL;
		}		
		//Execute curl 
		$curl = Eden_Curl::i()
			->setUrl($this->_xmlUrl)			
			->setPostFields($xml)			
			->setHeader(false)
			->setTimeout(45)
			->verifyHost(true)
			->setHttpHeader(array('Content-Type: text/xml'))
			->verifyPeer(false)
			->setPost(true);
			
		//Close curl
		$response = $curl->getResponse();
		//Replace all occurrences of the search
		$responses = str_replace(self::XML, '', $response);
		//Call SimpleXMLElement class
		$xml = new SimpleXMLElement($responses);
		
		return array(
			'resultCode' 		=> (string) $xml->messages->resultCode,
			'code'       		=> (string) $xml->messages->message->code,
			'text'       		=> (string) $xml->messages->message->text,	
			'validation'      	=> (string) $xml->validationDirectResponse,
			'directResponse'	=> (string) $xml->directResponse,
			'profileId'        	=> (int) 	$xml->customerProfileId,
			'addressId'        	=> (int) 	$xml->customerAddressId,
			'ids'				=> (int) 	$xml->ids,
			'paymentProfileId' 	=> (int) 	$xml->customerPaymentProfileId);
    }
	
	protected function _sendRequest($post){
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		//if it is in live mode
		if($this->_isLive) {
			$this->_url = self::LIVE_URL;
		}
		//Execute curl 
		$curl = Eden_Curl::i()
			->setUrl($this->_url)			
			->setPostFields($post)			
			->setHeader(false)
			->setTimeout(45)
			->verifyHost(true)
			->setCaInfo($this->_certificate)	
			->setPost(true);
			
		return $curl->getResponse();
    }
	
	/* Private Methods
	-------------------------------*/
}
