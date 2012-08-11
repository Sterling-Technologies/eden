<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */


/**
 * Xend Express - Rate Service
 *
 * @package    Eden
 * @category   xend
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Xend_Rate extends Eden_Xend_Base{
	/* Constants
	-------------------------------*/
	const SERVICE_TYPE	= 'ServiceTypeValue';		
	const SHIPMENT_TYPE	= 'ShipmentTypeValue';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_exceptionFlag		= false;
	protected $_serviceType			= NULL;
	protected $_shipmentType		= NULL;
	protected $_weight				= NULL;
	protected $_lenght				= NULL;
	protected $_width				= NULL;
	protected $_height				= NULL;
	protected $_declaredValue		= NULL;
	protected $_destinationValue	= NULL;
	
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
	 * Retrieves the calculated rate based on the shipment information.
	 *
	 * @return integer|float
	 */
	public function getResponse() {
		// initialize SOAP client
		$client	= new SoapClient(self::RATE_WSDL);
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::USER_TOKEN => $this->_userToken);
		$header		= new SoapHeader(self::HEADER, self::AUTH_HEADER, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			self::SERVICE_TYPE		=> $this->_serviceType,
			self::SHIPMENT_TYPE		=> $this->_shipmentType,
			self::DESTINATION_VALUE	=> $this->_destinationValue,	//Destination of item
			self::WEIGHT			=> $this->_weight,				//Weight of item in kilogram
			self::LENGTH			=> $this->_length,				//Length of item in centimeter
			self::WIDTH				=> $this->_width,				//Width of item in centimeter
			self::HEIGHT			=> $this->_height,				//Height of item in centimeter
			self::VALUE				=> $this->_declaredValue,		//Declared value of item in peso
			self::INSURANCE			=> true);
		
		// execute SOAP method
		try {
			$result = $client->Calculate($query);
		//catch soap fault	
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error[0][1];	
		}
		
		return $result->CalculateResult;
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
	 * Set item destination
	 *
	 * @param *string
	 * @return this
	 */
	public function setDestinationValue($destinationValue) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_destinationValue = $destinationValue;
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
	public function setInternationalEms() {
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
	public function setLenght($length) {
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
	 * Set shipment type to parcel
	 *
	 * @return this
	 */
	public function setParcel() {
		$this->_shipmentType = self::PARCEL;
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
	 * Set service type to rizal metro manila express
	 *
	 * @return this
	 */
	public function setRizalMetroManilaExpress() {
		$this->_serviceType = self::RIZAL_METRO_MANILA_EXPRESS;
		return $this;
	}
	
	/* Set item weight
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