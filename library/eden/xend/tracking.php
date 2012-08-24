<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Xend Express - Tracking Service
 *
 * @package    Eden
 * @category   Xend
 * @author     Christian Symon M. Buenavista <sbuenavista@openovate.com>
 * @version    $Id: registry.php 1 2010-01-02 23:06:36Z blanquera $
 */

class Eden_Xend_Tracking extends Eden_Xend_Base{
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_exceptionFlag	= false;
	protected $_wayBillNo		= NULL;
	
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
	 * Retrieving tracking information given the waybill number of the
	 * shipment.
	 *
	 * @return array
	 */
	public function getTracking() {
		// initialize SOAP client
		$client	= new SoapClient(self::TRACKING_WSDL, array());
		$funcs	= $client->__getFunctions();
		
		// initialize SOAP header
		$headerbody	= array(self::USER_TOKEN => $this->_userToken);
		$header		= new SoapHeader(self::HEADER, self::AUTH_HEADER, $headerbody);
		$client->__setSoapHeaders($header);
		
		// prepare parameters
		$query = array(self::WAY_BILL_NO => $this->_wayBillNo);
		
		// execute SOAP method
		try {
			$result = $client->GetList($query);
		//catch soap fault
		} catch (SoapFault $soapfault) {
			$this->_exceptionFlag = true;
			$exception = $soapfault->getMessage();
			preg_match_all('/: (.*?). at/s', $exception, $error, PREG_SET_ORDER);
			//Print error
			return $error[0][1];			
		}
		return $result;	
	}
	
	/**
	 * Set way bill number
	 *
	 * @param *string
	 * @return this
	 */
	public function setWayBillNumber($wayBillNumber) {
		//Argument 1 must be a string
		Eden_Xend_Error::i()->argument(1, 'string');	
		
		$this->_wayBillNo = $wayBillNumber;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}