<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Express Checkout
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista <sbuenavista@openovate.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Paypal_ExpressCheckout extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const TEST_URL		= 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=%s';
	const LIVE_URL		= 'https://www.paypal.com/webscr?cmd=_express-checkout&token=%s';
	
	const SET_METHOD		= 'SetExpressCheckout';
	const GET_METHOD		= 'GetExpressCheckout';
	const DO_METHOD			= 'DoExpressCheckout';
	const DO_ADDRESS_VERIFY	= 'AddressVerify';
	const CALL_BACK			= 'Callback';
	const GET_BALANCE		= 'GetBalance';
	const MASS_PAYMENT		= 'MassPay';
	const GET_DETAIL		= 'GetPalDetails';
	
	const SUCCESS	= 'Success';
	const ACK		= 'ACK';
	const TOKEN		= 'TOKEN';
	const SALE		= 'Sale';
	const ERROR		= 'L_LONGMESSAGE0';
	
	const RETURN_URL = 'RETURNURL';				
	const CANCEL_URL = 'CANCELURL';					
	
	const TOTAL_AMOUNT		= 'PAYMENTREQUEST_0_AMT';		
	const SHIPPING_AMOUNT	= 'PAYMENTREQUEST_0_SHIPPINGAMT';
	const CURRENCY			= 'PAYMENTREQUEST_0_CURRENCYCODE';
	const ITEM_AMOUNT		= 'PAYMENTREQUEST_0_ITEMAMT';	
	const ITEM_NAME			= 'L_PAYMENTREQUEST_0_NAME0';	
	const ITEM_DESCRIPTION	= 'L_PAYMENTREQUEST_0_DESC0';		
	const ITEM_AMOUNT2		= 'L_PAYMENTREQUEST_0_AMT0';		
	const QUANTITY			= 'L_PAYMENTREQUEST_0_QTY0';
	const EMAIL				= 'EMAIL';
	const STREET			= 'STREET';
	const ZIP				= 'ZIP';
	const RETURN_CURRENCIES	= 'RETURNALLCURRENCIES';
	const EMAIL_SUBJECT		= 'EMAILSUBJECT';
	
	const PAYMENT_ACTION	= 'PAYMENTACTION';					
	const PAYER_ID			= 'PAYERID';						
	const TRANSACTION_ID	= 'PAYMENTINFO_0_TRANSACTIONID';
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_callBack		= false;
	protected $_currencies		= 0;
	
	protected $_amount			= NULL;
	protected $_shippingAmount	= NULL;
	protected $_currency		= NULL;
	protected $_itemAmount		= NULL;
	protected $_itemName		= NULL;
	protected $_itemDescription	= NULL;
	protected $_quantity		= NULL;
	protected $_email			= NULL;
	protected $_street			= NULL;
	protected $_zip				= NULL;
	protected $_emailSubject	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
		
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Set callback to true  
	 *	
	 * @return this
	 */
	public function setCallBack() {	
		$this->_callBack = 'true';
		return $this;
	}
	
	/**
	 * Set the amount of the item  
	 *
	 * @param integer or float		Amount of the item
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Paypal_Error::i()->argument(1, 'integer', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Set shipping amount of the item  
	 *
	 * @param integer or float		Shipping amount of the item
	 * @return this
	 */
	public function setShippingAmount($shippingAmount) {
		//Argument 1 must be an integer or float
		Eden_Paypal_Error::i()->argument(1, 'integer', 'float');	
		
		$this->_shippingAmount = $shippingAmount;
		return $this;
	}
	
	/**
	 * Set currrency  
	 *
	 * @param string		Currency code
	 * @return this
	 */
	public function setCurrency($currency) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_currency = $currency;
		return $this;
	}
	
	/**
	 * Set total amount of the item 
	 *
	 * @param integer or float		Total amount of the item
	 * @return this
	 */
	public function setItemAmount($itemAmount) {
		//Argument 1 must be an integer or float
		Eden_Paypal_Error::i()->argument(1, 'integer', 'float');	
		
		$this->_itemAmount = $itemAmount;
		return $this;
	}
	
	/**
	 * Set item name  
	 *
	 * @param string		Item name
	 * @return this
	 */
	public function setItemName($itemName) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_itemName = $itemName;
		return $this;
	}
	
	/**
	 * Set item descrption  
	 *
	 * @param string		Item Description
	 * @return this
	 */
	public function setItemDescription($itemDescription) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_itemDescription = $itemDescription;
		return $this;
	}
	
	/**
	 * Set quantity of item  
	 *
	 * @param integer		Item quantity
	 * @return this
	 */
	public function setQuantity($quantity) {
		//Argument 1 must be a integer
		Eden_Paypal_Error::i()->argument(1, 'int');	
		
		$this->_quantity = $quantity;
		return $this;
	}
	
	/**
	 * Set consumer email  
	 *
	 * @param string		consumer email
	 * @return this
	 */
	public function setEmail($email) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_email = $email;
		return $this;
	}
	
	/**
	 * Set consumer street  
	 *
	 * @param string		consumer street
	 * @return this
	 */
	public function setStreet($street) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_street = $street;
		return $this;
	}
	
	/**
	 * Set consumer zip code  
	 *
	 * @param string		consumer zip code
	 * @return this
	 */
	public function setZip($zip) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_zip = $zip;
		return $this;
	}
	
	/**
	 * Indicates whether to return all currencies.   
	 *	
	 * @return this
	 */
	public function setCurrencies() {
		$this->_currencies = 1;
		return $this;
	}
	
	/**
	 * Indicates whether to return all currencies.   
	 *
	 * @param boolean		
	 * @return this
	 */
	public function setEmailSubject($emailSubject) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_emailSubject = $emailSubject;
		return $this;
	}
	
	/**
	 * Sends checkout information to paypal  
	 *
	 * @param string		The Return URL
	 * @param string		The Cancel URL
	 * @param array
	 * @return string
	 */
	public function getResponse($return, $cancel) {
		//Argument Test
		Eden_Paypal_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
		$query = array(
			self::RETURN_URL 		=> $return,
			self::CANCEL_URL 		=> $cancel,
			self::TOTAL_AMOUNT		=> $this->_amount,			//amount of item
			self::SHIPPING_AMOUNT	=> $this->_shippingAmount,	//amount of shipping
			self::CURRENCY			=> $this->_currency,		//currency code
			self::ITEM_AMOUNT		=> $this->_itemAmount,		//item amount is shippingAmount minus amount
			self::ITEM_NAME			=> $this->_itemName,		//name of item
			self::ITEM_DESCRIPTION	=> $this->_itemDescription,	//description of item
			self::ITEM_AMOUNT2		=> $this->_itemAmount,		//item amount is shipping minus amount
			self::QUANTITY			=> $this->_quantity);		//quantity of item
		
		//call request method set express checkout
		$response = $this->_request(self::SET_METHOD, $query);
		
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
			//fetch token
			$this->_token = $response[self::TOKEN];
			//if callback is true
			if($this->_callBack) {
				return $this->_getCallback();
			}
			//redirect to paypal with token
			header('Location: '. sprintf(self::TEST_URL, urlencode($this->_token)) );
			
			//if token is exist and not empty
			if($this->_token) {
				return $this->_getTransactionId();
			}
		}
		
		return $response;
	}
	
	/**
	 * Confirms whether a postal address and postal 
	 * code match those of the specified PayPal 
	 * account holder.  
	 *
	 * @return string
	 */
	public function checkAddress() {
		$query = array(
			self::EMAIL		=> $this->_email,
			self::STREET	=> $this->_street,
			self::ZIP		=> $this->_zip);
		
		//call request method address verify
		$response = $this->_request(self::DO_ADDRESS_VERIFY, $query);
		// If checking successful
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) { 
			
			return $response;
		}
		
		return $response;
	}
	
	/**
	 * Obtains the available balance for a PayPal account. 
	 *
	 * @return string
	 */
	public function getBalance() {
		// Indicates whether to return all currencies.
		$query = array(self::RETURN_CURRENCIES	=> $this->_currencies);
		//call request method call back
		return $this->_request(self::GET_BALANCE, $query);
					
	}
	
	/**
	 * Makes a payment to one or more PayPal account holders.
	 *
	 * @return string
	 */
	public function doMassPayment() {
	
		$query = array(
			self::EMAIL_SUBJECT	=> $this->_emailSubject,	//The subject line of the email that PayPal sends 
			self::CURRENCY		=> $this->_currency);		//currency code
		//call request method call back
		return $this->_request(self::MASS_PAYMENT, $query);
				
	}
	
	/**
	 * Obtains your Pal ID, which is the PayPal-assigned merchant 
	 * account number, and other information about your account. 
	 * You need the account number when working with dynamic 
	 * versions of PayPal buttons and logos.
	 *
	 * @return string
	 */
	public function getDetail() {			
		//call request method call back
		return $this->_request(self::GET_DETAIL);
				
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getCallback() {
		//currency code
		$query = array(self::CURRENCY	=> $this->_currency,
					   self::TOKEN		=> $this->_token);	
		//call request method call back
		return $this->_request(self::CALL_BACK, $query);
	
	}
	protected function _getTransactionId() {
		// Get checkout details, including buyer information, call get express checkout method
		$checkoutDetails = $this->_request(self::GET_METHOD, array(self::TOKEN => $this->_token));
		
		// Complete the checkout transaction
		$query = array(
		   self::TOKEN			=> $this->_token,
		   self::PAYMENT_ACTION	=> self::SALE,
		   self::PAYER_ID		=> $this->_payer,
		   self::TOTAL_AMOUNT	=> $this->_amount, 		// Same amount as in the original request
		   self::CURRENCY		=> $this->_currency); 	// Same currency as the original request
		
		//call request method do express checckout
		$response = $this->_request(self::DO_METHOD, $query);
		
		// If payment successful
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) { 
			// Fetch the transaction ID 
			return $response[self::TRANSACTION_ID];
		}
		
		return array();
	}
	
	/* Private Methods
	-------------------------------*/
}