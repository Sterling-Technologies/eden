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
class Eden_Authorizenet_Server extends Eden_Authorizenet_Base{
	/* Constants
	-------------------------------*/
	const LIVE_URL	= 'https://secure.authorize.net/gateway/transact.dll';
    const TEST_URL	= 'https://test.authorize.net/gateway/transact.dll';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_testMode	= self::TEST_URL;
	protected $_amount		= NULL;
	protected $_description	= NULL;
	
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
	 * Set the amount of the item  
	 *
	 * @param *integer|float Amount of the item
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Paypal_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Set item description 
	 *
	 * @param *string Short description of the item	
	 * @return this
	 */
	public function setDescription($description) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_description = $description;
		return $this;
	}
	
	/**
	 * Provides a secure hosted payment form.
	 *
	 * @return this
	 */
	public function getResponse() {
		//if it is in live mode
		if($this->_isLive) {
			$this->_testMode = self::LIVE_URL;
		}
		//Call get fingerprint method
		$fingerprint = $this->_getFingerprint($this->_amount);
		//Call block
		return Eden_Authorizenet_Block_Confirm::i(
			$this->_apiLogin, 	
			$fingerprint, 
			$this->_amount, 
			$this->_description,
			$this->_testMode);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}