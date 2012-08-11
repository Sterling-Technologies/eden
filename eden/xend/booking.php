<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Xend Express - Booking Service
 *
 * @package    Eden
 * @category   xend
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Xend_Booking extends Eden_Xend_Base{
	/* Constants
	-------------------------------*/
	const FIRST_NAME	= 'FirstName';
	const LAST_NAME		= 'LastName';
	const STREET1		= 'Street1';
	const STREET2		= 'Street2';
	const CITY			= 'City';
	const PROVINCE		= 'Province';
	const POSTAL_CODE	= 'PostalCode';
	const LANDMARK		= 'Landmark';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_url				= self::BOOKING_WSDL;
	protected $_header			= self::HEADER;
	protected $_exceptionFlag	= false;
	protected $_date			= NULL;
	protected $_addressRefNo	= NULL;
	protected $_remarks			= NULL;
	protected $_firstName		= NULL;
	protected $_lastName		= NULL;
	protected $_street1			= NULL;
	protected $_street2			= NULL;
	protected $_city			= NULL;
	protected $_province		= NULL;
	protected $_postalCode		= NULL;
	protected $_landmark		= NULL;
	
	
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
	 * Retrieves the list of addresses in the account.
	 *
	 * return array
	 */
	public function getDetail() {
		//if it is in test mode
		if($this->_test) {	
			$this->_url		= self::TEST_BOOKING_WSDL;
			$this->_header	= self::TEST_HEADER;
		} 
		
		//initialize SOAP client
		$client	= new SoapClient($this->_url, array());
		$funcs	= $client->__getFunctions();
		
		//initialize SOAP header
		$headerbody	= array(self::USER_TOKEN => $this->_userToken);
		$header		= new SoapHeader($this->_header, self::AUTH_HEADER, $headerbody);
		$client->__setSoapHeaders($header);
		
		//execute SOAP method
		try {
			$result = $client->GetAddress();
		//catch soap fault
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error[0][1];
		}

		return $result->GetAddressResult->Address;
	}
	
	/**
	 * Creates a booking for pickup.
	 *
	 * return array
	 */
	public function getResponse() {
		// initialize SOAP client
		$client= new SoapClient($this->_url, array());
		$funcs = $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody = array(self::USER_TOKEN => $this->_userToken);
		$header		= new SoapHeader($this->_header, self::AUTH_HEADER, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$param = array(
			self::BOOKING_DATE		=> $this->_date,
			self::REFERENCE_NUMBER	=> $this->_addressRefNo,
			self::REMARKS			=> $this->_remarks);
		
		// execute SOAP method
		try
		{
			$result = $client->Schedule($param);
		}
		catch (SoapFault $soapfault)
		{
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//print error
			return $error[0][1];
		}
		
		return $result;
	}
	
	/**
	 * Creates a booking for pickup with specific 
	 * pickup address.
	 *
	 * return array
	 */
	public function getSpecific() {
		// initialize SOAP client
		$client= new SoapClient($this->_url, array());
		$funcs = $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody = array(self::USER_TOKEN => $this->_userToken);
		$header		= new SoapHeader($this->_header, self::AUTH_HEADER, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$param = array(
			self::BOOKING_DATE		=> $this->_date,
			self::REMARKS			=> $this->_remarks,
			self::FIRST_NAME		=> $this->_firstName,	//shippers first name
			self::LAST_NAME			=> $this->_lastName,	//shippers last name
			self::STREET1			=> $this->_street1,		//shippers street 1
			self::STREET2			=> $this->_street2,		//shippers street 2
			self::CITY				=> $this->_city,		//shippers city
			self::PROVINCE			=> $this->_province,	//shippers province
			self::POSTAL_CODE		=> $this->_postalCode,	//shippers postal code
			self::LANDMARK			=> $this->_landmark);	//shippers landmark
		
		// execute SOAP method
		try
		{
			$result = $client->ScheduleDev($param);
		}
		catch (SoapFault $soapfault)
		{
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//print error
			return $error[0][1];
		}
		
		return $result;
	}
	
	/**
	 * Set address reference number
	 *
	 * @param *integer	
	 * @return this
	 */
	public function setAddressNumber($addressNumber) {
		//Argument 1 must be an integer
		Eden_Xend_Error::i()->argument(1, 'int');	
		
		$this->_addressRefNo = $addressNumber;
		return $this;
	}
	
	/**
	 * Set shippers city
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
	 * Set date
	 *
	 * @param *string	
	 * @return this
	 */
	public function setDate($date) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$start = strtotime($date);
		$this->_date = date('Y-m-d\TH\:i\:s\.u', $start);
		return $this;
	}
	
	/**
	 * Set shippers first name
	 *
	 * @param *string	
	 * @return this
	 */
	public function setFirstName($firstName) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_firstName = $firstName;
		return $this;
	}
	
	/**
	 * Set shippers landmark
	 *
	 * @param *string	
	 * @return this
	 */
	public function setLandmark($landmark) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_landmark = $landmark;
		return $this;
	}
	
	/**
	 * Set shippers last name
	 *
	 * @param *string	
	 * @return this
	 */
	public function setLastName($lastName) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_lastName = $lastName;
		return $this;
	}
	
	/**
	 * Set shippers postal code
	 *
	 * @param *string	
	 * @return this
	 */
	public function setPostalCode($postalCode) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_postalCode = $postalCode;
		return $this;
	}
	
	/**
	 * Set shippers province
	 *
	 * @param *string	
	 * @return this
	 */
	public function setProvince($province) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_province = $province;
		return $this;
	}
	
	/**
	 * Set remarks
	 *
	 * @param *string
	 * @return this
	 */
	public function setRemarks($remarks) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_remarks = $remarks;
		return $this;
	}
	
	/**
	 * Set shippers street 1
	 *
	 * @param *string	
	 * @return this
	 */
	public function setStreet1($street1) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_street1 = $street1;
		return $this;
	}
	
	/**
	 * Set shippers street 2
	 *
	 * @param *string	
	 * @return this
	 */
	public function setStreet2($street2) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');
		
		$this->_street2 = $street2;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}