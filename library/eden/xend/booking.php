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
	 * Creates a booking for pickup.
	 *
	 * return array
	 */
	public function getResponse() {
		//if it is in test mode
		if($this->_test) {	
			$this->_url		= self::TEST_BOOKING_WSDL;
			$this->_header	= self::TEST_HEADER;
		} 
		
		// initialize SOAP client
		$client	= new SoapClient($this->_url, array());
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::USER_TOKEN => $this->_userToken);
		$header		= new SoapHeader($this->_header, self::AUTH_HEADER, $headerbody);
	
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(
			self::BOOKING_DATE		=> $this->_date,
			self::REFERENCE_NUMBER	=> $this->_addressRefNo,
			self::REMARKS			=> $this->_remarks);
		
		// execute SOAP method
		try {
			$result = $client->Schedule($query);
		//catch soap fault
		} catch(SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//print error
			return $error[0][1];
		}
		
		return $result;
	}
	
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}