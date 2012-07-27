<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Website Payments Pro - Direct Payment
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Direct extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const DIRECT_PAYMENT		= 'DoDirectPayment';
	const NON_REFERENCED_CREDIT	= 'DoNonReferencedCredit';

	const TRANSACTION_ID	= 'TRANSACTIONID';
	const SALE				= 'sale';
	const ACK				= 'ACK';
	const SUCCESS			= 'Success';
	const REMOTE_ADDRESS	= 'REMOTE_ADDR';
	const IP_ADDRESS		= 'IPADDRESS';			
	const PAYMENT_ACTION	= 'PAYMENTACTION';	

	const CARD_TYPE			= 'CREDITCARDTYPE';
	const CARD_NUMBER		= 'ACCT';				
	const EXPIRATION_DATE	= 'EXPDATE'	;		
	const CVV				= 'CVV2';				
	const FIRST_NAME		= 'FIRSTNAME';			
	const LAST_NAME			= 'LASTNAME';			
	const EMAIL				= 'EMAIL';			
	const COUNTRY_CODE		= 'COUNTRYCODE';		
	const STATE				= 'STATE';				
	const CITY				= 'CITY';				
	const STREET			= 'STREET';			
	const ZIP				= 'ZIP';			
	const AMOUNT			= 'AMT';				
	const CURRENCY			= 'CURRENCYCODE'; 
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_nonReferencedCredit = false;

	protected $_profileId 		= NULL;
	protected $_cardType		= NULL;
	protected $_cardNumber		= NULL;
	protected $_expirationDate	= NULL;
	protected $_cvv2			= NULL;
	protected $_firstName		= NULL;
	protected $_lastName		= NULL;
	protected $_email			= NULL;
	protected $_countryCode		= NULL;
	protected $_state			= NULL;
	protected $_city			= NULL;
	protected $_street			= NULL;
	protected $_zip				= NULL;
	protected $_amout			= NULL;
	protected $_currency		= NULL;
	
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
	 * Process a credit card direct payment 
	 *
	 * @return string
	 * @note Contact PayPal to use DoNonReferencedCredit
	 * API operation, in most cases, you should use the
	 * RefundTransaction API operation instead.
	 */
	public function getResponse() {
    	//populate fields
		$query = array(
			self::IP_ADDRESS		=> $_SERVER[self::REMOTE_ADDRESS],	//IP address of the consumer
			self::PAYMENT_ACTION	=> self::SALE,						//payment action(sale or authorize)
			self::CARD_TYPE			=> $this->_cardType,				//creidit card type
			self::CARD_NUMBER		=> $this->_cardNumber,				//credit card account number
			self::EXPIRATION_DATE	=> $this->_expirationDate,			//credit card expiration date
			self::CVV				=> $this->_cvv2,					//3 - digits card verification number
			self::FIRST_NAME		=> $this->_firstName,				//cardholder firstname
			self::LAST_NAME			=> $this->_lastName,				//cardholder lastname
			self::EMAIL				=> $this->_email,					//cardholder email
			self::COUNTRY_CODE		=> $this->_countryCode,				//cardholder country code
			self::STATE				=> $this->_state,					//cardholder state
			self::CITY				=> $this->_city,					//cardholder city
			self::STREET			=> $this->_street,					//cardholder street
			self::ZIP				=> $this->_zip,						//cardholder ZIP
			self::AMOUNT			=> $this->_amount,					//amount of the payment
			self::CURRENCY			=> $this->_currency);				//currency code, default is USD
		
		//if Set Non Referenced Credit is true
		if($this->_setNonReferencedCredit){
			//call non referenced credit method
			return $this->_setNonReferencedCredit($query);
		}
		//call direct payment method
		return $this->_setDirectPayment($query);
	}
	
	/**
	 * Set item amount  
	 *
	 * @param integer or float		Item amount
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Set credit card number  
	 *
	 * @param string		Credit card number
	 * @return this
	 */
	public function setCardNumber($cardNumber) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_cardNumber = $cardNumber;
		return $this;
	}
	
	/**
	 * Set credit card type  
	 *
	 * @param string		Credit card type
	 * @return this
	 */
	public function setCardType($cardType) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_cardType = $cardType;
		return $this;
	}
	
	/**
	 * Set cardholder city  
	 *
	 * @param string		City
	 * @return this
	 */
	public function setCity($city) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_city = $city;
		return $this;
	}
	
	/**
	 * Set cardholder country code  
	 *
	 * @param string		Country Code
	 * @return this
	 */
	public function setCountryCode($countryCode) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_countryCode = $countryCode;
		return $this;
	}
	
	/**
	 * Set currency code 
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
	 * Set Card Verification Value  
	 *
	 * @param string		3 - digit cvv number
	 * @return this
	 */
	public function setCvv2($cvv2) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_cvv2 = $cvv2;
		return $this;
	}
	
	/**
	 * Set cardholder email address 
	 *
	 * @param string		Email address
	 * @return this
	 */
	public function setEmail($email) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_email = $email;
		return $this;
	}
	
	/**
	 * Set credit card expiration date 
	 *
	 * @param string		Credit card expiration date
	 * @return this
	 */
	public function setExpirationDate($expirationDate) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_expirationDate = $expirationDate;
		return $this;
	}
	
	/**
	 * Set cardholder first name 
	 *
	 * @param string		First name
	 * @return this
	 */
	public function setFirstName($firstName) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_firstName = $firstName;
		return $this;
	}
	
	/**
	 * Set cardholder last name  
	 *
	 * @param string		Last name
	 * @return this
	 */
	public function setLastName($lastName) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_lastName = $lastName;
		return $this;
	}
	
	/**
	 * Issue a credit to a card not referenced 
	 * by the original transaction.
	 *
	 * @return this
	 */
	public function setNonReferencedCredit() {
		$this->_setNonReferencedCredit = 'true';
		return $this;
	}
	
	/**
	 * Set cardholder state  
	 *
	 * @param string		State
	 * @return this
	 */
	public function setState($state) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_state = $state;
		return $this;
	}
	
	/**
	 * Set cardholder street  
	 *
	 * @param string		Street
	 * @return this
	 */
	public function setStreet($street) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_street = $street;
		return $this;
	}
	
	/**
	 * Set cardholder zip code 
	 *
	 * @param string		Zip code
	 * @return this
	 */
	public function setZip($zip) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_zip = $zip;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setDirectPayment($query) {
		//Argument 1 must be an array
		Eden_Paypal_Error::i()->argument(1, 'array');	
		
		//do direct payment
		$response = $this->_request(self::DIRECT_PAYMENT, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   // Get the transaction ID 
		   return $response[self::TRANSACTION_ID];	   
		} 
		
		return $response;	
	}
	
	protected function _setNonReferencedCredit($query) {
		//Argument 1 must be an array
		Eden_Paypal_Error::i()->argument(1, 'array');	
		
		//call request method
		$response = $this->_request(self::NON_REFERENCED_CREDIT, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   // Get the transaction ID 
		   return $response[self::TRANSACTION_ID];	   
		} 
		
		return $response;		
	}
	
	/* Private Methods
	-------------------------------*/
}