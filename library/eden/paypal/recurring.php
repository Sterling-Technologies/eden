<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
 
/**
 * Paypal Website Payments Pro - Recurring Payment
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Recurring extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const RECURRING_PAYMENT	= 'CreateRecurringPaymentsProfile';
	const GET_DETAIL		= 'GetRecurringPaymentsProfileDetails';
	const MANAGE_STATUS		= 'ManageRecurringPaymentsProfileStatus';
	const BILL_AMOUNT		= 'BillOutstandingAmount';
	const PROFILE_ID		= 'PROFILEID';
	
	const SALE				= 'sale';
	const ACK				= 'ACK';
	const SUCCESS			= 'Success';
	const ERROR				= 'L_LONGMESSAGE0';
	const REMOTE_ADDRESS	= 'REMOTE_ADDR';
	const IP_ADDRESS		= 'IPADDRESS';			
	const PAYMENT_ACTION	= 'PAYMENTACTION';
	
	const DAY				= 'Day';
	const WEEK				= 'Week';
	const SEMI_MONTH		= 'SemiMonth';
	const MONTH				= 'Month';
	const YEAR				= 'Year';
	const CANCEL			= 'Cancel';
	const SUSPEND			= 'Suspend';
	const REACTIVATE		= 'Reactivate';

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
	const DESCRIPTION		= 'DESC';
	const START_DATE		= 'PROFILESTARTDATE';
	const BILLING_PERIOD	= 'BILLINGPERIOD';
	const BILLING_FREQUENCY	= 'BILLINGFREQUENCY';
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_profileId = NULL;
	protected $_cardType			= NULL;
	protected $_cardNumber			= NULL;
	protected $_expirationDate		= NULL;
	protected $_cvv2				= NULL;
	protected $_firstName			= NULL;
	protected $_lastName			= NULL;
	protected $_email				= NULL;
	protected $_countryCode			= NULL;
	protected $_state				= NULL;
	protected $_city				= NULL;
	protected $_street				= NULL;
	protected $_zip					= NULL;
	protected $_amout				= NULL;
	protected $_currency			= NULL;
	protected $_action				= NULL;
	protected $_note				= NULL;
	
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
	 * The action to be performed to the 
	 * recurring payments profile set 
	 * to Cancel
	 *	
	 * @return this
	 */
	public function cancel() {
		$this->_action	= self::CANCEL;
		return $this;
	}
	
	/**
	 * Bills the buyer for the outstanding balance 
	 * associated with a recurring payments profile..
	 *
	 * @return string
	 */
	public function getBilling() {
		//populate fields
 		$query = array(
				self::PROFILE_ID	=> $this->_profileId,	//profile id of consumer
				self::AMOUNT		=> $this->_amount,		//outstading amount balance
				self::NOTE			=> $this->_note);		//the reason for the change in status
		//call request method
		$response = $this->_request(self::BILL_AMOUNT, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		  
			return $response;	   
		} 
		
		return $response;	
	}
	
	/**
	 * Create a recurring payments profile using direct payment
	 * associated with a debit or credit card.
	 *
	 * @return string
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
			self::AMOUNT			=> $this->_amount,					//amount of the recurring payment
			self::CURRENCY			=> $this->_currency,				//currency code, default is USD
			self::DESCRIPTION		=> $this->_description,				//description of recurring payment
			self::START_DATE		=> date('Y-m-d H:i:s'),				//start date of the recurring billing agreement
			self::BILLING_PERIOD	=> $this->_billingPeriod,			//the unit to be used to calculate the billing cycle
			self::BILLING_FREQUENCY	=> $this->_billingFrequency);		//billing periods that make up the billing cycle.
		//call request method
		$response = $this->_request(self::RECURRING_PAYMENT, $query);	   	
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   	// Get the profile Id 
			$this->_profileId = $response[self::PROFILE_ID];
			
		   	return $this->_getDetails();
		} 
		return $response;						
	}
	
	/**
	 * Cancels, suspends, or reactivates a recurring 
	 * payments profile.
	 *
	 * @return string
	 */
	public function getStatus() {
		//populate fields
 		$query = array(
				self::PROFILE_ID	=> $this->_profileId,	//profile id of consumer
				self::ACTION		=> $this->_action,		//valid value are Cancel, Suspend and Reactivate
				self::NOTE			=> $this->_note);		//the reason for the change in status
		//call request method
		$response = $this->_request(self::MANAGE_STATUS, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		  
			return $response;	   
		} 
		
		return $response;	
	}
	
	/**
	 * The action to be performed to the 
	 * recurring payments profile set 
	 * to Reactivate
	 *		
	 * @return this
	 */
	public function reactivate() {
		$this->_action	= self::REACTIVATE;
		return $this;
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
	 * Set the billing frequency 
	 *
	 * @param integer		Billing frequency
	 * @return this
	 */
	public function setBillingFrequency($billingFrequency) {
		//Argument 1 must be an integer
		Eden_Paypal_Error::i()->argument(1, 'int');	
		
		$this->_billingFrequency = $billingFrequency;
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
	 * Set unit to be used to calculate the billing cycle
	 * to Day
	 *
	 * @return this
	 */
	public function setDay() {
		$this->_billingPeriod = self::DAY;
		return $this;
	}
	
	/**
	 * Set item description 
	 *
	 * @param string		Item description
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_description = $description;
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
	 * Set unit to be used to calculate the billing cycle
	 * to Month
	 *
	 * @return this
	 */
	public function setMonth() {
		$this->_billingPeriod = self::MONTH;
		return $this;
	}
	
	/**
	 * Set reason for the change in status
	 *
	 * @param string	The reason for the change in status	
	 * @return this
	 */
	public function setNote($note) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_note	= $note;
		return $this;
	}
	
	/**
	 * Set Profile Id
	 *
	 * @param string	a valid profile id		
	 * @return this
	 */
	public function setProfileId($profileId) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_profileId	= $profileId;
		return $this;
	}
	
	/**
	 * Set unit to be used to calculate the billing cycle
	 * to SemiMonth
	 *
	 * @return this
	 */
	public function setSemiMonth() {
		$this->_billingPeriod = self::SEMI_MONTH;
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
	 * Set to manage profile status
	 *
	 * @param boolean		
	 * @return this
	 */
	public function setStatus($status) {
		$this->_status	= $status;
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
	 * Set unit to be used to calculate the billing cycle
	 * to Week
	 *
	 * @return this
	 */
	public function setWeek() {
		$this->_billingPeriod = self::WEEK;
		return $this;
	}
	
	/**
	 * Set unit to be used to calculate the billing cycle
	 * to Year
	 *
	 * @return this
	 */
	public function setYear() {
		$this->_billingPeriod = self::YEAR;
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
	
	/**
	 * The action to be performed to the 
	 * recurring payments profile set 
	 * to Suspend
	 *		
	 * @return this
	 */
	public function suspend() {
		$this->_action	= self::SUSPEND;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getDetails() {
		//populate fields
 		$query = array(self::PROFILE_ID	=> $this->_profileId);	//profile id of consumer
		//call request method
		$response = $this->_request(self::GET_DETAIL, $query);
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
		   return $response;	   
		}
		
		return $response;	
							
	}
	/* Private Methods
	-------------------------------*/
}