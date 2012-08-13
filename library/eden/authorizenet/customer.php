<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */
	
/**
 * Authorize.net - Customer Information Manager
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Customer extends Eden_Authorizenet_Base {
	/* Constants
	-------------------------------*/
	const CREATE_PROFILE			= 'createCustomerProfileRequest';
	const CREATE_PAYMENT_PROFILE	= 'createCustomerPaymentProfileRequest';
	const CREATE_SHIPPING_PROFILE	= 'createCustomerShippingAddressRequest';
	const CREATE_TRANSACTION		= 'createCustomerProfileTransactionRequest';
	const REMOVE_PROFILE			= 'deleteCustomerProfileRequest';
	const REMOVE_PAYMENT_PROFILE	= 'deleteCustomerPaymentProfileRequest';
	const REMOVE_SHIPPING_PROFILE	= 'deleteCustomerShippingAddressRequest';
	const GET_PROFILE				= 'getCustomerProfileRequest';
	const GET_PAYMENT_PROFILE		= 'getCustomerPaymentProfileRequest';
	const GET_SHIPPING_PROFILE		= 'getCustomerShippingAddressRequest';
	const UPDATE_PROFILE			= 'updateCustomerProfileRequest';
	const UPDATE_PAYMENT_PROFILE	= 'updateCustomerPaymentProfileRequest';
	const UPDATE_SHIPPING_PROFILE	= 'updateCustomerShippingAddressRequest';
	const VALIDATE					= 'validateCustomerPaymentProfileRequest';
	
	const INDIVIDUAL		= 'individual';
	const BUSINESS			= 'business';
	const CHECK				= 'check';
	const CREDIT			= 'credit';
	const TEST				= 'testMode';
	const LIVE				= 'liveMode';
	const AUTH_CAPTURE		= 'profileTransAuthCapture';
	const CAPTURE_ONLY		= 'profileTransCaptureOnly';
	const AUTH_ONLY			= 'profileTransAuthOnly';
	const PROFILE			= 'profile';
	const MERCHANT_ID		= 'merchantCustomerId';
	const DESCRIPTION		= 'description';
	const EMAIL				= 'email';
	const PAYMENT_PROFILE	= 'paymentProfiles';
	const CUSTOMER_TYPE		= 'customerType';
	const PAYMENT			= 'payment';
	const CREDIT_CARD		= 'creditCard';
	const CARD_NUMBER		= 'cardNumber';
	const EXPIRATION		= 'expirationDate';
	const BANK_ACCOUNT		= 'bankAccount';
	const ACCOUNT_TYPE		= 'accountType';
	const ACCOUNT_NAME		= 'nameOnAccount';
	const E_CHECK			= 'echeckType';
	const BANK_NAME			= 'bankName';
	const ROUTING_NAME		= 'routingNumber';
	const ACCOUNT_NUMBER	= 'accountNumber';
	const PROFILE_ID		= 'customerProfileId';
	const PAYMENT_ID		= 'customerPaymentProfileId';
	const SHIPPING_ID		= 'customerShippingAddressId';
	const PHONE_NUMBER		= 'phoneNumber';
	const FAX_NUMBER		= 'faxNumber';
	const FIRST_NAME		= 'firstName';
	const LAST_NAME			= 'lastName';
	const COMPANY			= 'company';
	const ADDRESS			= 'address';
	const CITY				= 'city';
	const COUNTRY			= 'country';
	const ZIP				= 'zip';
	const STATE				= 'state';
	const SHIPPING_LIST		= 'shipToList';
	const BILLING			= 'billTo';
	const VALIDATION		= 'validationMode';
	const TRASACTION		= 'transaction';
	const SHIPPING			= 'shipping';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_useProfile		= false;
	protected $_shipping		= false;
	protected $_type			= self::CREDIT;
	protected $_customerType	= self::INDIVIDUAL;
	protected $_profileType 	= self::AUTH_CAPTURE;
	protected $_validationMode	= self::TEST;
	
	protected $_description			= NULL;
	protected $_email				= NULL;
	protected $_billToFirstName		= NULL;
	protected $_billToLastName		= NULL;
	protected $_billToCompany		= NULL;
	protected $_billToAddress		= NULL;
	protected $_billToCity			= NULL;
	protected $_billToState			= NULL;
	protected $_billToZip			= NULL;
	protected $_billToCountry		= NULL;
	protected $_billToPhoneNumber	= NULL;
	protected $_billToFaxNumber		= NULL;
	protected $_cardNumber			= NULL;
	protected $_expirationDate		= NULL;
	protected $_accountType			= NULL;
	protected $_nameOnAccount		= NULL;
	protected $_echeckType			= NULL;
	protected $_bankName			= NULL;
	protected $_routingNumber		= NULL;
	protected $_accountNumber		= NULL;
	protected $_shipToFirstName		= NULL;
	protected $_shipToLastName		= NULL;
	protected $_shipToCompany		= NULL;
	protected $_shipToAddress		= NULL;
	protected $_shipToCity			= NULL;
	protected $_shipToState			= NULL;
	protected $_shipToZip			= NULL;
	protected $_shipToCountry		= NULL;
	protected $_shipToPhoneNumber	= NULL;
	protected $_shipToFaxNumber		= NULL;
	protected $_amount				= NULL;
	protected $_cardCode			= NULL;
	protected $_shipAmount			= NULL;
	protected $_shipName			= NULL;
	protected $_shipDescription		= NULL;
	
	protected $_customerId					= NULL;
	protected $_customerProfileId			= NULL;
	protected $_customerPaymentProfileId	= NULL;
	protected $_customerShippingAddressId	= NULL;
	
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
	 * Create a new customer payment profile for 
	 * an existing customer profile. 
	 *
	 * @return array
	 */
	public function createPaymentProfile() {
		
        $this->_constructXml(self::CREATE_PAYMENT_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		
		$paymentProfile = $this->_xml->addChild(self::PAYMENT_PROFILE);
			$paymentProfiles->addChild(self::CUSTOMER_TYPE,	$this->_customerType);
		//Populate billing parameters	
		$billTo = $paymentProfile->addChild(self::BILLING);
			$billTo->addChild(self::FIRST_NAME,		$this->_billToFirstName);
			$billTo->addChild(self::LAST_NAME,		$this->_billToLastName);
			$billTo->addChild(self::COMPANY,		$this->_billToCompany);
			$billTo->addChild(self::ADDRESS,		$this->_billToAddress);
			$billTo->addChild(self::CITY,			$this->_billToCity);
			$billTo->addChild(self::STATE,			$this->_billToState);
			$billTo->addChild(self::ZIP,			$this->_billToZip);
			$billTo->addChild(self::COUNTRY,		$this->_billToCountry);
			$billTo->addChild(self::PHONE_NUMBER,	$this->_billToPhoneNumber);
			$billTo->addChild(self::FAX_NUMBER,		$this->_billToFaxNumber);
		$payment = $paymentProfiles->addChild(self::PAYMENT);
		
		//If it is in credit transaction
		if ($this->_type === self::CREDIT) {
			 //Populate credit parameters
			$creditCard = $payment->addChild(self::CREDIT_CARD);
				$creditCard->addChild(self::CARD_NUMBER,		$this->_cardNumber);
				$creditCard->addChild(self::EXPIRATION,			$this->_expirationDate);
				
		//If it is in check transaction
		} else if ($this->_type === self::CHECK) {
			//Populate bank parameters
			$bankAccount = $payment->addChild(self::BANK_ACCOUNT);
				$bankAccount->addChild(self::ACCOUNT_TYPE,		$this->_accountType);
				$bankAccount->addChild(self::ACCOUNT_NAME,		$this->_nameOnAccount);
				$bankAccount->addChild(self::E_CHECK,			$this->_echeckType);
				$bankAccount->addChild(self::BANK_NAME, 		$this->_bankName);
				$bankAccount->addChild(self::ROUTING_NUMBER,	$this->_routingNumber);
				$bankAccount->addChild(self::ACCOUNT_NUMBER,	$this->_accountNumber);		 
		 }
		$this->_xml->addChild(self::VALIDATION,	$this->_validationMode);
			
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Create a new customer profile along with any 
	 * customer payment profiles and customer shipping 
	 * addresses for the customer profile.
	 *
	 * @return array
	 */
	public function createProfile() {
		
        $this->_constructXml(self::CREATE_PROFILE);
		
        $profile = $this->_xml->addChild(self::PROFILE);
			$profile->addChild(self::MERCHANT_ID,	$this->_customerId);
			$profile->addChild(self::DESCRIPTION,	$this->_description);
			$profile->addChild(self::EMAIL,			$this->_email);
			
		$paymentProfiles = $profile->addChild(self::PAYMENT_PROFILE);
			$paymentProfiles->addChild(self::CUSTOMER_TYPE,	$this->_customerType);
			$payment = $paymentProfiles->addChild(self::PAYMENT);
			
		//If it is in credit transaction
		if ($this->_type === self::CREDIT) {
			 //Populate credit parameters
			$creditCard = $payment->addChild(self::CREDIT_CARD);
				$creditCard->addChild(self::CARD_NUMBER,	$this->_cardNumber);
				$creditCard->addChild(self::EXPIRATION,		$this->_expirationDate);
				
		//If it is in check transaction
		} else if ($this->_type === self::CHECK) {
			//Populate bank parameters
			$bankAccount = $payment->addChild(self::BANK_ACCOUNT);
				$bankAccount->addChild(self::ACCOUNT_TYPE,		$this->_accountType);
				$bankAccount->addChild(self::ACCOUNT_NAME, 		$this->_nameOnAccount);
				$bankAccount->addChild(self::E_CHECK,			$this->_echeckType);
				$bankAccount->addChild(self::BANK_NAME, 		$this->_bankName);
				$bankAccount->addChild(self::ROUTING_NAME, 		$this->_routingNumber);
				$bankAccount->addChild(self::ACCOUNT_NUMBER,	$this->_accountNumber);	 
		 }
		 
		 //Populate shipping paramaters
		$shipToList = $profile->addChild(self::SHIPPING_LIST);
			$shipToList->addChild(self::FIRST_NAME,		$this->_shipToFirstName);
			$shipToList->addChild(self::LAST_NAME,		$this->_shipToLastName );
			$shipToList->addChild(self::COMPANY,		$this->_shipToCompany );
			$shipToList->addChild(self::ADDRESS,		$this->_shipToAddress );
			$shipToList->addChild(self::CITY,			$this->_shipToCity );
			$shipToList->addChild(self::ZIP,			$this->_shipToZip );
			$shipToList->addChild(self::COUNTRY,		$this->_shipToCountry );
			$shipToList->addChild(self::PHONE_NUMBER,	$this->_shipToPhoneNumber );
			$shipToList->addChild(self::FAX_NUMBER,		$this->_shipToFaxNumber );
			
		return $this->_process($this->_xml->asXML());
	
	}

	/**
	 * Create a new payment transaction from 
     * an existing customer profile. 
	 *
	 * @return array
	 */
	public function createProfileTransaction() {
		
        $this->_constructXml(self::CREATE_TRANSACTION);
		
		$transaction = $this->_xml->addChild(self::TRASACTION);
			$this->_profileType = $transaction->addChild(				$this->_profileType);
				$this->_profileType->addChild(self::AMOUNT,				$this->_amount);
				
				//If shipping is set
			 	if (isset($this->_shipping)) {
					//Populate shipping parameters
					$shipping = $this->_profileType->addChild(self::SHIPPING);
						$shipping->addChild(self::AMOUNT,				$this->_shipAmount);
						$shipping->addChild(self::NAME,					$this->_shipName);
						$shipping->addChild(self::DESCRIPTION,			$this->_shipDescription);
			 	}
			 		$this->_profileType->addChild(self::PROFILE_ID,		$this->_customerProfileId);
					$this->_profileType->addChild(self::PAYMENT_ID,		$this->_customerPaymentProfileId);
					$this->_profileType->addChild(self::SHIPPING_ID,	$this->_customerShippingAddressId);
	
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Create a new customer shipping address 
     * for an existing customer profile.
	 *
	 * @return array
	 */
	public function createShippingAddress() {
		
        $this->_constructXml(self::SHIPPING_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,		$this->_customerProfileId);
		//Populate address parameters
		$address = $this->_xml->addChild(self::ADDRESS);
			$address->addChild(self::FIRST_NAME,	$this->_shipToFirstName);
			$address->addChild(self::LAST_NAME,		$this->_shipToLastName);
			$address->addChild(self::COMPANY,		$this->_shipToCompany);
			$address->addChild(self::ADDRESS,		$this->_shipToAddress);
			$address->addChild(self::CITY,			$this->_shipToCity);
			$address->addChild(self::STATE,			$this->_shipToState);
			$address->addChild(self::ZIP,			$this->_shipToZip);
			$address->addChild(self::COUNTRY,		$this->_shipToCountry);
			$address->addChild(self::PHONE_NUMBER,	$this->_shipToPhoneNumber);
			$address->addChild(self::FAX_NUMBER,	$this->_shipToFaxNumber);
			
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Retrieve an existing customer profile along with all the 
	 * associated customer payment profiles and customer shipping addresses.   
	 *
	 * @return array
	 */
	public function getPaymentProfile() {
		
        $this->_constructXml(self::GET_PAYMENT_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		$this->_xml->addChild(self::PAYMENT_ID,	$this->_customerPaymentProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Retrieve all customer profile IDs you have previously 
	 * created. 
	 *
	 * @return array
	 */
	public function getProfile() {
		
        $this->_constructXml(self::GET_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Retrieve a customer shipping address for an 
	 * existing customer profile.   
	 *
	 * @return array
	 */
	public function getShippingAddress() {
		
        $this->_constructXml(self::GET_SHIPPING_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		$this->_xml->addChild(self::PAYMENT_ID,	$this->_customerPaymentProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Delete a customer payment profile from an 
	 * existing customer profile. 
	 *
	 * @return array
	 */
	public function removePaymentProfile() {
		
        $this->_constructXml(self::REMOVE_PAYMENT_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		$this->_xml->addChild(self::PAYMENT_ID,	$this->_customerPaymentProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Delete a customer profile  
	 *
	 * @return array
	 */
	public function removeProfile() {
		
        $this->_constructXml(self::REMOVE_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Delete a customer shipping address from 
	 * an existing customer profile.  
	 *
	 * @return array
	 */
	public function removeShippingAddress() {
		
        $this->_constructXml(self::REMOVE_SHIPPING_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		$this->_xml->addChild(self::PAYMENT_ID,	$this->_customerPaymentProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Set account number
	 *
	 * @param *string
	 * @return this
	 */
	public function setAccountNumber($accountNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_accountNumber = $accountNumber;
		return $this;
	}
	
	/**
	 * Set account type
	 *
	 * @param *string
	 * @return this
	 */
	public function setAccountType($accountType) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_accountType = $accountType;
		return $this;
	}
	
	/**
	 * Set amount
	 *
	 * @param *integer|float
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Set profile transaction to authorize only
	 *
	 * @return this
	 */
	public function setAuthorizeOnly() {
		$this->_profileType = self::AUTH_ONLY;
		return $this;
	}
	
	/**
	 * Set bank name
	 *
	 * @param *string
	 * @return this
	 */
	public function setBankName($bankName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_bankName = $bankName;
		return $this;
	}

	/**
	 * Set billing address
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingAddress($address) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToAddress = $address;
		return $this;
	}
	
	/**
	 * Set billing city
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingCity($city) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToCity = $city;
		return $this;
	}
	
	/**
	 * Set billing country
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingCountry($country) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToCountry = $country;
		return $this;
	}
	
	/**
	 * Set billing email
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingEmail($email) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_email = $email;
		return $this;
	}
	
	/**
	 * Set billing fax Number
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingFaxNumber($faxNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToFaxNumber = $faxNumber;
		return $this;
	}
	
	/**
	 * Set billing first name
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingFirstName($firstName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->__billToFirstName = $firstName;
		return $this;
	}
	
	/**
	 * Set billing last name
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingLastName($lastName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToLastName = $lastName;
		return $this;
	}
	
	/**
	 * Set billing phone Number
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingPhoneNumber($phoneNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToPhoneNumber = $phoneNumber;
		return $this;
	}
	
	/**
	 * Set billing state
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingState($state) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToState = $state;
		return $this;
	}
	
	/**
	 * Set billing zip
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingZip($zip) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_billToZip = $zip;
		return $this;
	}
	
	/**
	 * Set profile transaction to capture only
	 *
	 * @return this
	 */
	public function setCaptureOnly() {
		$this->_profileType = self::CAPTURE_ONLY;
		return $this;
	}
	
	/**
	 * Set card Number
	 *
	 * @param *string
	 * @return this
	 */
	public function setCardNumber($cardNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_cardNumber = $cardNumber;
		return $this;
	}
		
	/**
	 * Set echeck type
	 *
	 * @param *string
	 * @return this
	 */
	public function setECheckType($eCheck) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_echeckType = $eCheck;
		return $this;
	}
	
	/**
	 * Set description
	 *
	 * @param *string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_description = $description;
		return $this;
	}
	
	/**
	 * Set expiration Date
	 *
	 * @param *string
	 * @return this
	 */
	public function setExpiration($expirationDate) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_expirationDate = $expirationDate;
		return $this;
	}
	
	/**
	 * Set name on account
	 *
	 * @param *string
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_nameOnAccount = $name;
		return $this;
	}
	
	/**
	 * Set payment profile id
	 *
	 * @param *string
	 * @return this
	 */
	public function setPaymentId($id) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerPaymentProfileId = $id;
		return $this;
	}
	
	/**
	 * Set use profile  
	 *
	 * @return this
	 */
	public function setProfile() {
		$this->_useProfile	= true;
		return $this;
	}
	
	/**
	 * Set profile id
	 *
	 * @param *string
	 * @return this
	 */
	public function setProfileId($id) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerProfileId = $id;
		return $this;
	}
	
	/**
	 * Enable recurring billing 
	 *
	 * @return this
	 */
	public function setRecurringBilling() {
		$this->_recurringBilling = TRUE;
		return $this;
	}
	
	/**
	 * Set routing number
	 *
	 * @param *string
	 * @return this
	 */
	public function setRoutingNumber($routingNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_routingNumber = $routingNumber;
		return $this;
	}
	
	/**
	 * Set shipping in profile transaction 
	 *
	 * @return this
	 */
	public function setShipping() {
		$this->_shipping = true;
		return $this;
	}
	
	/**
	 * Set shipping address
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingAddress($address) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToAddress = $address;
		return $this;
	}
	
	/**
	 * Set shipping amount
	 *
	 * @param *integer|float
	 * @return this
	 */
	public function setShippingAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'int', 'float');	
		
		$this->_shipAmount = $amount;
		return $this;
	}
	
	/**
	 * Set shipping city
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingCity($city) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToCity = $city;
		return $this;
	}
	
	/**
	 * Set shipping company
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingCompany($company) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToCompany = $company;
		return $this;
	}
	
	/**
	 * Set shipping country
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingCountry($country) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToCountry = $country;
		return $this;
	}
	
	/**
	 * Set shipping description
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingDescription($desc) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipdescription = $desc;
		return $this;
	}	
	
	/**
	 * Set shipping fax number
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingFaxNumber($faxNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToFaxNumber = $faxNumber;
		return $this;
	}
	
	/**
	 * Set shipping first name
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingFirstName($firstName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToFirstName = $firstName;
		return $this;
	}
	
	/**
	 * Set shipping address id
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingId($id) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerShippingAddressId = $id;
		return $this;
	}
	
	/**
	 * Set shipping last name
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingLastName($lastName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToLastName = $lastName;
		return $this;
	}
	
	/**
	 * Set shipping name
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingName($name) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipName = $name;
		return $this;
	}
	
	/**
	 * Set shipping phone number
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingPhoneNumber($phoneNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToPhoneNumber = $phoneNumber;
		return $this;
	}
	
	/**
	 * Set shipping state
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingState($state) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToState = $state;
		return $this;
	}
	
	/**
	 * Set shipping zip
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingZip($zip) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipToZip = $zip;
		return $this;
	}
	
	/**
	 * Enable Tax Exemption 
	 *
	 * @return this
	 */
	public function setTaxExemption() {
		$this->_taxExempt = TRUE;
		return $this;
	}
	
	/**
	 * Set customer type to business 
	 *
	 * @return this
	 */
	public function setToBusiness() {
		$this->_customerType = self::BUSINESS;
		return $this;
	}
	
	/**
	 * Set transaction type to check 
	 *
	 * @return this
	 */
	public function setToCheck() {
		$this->_type = self::CHECK;
		return $this;
	}
	
	/**
	 * Update a customer payment profile for an 
	 * existing customer profile.
	 *
	 * @return array
	 */
	public function updatePaymentProfile() {
		
        $this->_constructXml(self::UPDATE_PAYMENT_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,			$this->_customerProfileId);
        $profile = $this->_xml->addChild(self::PROFILE);
			$profile->addChild(self::MERCHANT_ID,		$this->_customerId);
			$profile->addChild(self::DESCRIPTION,		$this->_description);
			$profile->addChild(self::EMAIL,				$this->_email);
			
		$paymentProfiles = $profile->addChild(self::PAYMENT_PROFILE);
			$paymentProfiles->addChild(self::CUSTOMER_TYPE,	$this->_customerType);
			
		$billTo = $paymentProfile->addChild(self::BILLING);
			//Populate billing parameters
			$billTo->addChild(self::FIRST_NAME,		$this->_billToFirstName);
			$billTo->addChild(self::LAST_NAME,		$this->_billToLastName);
			$billTo->addChild(self::COMPANY,		$this->_billToCompany);
			$billTo->addChild(self::ADDRESS,		$this->_billToAddress);
			$billTo->addChild(self::CITY,			$this->_billToCity);
			$billTo->addChild(self::STATE,			$this->_billToState);
			$billTo->addChild(self::ZIP,			$this->_billToZip);
			$billTo->addChild(self::COUNTRY,		$this->_billToCountry);
			$billTo->addChild(self::PHONE_NUMBER,	$this->_billToPhoneNumber);
			$billTo->addChild(self::FAX_NUMBER,		$this->_billToFaxNumber);

		$payment = $paymentProfiles->addChild(self::PAYMENT);
		
		//If it is in credit transaction
		if ($this->_type === self::CREDIT) {
			 //Populate credit parameters
			$creditCard = $payment->addChild(self::CREDIT_CARD);
				$creditCard->addChild(self::CARD_NUMBER,		$this->_cardNumber);
				$creditCard->addChild(self::EXPIRATION,			$this->_expirationDate);
				
		//If it is in check transaction		
		} else if ($this->_type === self::CHECK) {
			//Populate bank parameters
			$bankAccount = $payment->addChild(self::BANK_ACCOUNT);
				$bankAccount->addChild(self::ACCOUNT_TYPE,		$this->_accountType);
				$bankAccount->addChild(self::ACCOUNT_NAME, 		$this->_nameOnAccount);
				$bankAccount->addChild(self::E_CHECK,			$this->_echeckType);
				$bankAccount->addChild(self::BANK_NAME,			$this->_bankName);
				$bankAccount->addChild(self::ROUTING_NUMBER,	$this->_routingNumber);
				$bankAccount->addChild(self::ACCOUNT_NUMBER, 	$this->_accountNumber);		 
		 }
			$paymentProfiles->addChild(self::PAYMENT_ID,		$this->_customerPaymentProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Update an existing customer profile.
	 *
	 * @return array
	 */
	public function updateProfile() {
		
        $this->_constructXml(self::UPDATE_PROFILE);
		
		$profile = $this->_xml->addChild(self::PROFILE);
			$profile->addChild(self::MERCHANT_ID,	$this->_merchantCustomerId);
			$profile->addChild(self::DESCRIPTION,	$this->_description);
			$profile->addChild(self::EMAIL,			$this->_email);
			$profile->addChild(self::PROFILE_ID,	$this->_customerProfileId);
		
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Update a shipping address for an 
	 * existing customer profile. 
	 *
	 * @return array
	 */
	public function updateShippingAddress() {
		
        $this->_constructXml(self::UPDATE_SHIPPING_PROFILE);
		
		$this->_xml->addChild(self::PROFILE_ID,		$this->_customerProfileId);
		$address = $this->_xml->addChild(self::ADDRESS);
			//Populate address parameters
			$address->addChild(self::FIRST_NAME,	$this->_shipToFirstName);
			$address->addChild(self::LAST_NAME,		$this->_shipToLastName);
			$address->addChild(self::COMPANY,		$this->_shipToCompany);
			$address->addChild(self::ADDRESS,		$this->_shipToAddress);
			$address->addChild(self::CITY,			$this->_shipToCity);
			$address->addChild(self::STATE,			$this->_shipToState);
			$address->addChild(self::ZIP,			$this->_shipToZip);
			$address->addChild(self::COUNTRY,		$this->_shipToCountry);
			$address->addChild(self::PHONE_NUMBER,	$this->_shipToPhoneNumber);
			$address->addChild(self::FAX_NUMBER,	$this->_shipToFaxNumber);
			
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Verify an existing customer payment 
	 * profile by generating a test transaction.
	 *
	 * @return array
	 */
	public function validatePaymentProfile() {
		
        $this->_constructXml(self::VALIDATE);
		
		$this->_xml->addChild(self::PROFILE_ID,		$this->_customerProfileId);
		$this->_xml->addChild(self::PAYMENT_ID,		$this->_customerPaymentProfileId);
		$this->_xml->addChild(self::SHIPPING_ID,	$this->_customerAddressId);
		$this->_xml->addChild(self::VALIDATION,		$this->_validationMode);
		
		return $this->_process($this->_xml->asXML());
	}
		
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
