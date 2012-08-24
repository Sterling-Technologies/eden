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
	/**
	 * Accept cash
	 * 
	 * @return this
	 */
	public function acceptCash() {
		$this->_query['accept_check'] = 1;
		
		return $this;
	}
	
	/**
	 * Accept check
	 * 
	 * @return this
	 */
	public function acceptCheck() {
		$this->_query['accept_check'] = 1;
		
		return $this;
	}
	
	/**
	 * Accept Google Checkout
	 * 
	 * @return this
	 */
	public function acceptGoogle() {
		$this->_query['accept_google'] = 1;
		
		return $this;
	}
	
	/**
	 * Accept invoice
	 * 
	 * @return this
	 */
	public function acceptInovice() {
		$this->_query['accept_invoice'] = 1;
		
		return $this;
	}
	
	/**
	 * Accept PayPal
	 * 
	 * @return this
	 */
	public function acceptPaypal() {
		$this->_query['accept_paypal'] = 1;
		
		return $this;
	}
	
	/**
	 * Set cash instructions
	 * 
	 * @param string
	 * @return this
	 */
	public function setCashInstructions($instructions) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['insrtructions_cash'] = $instructions;
		
		return $this;
	}
	
	/**
	 * Set check instructions
	 * 
	 * @param string
	 * @return this
	 */
	public function setCheckInstructions($instructions) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['insrtructions_check'] = $instructions;
		
		return $this;
	}
	
	/**
	 * Set event ID
	 * 
	 * @param int
	 * @return this
	 */
	public function setEvent($id) {
		//Argument 1 must be int
		Eden_Eventbrite_Error::i()->argument(1, 'int');
		
		$this->_query['event_id'] = $id;
		
		return $this;
	}
	
	/**
	 * Set your google merchant ID
	 * 
	 * @param string
	 * @return this
	 */
	public function setGoogleMerchantId($id) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['google_merchant_id'] = $id;
		
		return $this;
	}
	
	/**
	 * Set google merchant key
	 * 
	 * @param string
	 * @return this
	 */
	public function setGoogleMerchantKey($key) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['google_merchant_key'] = $key;
		
		return $this;
	}
	
	/**
	 * Set invoice instructions
	 * 
	 * @param string
	 * @return this
	 */
	public function setInvoiceInstructions($instructions) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['insrtructions_invoice'] = $instructions;
		
		return $this;
	}
	
	/**
	 * Accept PayPal Email
	 * 
	 * @param string
	 * @return this
	 */
	public function setPaypalEmail($email) {
		//Argument 1 must be a string
		Eden_Eventbrite_Error::i()->argument(1, 'string');
		
		$this->_query['paypal_email'] = $email;
		
		return $this;
	}
	
	/**
	 * Send update
	 * 
	 * @return array
	 */
	public function update() {
		return $this->_getJsonResponse($url, $this->_query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}