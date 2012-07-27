<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Website Payments Pro - Authorization and Capture
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Authorization extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const DO_AUTHORIZATION		= 'DoAuthorization';
	const DO_CAPTURE			= 'DoCapture';
	const DO_REAUTHORIZATION	= 'DoReauthorization';
	const DO_VOID				= 'DoVoid';
	
	const TRANSACTION_ID	= 'TRANSACTIONID';
	const AUTHORIZATION_ID	= 'AUTHORIZATIONID';
	
	const ENTITY			= 'TRANSACTIONENTITY';
	const ORDER				= 'Order';
	const ACK				= 'ACK';
	const SUCCESS			= 'Success';		
	const AMOUNT			= 'AMT';				
	const CURRENCY			= 'CURRENCYCODE';
	const COMPLETE_TYPE		= 'COMPLETETYPE';
	const COMPLETE			= 'COMPLETE';
	const NO_COMPLETE		= 'NoComplete';
	const NOTE				= 'NOTE';
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_amout			= NULL;
	protected $_currency		= NULL;
	protected $_completeType	= NULL;
	protected $_note			= NULL;
	protected $_transactionId	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}	
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Authorize a payment. 
	 *
	 * @return string
	 */
	public function doAuthorization() {
    	//populate fields
		$query = array(
			self::TRANSACTION_ID	=> $this->_transactionId,
			self::AMOUNT			=> $this->_amount,					//amount of the payment
			self::ENTITY			=> self::ORDER,						//Type of transaction to authorize
			self::CURRENCY			=> $this->_currency);				//currency code, default is USD
		//call request method
		$response = $this->_request(self::DO_AUTHORIZATION, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   // Get the transaction Id
		   return $response[self::TRANSACTION_ID];	   
		} 
		
		return $response;	
	}
	
	/**
	 * Captures an authorized payment. 
	 *
	 * @return string
	 */
	public function doCapture() {
    	//populate fields
		$query = array(
			self::AUTHORIZATION_ID	=> $this->_transactionId,			//Transaction Id
			self::AMOUNT			=> $this->_amount,					//amount of the payment
			self::CURRENCY			=> $this->_currency,				//currency code, default is USD
			self::COMPLETE_TYPE		=> $this->_completeType,			//Valid values are Complete or	NotComplete
			self::NOTE				=> $this->_note);					//An informational note about the settlement
			
		//call request method
		$response = $this->_request(self::DO_CAPTURE, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   // Get the authorization Id
		   return $response[self::AUTHORIZATION_ID];	   
		} 
		
		return $response;	
	}
	
	/**
	 * Re-authorize a payment. 
	 *
	 * @return string
	 */
	public function doReAuthorization() {
    	//populate fields
		$query = array(
			self::AUTHORIZATION_ID	=> $this->_transactionId,
			self::AMOUNT			=> $this->_amount,					//amount of the payment
			self::CURRENCY			=> $this->_currency);				//currency code, default is USD
		//call request method
		$response = $this->_request(self::DO_REAUTHORIZATION, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   // Get the authorization ID 
		   return $response[self::AUTHORIZATION_ID];	   
		} 
		
		return $response;	
	}
	
	/**
	 * Void an order or an authorization. 
	 *
	 * @return string
	 */
	public function doVoid() {
    	//populate fields
		$query = array(
			self::AUTHORIZATION_ID	=> $this->_transactionId,
			self::NOTE				=> $this->_note);					//An informational note about the settlement
		//call request method
		$response = $this->_request(self::DO_VOID, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   // Get the authorization ID 
		   return $response[self::AUTHORIZATION_ID];	   
		} 
		
		return $response;	
	}
	
	/**
	 * Set item amount  
	 *
	 * @param integer|float Item amount
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Paypal_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Set complete type to complete
	 * Complete - This the last capture you intend to make
	 *
	 * @return this
	 */
	public function setComplete() {
		$this->_completeType = self::COMPLETE;
		return $this;
	}
	
	/**
	 * Set currency code 
	 *
	 * @param string Currency code
	 * @return this
	 */
	public function setCurrency($currency) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_currency = $currency;
		return $this;
	}
	
	/**
	 * Set complete type to no complete
	 * NoComplete - You intend to make additional captures.
	 *
	 * @return this
	 */
	public function setNoComplete() {
		$this->_completeType = self::NO_COMPLETE;
		return $this;
	}
	
	/**
	 * An informational note about this settlement that 
	 * is displayed to the buyer in email and in their 
	 * transaction history.
	 *
	 * @param string
	 * @return this
	 */
	public function setNote($note) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_note = $note;
		return $this;
	}
	
	/**
	 * Set Transaction Id
	 *
	 * @param string
	 * @return this
	 */
	public function setTransactionId($transactionId) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_transactionId = $transactionId;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}