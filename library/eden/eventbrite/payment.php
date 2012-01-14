<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Eventbrite payment
 *
 * @package    Eden
 * @category   eventbrite
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Eventbrite_Payment extends Eden_Eventbrite_Base {
	/* Constants
	-------------------------------*/
	const URL = 'https://www.eventbrite.com/json/payment_update';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	public function setEvent($id) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$query['event_id'] = $id;
		
		return $this;
	}
	
	public function acceptPaypal() {
		$query['accept_paypal'] = 1;
		
		return $this;
	}
	
	public function setPaypalEmail($email) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['paypal_email'] = $email;
		
		return $this;
	}
	
	public function acceptGoogle() {
		$query['accept_google'] = 1;
		
		return $this;
	}
	
	public function setGoogleMerchantId($id) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['google_merchant_id'] = $id;
		
		return $this;
	}
	
	public function setGoogleMerchantKey($key) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['google_merchant_key'] = $key;
		
		return $this;
	}
	
	public function acceptCheck() {
		$query['accept_check'] = 1;
		
		return $this;
	}
	
	public function setCheckInstructions($check) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['insrtructions_check'] = $check;
		
		return $this;
	}
	
	public function acceptCash() {
		$query['accept_check'] = 1;
		
		return $this;
	}
	
	public function setCashInstructions($check) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['insrtructions_cash'] = $check;
		
		return $this;
	}
	
	public function acceptInovice() {
		$query['accept_invoice'] = 1;
		
		return $this;
	}
	
	public function setInvoiceInstructions($check) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$query['insrtructions_invoice'] = $check;
		
		return $this;
	}
	
	public function send() {
		return $this->_getJsonResponse($url, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}