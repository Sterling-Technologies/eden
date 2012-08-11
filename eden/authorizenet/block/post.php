<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Confirm Block
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Block_Post extends Eden_Block {
	/* Constants
	-------------------------------*/
	const CARD_NUMBER	= 'Credit Card Number';
	const EXPIRATION	= 'Expiration Date';
	const CVV			= 'CVV';
	const FIRST_NAME	= 'First Name';
	const LAST_NAME		= 'Last Name';
	const ADDRESS		= 'Address';
	const CITY			= 'City';
	const STATE			= 'State';
	const ZIP			= 'Zip Code';
	const COUNTRY		= 'Country';
	const SUBMIT		= 'Submit';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_url 			= NULL;
	protected $_fields 			= array();
	protected $_cardNumber		= NULL;
	protected $_expiration		= NULL;
	protected $_cvv				= NULL;
	protected $_firstName		= NULL;
	protected $_lastName		= NULL;
	protected $_address			= NULL;
	protected $_city			= NULL;
	protected $_state			= NULL;
	protected $_zip				= NULL;
	protected $_country			= NULL;
	protected $_cardNumberLabel	= self::CARD_NUMBER,
	protected $_expirationLabel	= self::EXPIRATION,
	protected $_cvvLabel		= self::CVV,
	protected $_firstNameLabel	= self::FIRST_NAME,
	protected $_lastNameLabel	= self::LAST_NAME,
	protected $_addressLabel	= self::ADDRESS,
	protected $_cityLabel		= self::CITY,
	protected $_stateLabel		= self::STATE,
	protected $_zipLabel		= self::ZIP,
	protected $_countryLabel	= self::COUNTRY,
	protected $_submitButton	= self::SUBMIT,
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($url, array $fields) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');			
			
		$this->_url		= $url;
		$this->_fields	= $fields;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Set customer address 
	 *
	 * @param *string
	 * @return this
	 */
	public function setAddress($address) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_address = $address;
		return $this;
	}
	
	/**
	 * Set address label
	 *
	 * @param *string
	 * @return this
	 */
	public function setAddressLabel($addressLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_addressLabel = $addressLabel;
		return $this;
	}
	
	/**
	 * Set customer card number
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
	 * Set card number label
	 *
	 * @param *string
	 * @return this
	 */
	public function setCardNumberLabel($cardNumberLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_cardNumberLabel = $cardNumberLabel;
		return $this;
	}
	
	/**
	 * Set customer city
	 *
	 * @param *string
	 * @return this
	 */
	public function setCity($city) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_city = $city;
		return $this;
	}
	
	/**
	 * Set city label
	 *
	 * @param *string
	 * @return this
	 */
	public function setCityLabel($cityLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_cityLabel = $cityLabel;
		return $this;
	}
	
	/**
	 * Set customer country  
	 *
	 * @param *string
	 * @return this
	 */
	public function setCountry($country) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_country = $country;
		return $this;
	}
	
	/**
	 * Set country label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setCountryLabel($countryLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->__countryLabel = $countryLabel;
		return $this;
	}
	
	/**
	 * Set customer cvv
	 *
	 * @param *string
	 * @return this
	 */
	public function setCvv($cvv) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_cvvr = $cvv;
		return $this;
	}
	
	/**
	 * Set cvv label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setCvvLabel($cvvLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_cvvLabel = $cvvLabel;
		return $this;
	}
	
	/**
	 * Set customer exipiration date 
	 *
	 * @param *string
	 * @return this
	 */
	public function setExpiration($date) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_date = $date;
		return $this;
	}
	
	/**
	 * Set expiration date label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setExpirationLabel($expirationLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_expirationLabel = $expirationLabel;
		return $this;
	}
	
	/**
	 * Set customer first name 
	 *
	 * @param *string
	 * @return this
	 */
	public function setFirstName($firstName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_firstName = $firstName;
		return $this;
	}
	
	/**
	 * Set first name label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setFirstNameLabel($firstNameLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_firstNameLabel = $firstNameLabel;
		return $this;
	}
	
	/**
	 * Set customer last name
	 *
	 * @param *string
	 * @return this
	 */
	public function setLastName($lastName) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_lastName = $lastName;
		return $this;
	}
	
	/**
	 * Set last name label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setLastNameLabel($lastNameLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_lastNameLabel = $lastNameLabel;
		return $this;
	}
	
	/**
	 * Set customer state 
	 *
	 * @param *string
	 * @return this
	 */
	public function setState($state) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_state = $state;
		return $this;
	}
	
	/**
	 * Set state label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setStateLabel($stateLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_stateLabel = $stateLabel;
		return $this;
	}
	
	/**
	 * Set submit button value
	 *
	 * @param *string
	 * @return this
	 */
	public function setSubmitButton($submitButton) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_submitButton = $submitButton;
		return $this;
	}
	
	/**
	 * Returns a template file
	 * 
	 * @return string
	 */
	public function getTemplate() {
		return realpath(dirname(__FILE__).'/template/post.php');
	}
	
	/**
	 * Returns the template variables in key value format
	 *
	 * @param array data
	 * @return array
	 */
	public function getVariables() {
		$fields = array(
			'x_relay_response'	=> 'FALSE',
			'x_version'			=> Eden_Authorizenet_Base::VERSION,
			'x_delim_char'		=> ',',
			'x_delim_data'		=> 'TRUE');
		 
		foreach($this->_fields as $key => $value) {
			if (!trim($value)) {
				continue;
			}
			$fields[$key] = $value;	
		}

		return array(
			'url' 				=> $this->_url,
			'fields' 			=> $fields,
			'cardNumberLabel'	=> $this->_cardNumberLabel,
			'expirationLabel'	=> $this->_expirationLabel,
			'cvvLabel'			=> $this->_cvvLabel,
			'firstNameLabel'	=> $this->_firstNameLabel,
			'lastNameLabel'		=> $this->_lastNameLabel,
			'addressLabel'		=> $this->_addressLabel,
			'cityLabel'			=> $this->_cityLabel,
			'stateLabel'		=> $this->_stateLabel,
			'zipLabel'			=> $this->_zipLabel,
			'countryLabel'		=> $this->_countryLabel,
			'submitButton'		=> $this->_submitButton,
			'cardNumber'		=> $this->_cardNumber,
			'expiration'		=> $this->_expiration,
			'cvv'				=> $this->_cvv,
			'firstName'			=> $this->_firstName,
			'lastName'			=> $this->_lastName,
			'address'			=> $this->_address,
			'city'				=> $this->_city,
			'state'				=> $this->_state,
			'zip'				=> $this->_zip,
			'country'			=> $this->_country);
	}
	
	/**
	 * Set customer zip
	 *
	 * @param *string
	 * @return this
	 */
	public function setZip($zip) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_zip = $zip;
		return $this;
	}
	
	/**
	 * Set zip label 
	 *
	 * @param *string
	 * @return this
	 */
	public function setZipLabel($zipLabel) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_zipLabel = $zipLabel;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}