<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Authorize.net Server Integration Method 
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Payment extends Eden_Authorizenet_Base {
	/* Constants
	-------------------------------*/
	const AUTH_CAPTURE			= 'AUTH_CAPTURE';
	const PRIOR_AUTH_CAPTURE	= 'PRIOR_AUTH_CAPTURE';
	const AUTH_ONLY				= 'AUTH_ONLY';
	const VOID					= 'VOID';
	const CAPTURE_ONLY			= 'CAPTURE_ONLY';
	const CREDIT				= 'CREDIT';
	const VERSION_NOW			= '3.1';
	const CC					= 'CC';
	
	const TRANSACTION_ID	= 'x_trans_id';
	const LOGIN				= 'x_login';			
	const TRANS_KEY			= 'x_tran_key';	
	const VERSION			= 'x_version';		
	const DATA				= 'x_delim_data';		
	const CHAR				= 'x_delim_char';		
	const RELAY				= 'x_relay_response';	
	const TYPE				= 'x_type';			
	const METHOD			= 'x_method';		
	const CARD_NUM			= 'x_card_num';	
	const EXP_DATE			= 'x_exp_date';	
	const AMOUNT			= 'x_amount';		
	const DESCRIPTION		= 'x_description';		
	const FIRST_NAME		= 'x_first_name';		
	const LAST_NAME			= 'x_last_name';		
	const ADDRESS			= 'x_address';			
	const STATE				= 'x_state';	
	const ZIP				= 'x_zip';	
	const EMAIL				= 'x_emai';
	const EMAIL_CUSTOMER	= 'x_email_customer';
	const MERCHANT_EMAIL	= 'x_merchant_email';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_type			= self::AUTH_CAPTURE;
	protected $_emailCustomer	= true;
	protected $_amount			= NULL;
	protected $_cardNumber		= NULL;
	protected $_expiration		= NULL;
	protected $_description		= NULL;
	protected $_address			= NULL;
	protected $_firstName		= NULL;
	protected $_lastName		= NULL;
	protected $_state			= NULL;
	protected $_zip				= NULL;
	protected $_transactionId	= NULL;
	protected $_code			= NULL;
	protected $_email			= NULL;
	protected $_merchantEmail	= NULL;

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
     * Do Transactions
     *
     * @return array
     */
	public function getResponse() {
		//populate Fields
		$default = array(
			self::LOGIN				=> $this->_apiLogin,			//API login id
			self::TRANS_KEY			=> $this->_transactionKey,		//Transaction key
			self::VERSION			=> self::VERSION_NOW,			//API version
			self::DATA				=> true,
			self::CHAR				=> '|',
			self::RELAY				=> false,						//Relay response
			self::TYPE				=> $this->_type,				//The method type
			self::METHOD			=> self::CC,
			self::EMAIL				=> $this->_email,				//Cardholder email
			self::EMAIL_CUSTOMER	=> $this->_emailCustomer,		
			self::MERCHANT_EMAIL	=> $this->_merchantEmail);		//Merchant email
			
		//if it is set to prior auth capture transaction
		switch($this->_type) {
			case self::PRIOR_AUTH_CAPTURE: 
				$type = array(
					self::TRANSACTION_ID	=> $this->_transactionId,	//Transaction id
					self::AMOUNT			=> $this->_amount);			//Item Amount
				break;
				
			case self::VOID:
				$type = array(self::TRANSACTION_ID	=> $this->_transactionId);
				break;
				
			case self::CREDIT:
				$type = array(
					self::TRANSACTION_ID	=> $this->_transactionId,	//Transaction id
					self::AMOUNT			=> $this->_amount,			//Item Amount	
					self::CARD_NUM			=> $this->_cardNumber);		//Cardholder card number
				break;
				
			default:
				$type = array(
					self::CARD_NUM		=> $this->_cardNumber,			//Cardholder card number
					self::EXP_DATE		=> $this->_expiration,			//Card expiration date
					self::AMOUNT		=> $this->_amount,				//Item Amount
					self::DESCRIPTION	=> $this->_description,			//Item description
					self::FIRST_NAME	=> $this->_firstName,			//Cardholder first name
					self::LAST_NAME		=> $this->_lastName,			//Cardholder last name
					self::ADDRESS		=> $this->_address,				//Cardholder Address
					self::STATE			=> $this->_state,				//Cardholder state
					self::ZIP			=> $this->_zip);				//Cardholder zip
				break;
		}
		
		//Merge the array
		$query = array_merge($default, $type);
		//Generate URL-encoded query string
		$query = http_build_query($query);
		//call curl method
		$response = $this->_sendRequest($query);
		//explode the response
		return explode('|', $response);
	}
	
	/**
     * Set cardholder address 
     *
	 * @param *string address	
     * @return this
     */
	public function setAddress($address) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_address = $address;
		return $this;
	}
	
	/**
     * Set transaction amount 
     *
	 * @param *integer|float Transaction amount
     * @return this
     */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
     * Set authentication code 
     *
	 * @param *string Authentication code
     * @return this
     */
	public function setAuthentication($code) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_code = $code;
		return $this;
	}
	
	/**
     * Set cardholder card number 
     *
	 * @param *string Card number
     * @return this
     */
	public function setCardNumber($cardNumber) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_cardNumber = $cardNumber;
		return $this;
	}
	
	/**
     * Set item Description 
     *
	 * @param *string item description
     * @return this
     */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		
		$this->_description = $description;
		return $this;
	}
	
	/**
     * Set customer email address
     *
	 * @param *string customer email address
     * @return this
     */
	public function setEmail($email) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		
		$this->_email = $email;
		return $this;
	}
	
	/**
     * Set cardholder card expiration date 
     *
	 * @param *string Card expirartion date
     * @return this
     */
	public function setExpiration($expiration) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_expiration = $expiration;
		return $this;
	}
	
	/**
     * Set cardholder first name
     *
	 * @param *string First name	
     * @return this
     */
	public function setFirstName($firstName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_firstName = $firstName;
		return $this;
	}
	
	/**
     * Set cardholder last name
     *
	 * @param *string Last name	
     * @return this
     */
	public function setLastName($lastName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_lastName = $lastName;
		return $this;
	}
	
	/**
     * Set merchant email address
     *
	 * @param *string merchant email address
     * @return this
     */
	public function setMerchantEmail($email) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');
		
		$this->_merchantEmail = $email;
		return $this;
	}
	
	/**
     * Do not email receipt to customer
     *
     * @return this
     */
	public function setReceiptOff() {
		$this->_emailCustomer = false;
		return $this;
	}
	
	/**
     * Set cardholder state
     *
	 * @param *string state	
     * @return this
     */
	public function setState($state) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_state = $state;
		return $this;
	}
	
	/**
     * Set authorize only transaction
     *
     * @return this
     */
	public function setToAuthorizeOnly() {
		$this->_type = self::AUTH_ONLY;
		return $this;
	}
	
	/**
     * Set capture only transaction
     *
     * @return this
     */
	public function setToCaptureOnly() {
		$this->_type = self::CAPTURE_ONLY;
		return $this;
	}
	
	/**
     * Set credit transaction
     *
     * @return this
     */
	public function setToCredit() {
		$this->_type = self::CREDIT;
		return $this;
	}
	
	/**
     * Set prior and capture only transaction
     *
     * @return this
     */
	public function setToPrior() {
		$this->_type = self::PRIOR_AUTH_CAPTURE;
		return $this;
	}
	
	/**
     * Set void transaction
     *
     * @return this
     */
	public function setToVoid() {
		$this->_type = self::VOID;
		return $this;
	}
	
	/**
     * Set transaction id 
     *
	 * @param *string Valid transaction id
     * @return this
     */
	public function setTrasactionId($id) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_transactionId = $id;
		return $this;
	}
	
	/**
     * Set cardholder zip
     *
	 * @param *string zip code	
     * @return this
     */
	public function setZip($zip) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_zip = $zip;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}