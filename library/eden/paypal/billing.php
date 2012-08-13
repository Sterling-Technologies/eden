<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Website Payments Pro - Billing Agreement
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Billing extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const SET_AGREEMENT		= 'SetCustomerBillingAgreement';
	const GET_AGREEMENT		= 'GetBillingAgreementCustomerDetails';
	const TOKEN				= 'TOKEN';
	const RETURN_URL		= 'RETURNURL';
	const CANCEL_URL		= 'CANCELURL';
	
	const ANY				= 'Any';
	const INSTANT_ONLY		= 'InstantOnly';
	const ACK				= 'ACK';
	const SUCCESS			= 'Success';
	
	const BILLING_TYPE		= 'L_BILLINGTYPEn';
	const BILLING_DESC		= 'L_BILLINGAGREEMENTDESCRIPTIONn';
	const PAYMENT_TYPE		= 'L_PAYMENTTYPEn';
	const AGREEMENT_CUSTOM	= 'L_BILLINGAGREEMENTCUSTOMn';
	const AMOUNT			= 'AMT';
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_token			= NULL;
	protected $_amout			= NULL;
	protected $_currency		= NULL;
	protected $_completeType	= NULL;
	protected $_billingType		= NULL;
	protected $_billingDesc		= NULL;
	protected $_paymentType		= NULL;
	protected $_agreementCustom	= NULL;
	
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
	 * initiates the creation of a billing agreement. 
	 *
	 * @param string		Returing URL
	 * @param string		Cancel URL
	 * @return string
	 */
	public function getResponse($return, $cancel) {
		//Argument Test
		Eden_Paypal_Error::i()
			->argument(1, 'string')		//Argument 1 must be a string
			->argument(2, 'string');	//Argument 2 must be a string
		
    	//populate fields
		$query = array(
			self::RETURN_URL		=> $return,
			self::CANCEL_URL		=> $cancel,
			self::BILLING_TYPE		=> $this->_billingType,	
			self::BILLING_DESC		=> $this->_billingDesc,			//Description associated with the billing agreement.
			self::PAYMENT_TYPE		=> $this->_paymentType,			//Valid vaules are Any or InstantOnly
			self::AGREEMENT_CUSTOM	=> $this->_agreementCustom);	//Custom annotation field for your own use.
		
		//call request method
		$response = $this->_request(self::SET_AGREEMENT, $query);
		
		//if parameters are success
		if(isset($response[self::ACK]) && $response[self::ACK] == self::SUCCESS) {
			//fetch token
			$this->_token = $response[self::TOKEN];  
			//if token is exist and not empty
			if($this->_token) {
				return $this->_getAgreement();
			}
		} 
		
		return $response;	
	}
	
	/**
	 * Custom annotation field for your own use.
	 *
	 * @param string
	 * @return this
	 * @note For recurring payments, this field is ignored.
	 */
	public function setAgreementCustom($agreementCustom) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');
		
		$this->_agreementCustom = $agreementCustom;
		return $this;
	}
	
	/**
	 * Description of goods or services associated 
	 * with the billing agreement.
	 *
	 * @param string
	 * @return this
	 */
	public function setBillingDesc($billingDesc) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');
		
		$this->_billingDesc = $billingDesc;
		return $this;
	}
	
	/**
	 * Set billing type
	 * 
	 * @param string
	 * @return this
	 */
	public function setBillingType($billingType) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');
		
		$this->_billingType = $billingType;
		return $this;
	}
	
	/**
	 * Set payment type to Any
	 *
	 * @return this
	 * @note For recurring payments, this field is ignored.
	 */
	public function setToAny() {
		$this->_paymentType = self::ANY;
		return $this;
	}
	
	/**
	 * Set payment type to Instant Only
	 *
	 * @return this
	 * @note For recurring payments, this field is ignored.
	 */
	public function setToInstantOnly() {
		$this->_paymentType = self::INSTANT_ONLY;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _getAgreement() {
		//populate fields
		$query = array(self::TOKEN => $this->_token);
		//call request method
		return $this->_request(self::GET_AGREEMENT, $query);
	}
	
	/* Private Methods
	-------------------------------*/
}