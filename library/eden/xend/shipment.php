<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Xend Express - Shipment Service
 *
 * @package    Eden
 * @category   Xend
 * @author     Christian Symon M. Buenavista <sbuenavista@openovate.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Xend_Shipment extends Eden_Xend_Base {
	/* Constants
	-------------------------------*/
	const SHIPMENT		= 'shipment';
	const SERVICE_TYPE	= 'ServiceTypeValue';		
	const SHIPMENT_TYPE	= 'ShipmentTypeValue' ;
	const PURPOSE		= 'PurposeOfExportValue';
	const NAME			= 'RecipientName';
	const COMPANY		= 'RecipientCompanyName';
	const ADDRESS1		= 'RecipientAddress1';		
	const ADDRESS2		= 'RecipientAddress2';		
	const CITY			= 'RecipientCity';		
	const PROVINCE		= 'RecipientProvince';		
	const COUNTRY		= 'RecipientCountry';		
	const INSURED		= 'IsInsured';				
	const INSTRUCTION	= 'SpecialInstructions';	
	const DESCRIPTION	= 'Description';			
	const CLIENT		= 'ClientReference';
	const DATE_CREATED	= 'DateCreated';
	const DATE_PRINTED	= 'DatePrinted';
	const POSTAL_CODE	= 'RecipientPostalCode';
	const PHONE_NUMBER	= 'RecipientPhoneNo';
	const EMAIL			= 'RecipientEmailAddress';
	const MANUFACTURED	= 'CountryManufactured';
	const SHIPPING_FEE	= 'ShippingFee';
	const INSURANCE_FEE	= 'InsuranceFee';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_test			= true;
	protected $_exceptionFlag	= false;
	protected $_url				= self::SHIPMENT_WSDL;
	protected $_header			= self::HEADER;
	
	protected $_wayBillNo			= NULL;
	protected $_serviceType			= NULL;
	protected $_shipmentType		= NULL;
	protected $_purpose				= NULL;
	protected $_weight				= NULL;
	protected $_length				= NULL;
	protected $_width				= NULL;
	protected $_height				= NULL;
	protected $_declaredValue		= NULL;
	protected $_name				= NULL;
	protected $_address1			= NULL;
	protected $_address2			= NULL;
	protected $_city				= NULL;
	protected $_provice				= NULL;
	protected $_country				= NULL;
	protected $_specialInstruction	= NULL;
	protected $_description			= NULL;
	protected $_company				= NULL;
	protected $_shippingFee			= NULL;
	protected $_postalCode			= NULL;
	protected $_phoneNumber			= NULL;
	protected $_email				= NULL;
	protected $_wayBill				= NULL;
	protected $_fee					= 0;
	
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
	 * Retrieves the information of a shipment given a waybill number
	 *
	 * return array
	 */
	public function getDetail() {
		$exceptionFlag = false;
		
		// initialize SOAP client
		$client	= new SoapClient($this->_url, array());
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::USER_TOKEN => $this->_userToken);
		$header = new SoapHeader($this->_header, self::AUTH_HEADER, $headerbody);
		$client->__setSoapHeaders($header);
		
		// execute SOAP method
		try {
			$result = $client->Get(array(self::WAY_BILL_NO => $this->_wayBill));
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error[0][1];
		}
			
		return $result->GetResult;
	}
	
	/**
	 * Creates a new shipment and returns the waybill number
	 *
	 * return array
	 */
	public function getResponse() {
		// initialize SOAP client
		$client = new SoapClient($this->_url, array());
		$funcs = $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody = array(self::USER_TOKEN => $this->_userToken);
		$header = new SoapHeader($this->_header, self::AUTH_HEADER, $headerbody);
		
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(		   
			self::SERVICE_TYPE	=> $this->_serviceType,
			self::SHIPMENT_TYPE	=> $this->_shipmentType,
			self::PURPOSE		=> $this->_purpose,
			self::WEIGHT		=> $this->_weight,
			self::LENGTH		=> $this->_length,
			self::WIDTH			=> $this->_width,
			self::HEIGHT		=> $this->_height,
			self::VALUE			=> $this->_declaredValue,
			self::NAME			=> $this->_name,
			self::COMPANY		=> $this->_company,
			self::ADDRESS1		=> $this->_address1,
			self::ADDRESS2		=> $this->_address2,
			self::CITY			=> $this->_city,
			self::PROVINCE		=> $this->_provice,
			self::COUNTRY		=> $this->_country,
			self::INSURED		=> TRUE,
			self::INSTRUCTION	=> $this->_specialInstruction,
			self::DESCRIPTION	=> $this->_description,
			self::CLIENT		=> '',
			self::MANUFACTURED	=> '',
			self::POSTAL_CODE 	=> $this->_postalCode,
			self::PHONE_NUMBER	=> $this->_phoneNumber,
			self::EMAIL			=> $this->_email,
			self::DATE_CREATED	=> time(),
			self::DATE_PRINTED	=> time(),
			self::SHIPPING_FEE	=> $this->_fee,
			self::INSURANCE_FEE	=> '1');
		
		// execute SOAP method
		try {
			
			//create a Shipment method
			$result = $client->Create(array(self::SHIPMENT => $query));
			
		} catch(SoapFault $soapfault) {
			
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error[0][1];
		}	
		//fetch way bill number
		$this->_wayBill = $result->CreateResult;
		
		return $this->getDetail();
	}
	
	/**
	 * Set recipient address1
	 *
	 * @param *string
	 * @return this
	 */
	public function setAddress1($address1) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_address1 = $address1;
		return $this;
	}
	
	/**
	 * Set recipient address2
	 *
	 * @param *string
	 * @return this
	 */
	public function setAddress2($address2) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_address1 = $address2;
		return $this;
	}
	
	/**
	 * Set recipient city
	 *
	 * @param *string
	 * @return this
	 */
	public function setCity($city) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_city = $city;
		return $this;
	}
	
	/**
	 * Set company
	 *
	 * @param *string
	 * @return this
	 */
	public function setCompany($company) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		$this->_company = $company;
		return $this;
	}
	
	/**
	 * Set recipient country
	 *
	 * @param *string
	 * @return this
	 */
	public function setCountry($country) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_country = $country;
		return $this;
	}
	
	/**
	 * Set item declared value
	 *
	 * @param *integer|float
	 * @return this
	 */
	public function setDeclaredValue($declaredValue) {
		//Argument 1 must be an integer or float
		Eden_Xend_Error::i()->argument(1, 'int', 'float');	
		
		$this->_declaredValue = $declaredValue;
		return $this;
	}
	
	/**
	 * Set item description
	 *
	 * @param *string
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_description = $description;
		return $this;
	}
	
	/**
	 * Set shipment type to document
	 *
	 * @return this
	 */
	public function setDocument() {
		$this->_shipmentType = self::DOCUMENT;
		return $this;
	}
	
	/**
	 * Set email
	 *
	 * @param *string
	 * @return this
	 */
	public function setEmail($email) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_email	= $email;
		return $this;
	}
	
	/**
	 * Set item height
	 *
	 * @param *integer|float In centimeter
	 * @return this
	 */
	public function setHeight($height) {
		//Argument 1 must be an integer or float
		Eden_Xend_Error::i()->argument(1, 'int', 'float');	
		
		$this->_height = $height;
		return $this;
	}
	
	/**
	 * Set service type to international EMS
	 *
	 * @return this
	 */
	public function setInternationalEMS() {
		$this->_serviceType = self::INTERNATIONAL_EMS;
		return $this;
	}
	
	/**
	 * Set service type to international Express
	 *
	 * @return this
	 */
	public function setInternationalExpress() {
		$this->_serviceType = self::INTERNATIONAL_EXPRESS;
		return $this;
	}
	
	/**
	 * Set service type to international postal
	 *
	 * @return this
	 */
	public function setInternationalPostal() {
		$this->_serviceType = self::INTERNATIONAL_POSTAL;
		return $this;
	}
	
	/**
	 * Set item length
	 *
	 * @param *integer|float In centimeter
	 * @return this
	 */
	public function setLength($length) {
		//Argument 1 must be an integer or float
		Eden_Xend_Error::i()->argument(1, 'int', 'float');	
		
		$this->_length = $length;
		return $this;
	}
	
	/**
	 * Set service type to metro manila express
	 *
	 * @return this
	 */
	public function setMetroManilaExpress() {
		$this->_serviceType = self::METRO_MANILA_EXPRESS;
		return $this;
	}
	
	/**
	 * Set recipient name
	 *
	 * @param *string
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * Set shipment type to parcel
	 *
	 * @return this
	 */
	public function setParcel() {
		$this->_shipmentType = self::PARCEL;
		return $this;
	}
	
	/**
	 * Set phone number
	 *
	 * @param *string
	 * @return this
	 */
	public function setPhoneNumber($phoneNumber) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_phoneNumber	= $phoneNumber;
		return $this;
	}
	
	/**
	 * Set postal code
	 *
	 * @param *string
	 * @return this
	 */
	public function setPostalCode($postalCode) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_postalCode	= $postalCode;
		return $this;
	}
	
	/**
	 * Set recipient provice
	 *
	 * @param *string
	 * @return this
	 */
	public function setProvince($province) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->province = $province;
		return $this;
	}
	
	/**
	 * Set service type to provincial express
	 *
	 * @return this
	 */
	public function setProvincialExpress() {
		$this->_serviceType = self::PROVINCIAL_EXPRESS;
		return $this;
	}
	
	/**
	 * Set purpose of export
	 *
	 * @param *string
	 * @return this
	 */
	public function setPurpose($purpose) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		$this->_purpose = $purpose;
		return $this;
	}
	
	/**
	 * Set service type to rizal metro manila express
	 *
	 * @return this
	 */
	public function setRizalMetroManilaExpress() {
		$this->_serviceType = self::RIZAL_METRO_MANILA_EXPRESS;
		return $this;
	}
	
	/**
	 * Set shipping feee
	 *
	 * @param *integer|float
	 * @return this
	 */
	public function setShippingFee($fee) {
		//Argument 1 must be an integer or float
		Eden_Xend_Error::i()->argument(1, 'int','float');	
		
		$this->_fee = $fee;
		return $this;
	}
	
	/**
	 * Set item special instruction
	 *
	 * @param *string
	 * @return this
	 */
	public function setSpecialInstruction($specialInstruction) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_specialInstruction = $specialInstruction;
		return $this;
	}
	
	/**
	 * Set way bill number
	 *
	 * @param *string
	 * @return this
	 */
	public function setWayBillNumber($wayBillNo) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_wayBillNo = $wayBillNo;
		return $this;
	}
	
	/**
	 * Set item weight
	 *
	 * @param *integer|float In kilogram
	 * @return this
	 */
	public function setWeight($weight) {
		//Argument 1 must be an integer or float
		Eden_Xend_Error::i()->argument(1, 'int', 'float');	
		
		$this->_weight = $weight;
		return $this;
	}
	
	/**
	 * Set item width
	 *
	 * @param *integer|float In centimeter
	 * @return this
	 */
	public function setWidth($width) {
		//Argument 1 must be an integer or float
		Eden_Xend_Error::i()->argument(1, 'int', 'float');	
		
		$this->_width = $width;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}