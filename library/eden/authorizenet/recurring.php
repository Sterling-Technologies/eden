<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Authorize.net - Automated Recurring Billing
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Recurring extends Eden_Authorizenet_Base {
	/* Constants
	-------------------------------*/
	const CREATE	= 'ARBCreateSubscriptionRequest';
	const UPDATE	= 'ARBUpdateSubscriptionRequest';
	const REMOVE	= 'ARBCancelSubscriptionRequest';
	
	const SUBSCRIPTION		= 'subscription';
	const NAME				= 'name';
	const PAYMENT_SCHEDULE	= 'paymentSchedule';
	const INTERVAL			= 'interval';
	const LENGTH			= 'length';
	const UNIT				= 'unit';
	const DATE				= 'startDate';
	const TOTAL				= 'totalOccurrences';
	const TRIAL				= 'trialOccurrences';
	const AMOUNT			= 'amount';
	const TRIAL_AMOUNT		= 'trialAmount';
	const PAYMENT			= 'payment';
	const BANK				= 'bankAccount';
	const ACCOUNT			= 'accountType';
	const ROUTING_NUMBER	= 'routingNumber';
	const ACCOUNT_NUMBER	= 'accountNumber';
	const ACCOUNT_NAME		= 'nameOnAccount';
	const BANK_NAME			= 'bankName';
	const CREDIT_CARD		= 'creditCard';
	const CARD_NUMBER		= 'cardNumber';
	const EXPIRATION		= 'expirationDate';
	const ORDER				= 'order';
	const INVOICE			= 'invoiceNumber';
	const DESCRIPTION		= 'description';
	const CUSTOMER			= 'customer';
	const ID				= 'id';
	const EMAIL				= 'email';
	const PHONE_NUMBER		= 'phoneNumber';
	const FAX_NUMBER		= 'faxNumber';
	const FIRST_NAME		= 'firstName';
	const LAST_NAME			= 'lastName';
	const COMPANY			= 'company';
	const ADDRESS			= 'address';
	const CITY				= 'city';
	const STATE				= 'state';
	const ZIP				= 'zip';
	const SHIPPING			= 'shipTo';
	const BILLING			= 'billTo';
	const SUBSCRIPTION_ID	= 'subscriptionId';
	const DAYS				= 'days';
	const MONTHS			= 'months';
	const YEARS				= 'years';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_echeck 				= false;
	protected $_subscrName			= NULL;
	protected $_intervalLength		= NULL;
	protected $_intervalUnit		= NULL;
	protected $_startDate			= NULL;
	protected $_totalOccurrences	= NULL;
	protected $_trialOccurrences	= NULL;
	protected $_amount				= NULL;
	protected $_trialAmount			= NULL;
	protected $_cardNumber			= NULL;
	protected $_expirationDate		= NULL;
	protected $_orderInvoiceNumber	= NULL;
	protected $_orderDescription	= NULL;
	protected $_customerId			= NULL;
	protected $_customerEmail		= NULL;
	protected $_customerPhoneNumber	= NULL;
	protected $_customerFaxNumber	= NULL;
	protected $_firstName			= NULL;
	protected $_lastName			= NULL;
	protected $_company				= NULL;
	protected $_address				= NULL;
	protected $_city				= NULL;
	protected $_state				= NULL;
	protected $_zip					= NULL;
	protected $_accountType			= NULL;
	protected $_nameOnAccount		= NULL;
	protected $_bankName			= NULL;
	protected $_routingNumber		= NULL;
	protected $_accountNumber		= NULL;
	protected $_shipFirstName		= NULL;
	protected $_shipLastName		= NULL;
	protected $_shipCompany			= NULL;
	protected $_shipAddress			= NULL;
	protected $_shipCity			= NULL;
	protected $_shipState			= NULL;
	protected $_shipZip				= NULL;
	
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
	 * Create Authomated Recurring  
	 * subscription account
	 *
	 * @return array
	 */
	public function create() {
		$this->_constructXml(self::CREATE);
		
		$subscription = $this->_xml->addChild(self::SUBSCRIPTION);
		 	$subscription->addChild(self::NAME, $this->_subscrName);
			$paymentSchedule = $subscription->addChild(self::PAYMENT_SCHEDULE);
			
				$interval = $paymentSchedule->addChild(self::INTERVAL);
					//Populate interval parameters
					$interval->addChild(self::LENGTH,			$this->_intervalLength);
					$interval->addChild(self::UNIT,				$this->_intervalUnit);
				
				$paymentSchedule->addChild(self::DATE,			$this->_startDate);
				$paymentSchedule->addChild(self::TOTAL,			$this->_totalOccurrences);
				$paymentSchedule->addChild(self::TRIAL,			$this->_trialOccurrences);
				
			$subscription->addChild(self::AMOUNT,				$this->_amount);
			$subscription->addChild(self::TRIAL_AMOUNT,			$this->_trialAmount);
			$payment = $subscription->addChild(self::PAYMENT);
			
		//if it is E check
		if ($this->_echeck)  {
			//Populate bank parameters
			$bankAccount = $payment->addChild(self::BANK);
				$bankAccount->addChild(self::ACCOUNT,			$this->_accountType);
				$bankAccount->addChild(self::ROUTING_NUMBER,	$this->_routingNumber);
				$bankAccount->addChild(self::ACCOUNT_NUMBER,	$this->_accountNumber);
				$bankAccount->addChild(self::ACCOUNT_NAME,		$this->_nameOnAccount);
				$bankAccount->addChild(self::BANK_NAME,			$this->_bankName);
		//else it is credit
		} else {
			//Populate credit parameters
			$creditCard = $payment->addChild(self::CREDIT_CARD);
				$creditCard->addChild(self::CARD_NUMBER,	$this->_cardNumber);
				$creditCard->addChild(self::EXPIRATION,		$this->_expirationDate);
		}	
		
			//Populate order parameters
			$order = $subscription->addChild();
				$order->addChild(self::ORDER,			$this->_orderInvoiceNumber);
				$order->addChild(self::DESCRIPTION,		$this->_orderDescription);
			//Populate customer parameters
			$customer = $subscription->addChild(self::CUSTOMER);
				$customer->addChild(self::ID,			$this->_customerId);
				$customer->addChild(self::EMAIL,		$this->_customerEmail);
				$customer->addChild(self::PHONE_NUMBER,	$this->_customerPhoneNumber);
				$customer->addChild(self::FAX_NUMBER,	$this->_customerFaxNumber);
			//Populate billing parameters	
			$billTo = $subscription->addChild(self::BILLING);
				$billTo->addChild(self::FIRST_NAME,		$this->_firstName);
				$billTo->addChild(self::LAST_NAME,		$this->_lastName);
				$billTo->addChild(self::COMPANY,		$this->_company);
				$billTo->addChild(self::ADDRESS,		$this->_address);
				$billTo->addChild(self::CITY,			$this->_city);
				$billTo->addChild(self::STATE,			$this->_state);
				$billTo->addChild(self::ZIP,			$this->_zip);
			//Populate shipping parameters
			$shipTo = $subscription->addChild(self::SHIPPING);
				$shipTo->addChild(self::FIRST_NAME,		$this->_shipFirstName);
				$shipTo->addChild(self::LAST_NAME,		$this->_shipLastName);
				$shipTo->addChild(self::COMPANY,		$this->_shipCompany);
				$shipTo->addChild(self::ADDRESS,		$this->_address);
				$shipTo->addChild(self::CITY,			$this->_shipCity);
				$shipTo->addChild(self::STATE,			$this->_shipState);
				$shipTo->addChild(self::ZIP,			$this->_shipZip);
	
		return $this->_process($this->_xml->asXML());
	}
	
	/**
	 * Remove Authomated Recurring  
	 * subscription account
	 *
	 * @return array
	 */
	public function remove() {
		$this->_constructXml(self::REMOVE);
		$this->_xml->addChild(self::SUBSCRIPTION_ID, $this->_subscrId);
		
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
	 * @params *integer|float
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	
	}
	
	/**
	 * Set bank name
	 *
	 * @param *string
	 * @return this
	 */
	public function setBank($bankName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_bankName = $bankName;
		return $this;
	}
	
	/**
	 * Set Billing address
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingAddress($address) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_address = $address;
		return $this;
	}
	
	/**
	 * Set Billing city
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingCity($city) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_city = $city;
		return $this;
	}
	
	/**
	 * Set Billing company
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingCompany($company) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_company = $company;
		return $this;
	}
	
	/**
	 * Set Billing first name
	 *
	 * @param *string
	 * @return this
	 */
	public function setBillingFirstName($name) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_firstName = $name;
		return $this;
	}
	
	/**
	 * Set Billing last name
	 *
	 * @param *string
	 * @return this
	 */
	public function seBillingtLastName($name) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_lastName = $name;
		return $this;
	}
	
	/**
	 * Set Billing city
	 *
	 * @param *state
	 * @return this
	 */
	public function setBillingState($state) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_state = $state;
		return $this;
	}
	
	/**
	 * Set Billing city
	 *
	 * @param *zip
	 * @return this
	 */
	public function setBillingZip($zip) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_zip = $zip;
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
	 * Set customer email
	 *
	 * @param *string
	 * @return this
	 */
	public function setCustomerEmail($email) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerEmail = $email;
		return $this;
	}
	
	/**
	 * Set customer fax number
	 *
	 * @param *string
	 * @return this
	 */
	public function setCustomerFax($fax) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerFaxNumber = $fax;
		return $this;
	}
	
	/**
	 * Set customer id
	 *
	 * @param *string
	 * @return this
	 */
	public function setCustomerId($id) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerId = $id;
		return $this;
	}
	
	/**
	 * Set customer phone number
	 *
	 * @param *string
	 * @return this
	 */
	public function setCustomerPhone($phone) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_customerPhoneNumber = $phone;
		return $this;
	}
	
	/**
	 * Set start date 
	 *
	 * @params *string
	 * @return this
	 */
	public function setDate($date) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_startDate = date("Y-m-d",strtotime($date));
		return $this;
	}
	
	/**
	 * Set echeck 
	 *
	 * @return this
	 */
	public function setECheck() {
		$this->_echeck = true;
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
	 * The measurement of time, in association with the Interval 
	 * Unit, that is used to define the frequency of the
	 * billing occurrences. If the Interval Unit is "months," 
	 * can be any number between one (1) and 12.
	 * If the Interval Unit is "days," can be any 
	 * number between seven (7) and 365.
	 *
	 * @params *integer
	 * @return this
	 */
	public function setIntervalLength($length) {
		//Argument 1 must be a integer
		Eden_Authorizenet_Error::i()->argument(1, 'int');	
		
		$this->_intervalLength = $length;
		return $this;
	}
	
	/**
	 * Set name on account
	 *
	 * @param *string
	 * @return this
	 */
	public function setNameOnAccount($nameOnAccount) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_nameOnAccount = $nameOnAccount;
		return $this;
	}
	
	/**
	 * Set order invoice number
	 *
	 * @param *string
	 * @return this
	 */
	public function setOrderDescription($description) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_orderDescription = $description;
		return $this;
	}
	
	/**
	 * Set order invoice number
	 *
	 * @param *integer
	 * @return this
	 */
	public function setOrderInvoiceNumber($order) {
		//Argument 1 must be an integer
		Eden_Authorizenet_Error::i()->argument(1, 'int');	
		
		$this->_orderInvoiceNumber = $order;
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
	 * Set shipping address
	 *
	 * @param *string
	 * @return this
	 */
	public function setShippingAddress($address) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_shipAddress = $address;
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
		
		$this->_shipCity = $city;
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
		
		$this->_shipCompany = $company;
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
		
		$this->_shipFirstName = $firstName;
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
		
		$this->_shipLastName = $lastName;
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
		
		$this->_shipState = $state;
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
		
		$this->_shipZip = $zip;
		return $this;
	}
	
	/**
	 * Set subscription id
	 *
	 * @param *string
	 * @return this
	 */
	public function setSubscriptionId($id) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_subscrId = $id;
		return $this;
	}
	
	/**
	 * Set subscription name 
	 *
	 * @params *string
	 * @return this
	 */
	public function setSubscriptionName($name) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_subscrName = $name;
		return $this;
	}
	
	/**
	 * Set interval unit to days 
	 *
	 * @return this
	 */
	public function setToDays() {
		$this->_intervalUnit = self::DAYS;
		return $this;
	}
	
	/**
	 * Set interval unit to months 
	 *
	 * @return this
	 */
	public function setToMonths() {
		$this->_intervalUnit = self::MONTHS;
		return $this;
	}
	
	/**
	 * Number of billing occurrences or payments for the 
	 * subscription. To submit a subscription with no end 
	 * date (an ongoing subscription), this field  must be 
	 * submitted with a value of “9999.”  If a trial period 
	 * is specified, this number should include the Trial
	 * Occurrences.
	 *
	 * @params *integer
	 * @return this
	 */
	public function setTotalOccurrences($total) {
		//Argument 1 must be an integer
		Eden_Authorizenet_Error::i()->argument(1, 'int');	
		
		$this->_totalOccurrences = $total;
		return $this;
	}
	
	/**
	 * Set interval unit to years 
	 *
	 * @return this
	 */
	public function setToYears() {
		$this->_intervalUnit = self::YEARS;
		return $this;
	}
	
	/**
	 * Number of billing occurrences or payments in the trial
	 * period. If a trial period is specified, this number must 
	 * be included in the Total Occurrences.
	 *
	 * @params *integer
	 * @return this
	 */
	public function setTrialOccurrences($trial) {
		//Argument 1 must be an integer
		Eden_Authorizenet_Error::i()->argument(1, 'int');	
		
		$this->_trialOccurrences = $trial;
		return $this;
	}
	
	/**
	 * Set trial amount
	 *
	 * @params *integer|float
	 * @return this
	 */
	public function setTrialAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'int', 'float');	
		
		$this->_trialAmount = $amount;
		return $this;
	
	}
	
	/**
	 * Update Authomated Recurring  
	 * subscription account
	 *
	 * @return array
	 */
	public function update() {
		$this->_constructXml(self::UPDATE);
		
		$this->_xml->addChild(self::SUBSCRIPTION_ID,		$this->_subscrId);
		$subscription = $this->_xml->addChild(self::SUBSCRIPTION);
			$subscription->addChild(self::NAME,				$this->_subscrName);
			$subscription->addChild(self::AMOUNT,			$this->_amount);
			$subscription->addChild(self::TRIAL_NAME,		$this->_trialAmount);
			
			$payment = $subscription->addChild(self::PAYMENT);
				//Populate credit parameters
				$creditCard = $payment->addChild(self::CREDIT_CARD);
					$creditCard->addChild(self::CARD_NUMBER,$this->_cardNumber);
					$creditCard->addChild(self::EXPIRATION,	$this->_expirationDate);
				//Populate billing parameters
				$billTo = $subscription->addChild(self::BILLING);
					$billTo->addChild(self::FIRST_NAME,	$this->_firstName);
					$billTo->addChild(self::LAST_NAME,		$this->_lastName);
					$billTo->addChild(self::COMPANY,		$this->_company);
					$billTo->addChild(self::ADDRESS,		$this->_address);
					$billTo->addChild(self::CITY,			$this->_city);
					$billTo->addChild(self::STATE,			$this->_state);
					$billTo->addChild(self::ZIP,			$this->_zip);
				
		return $this->_process($this->_xml->asXML());
	}
	
	/* Protected Methods
	-------------------------------*/	
	/* Private Methods
	-------------------------------*/
}
