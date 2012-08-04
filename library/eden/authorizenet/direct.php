<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Authorize.net - Direct Post Method
 *
 * @package    Eden
 * @category   authorize.net
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Authorizenet_Direct extends Eden_Authorizenet_Base{
	/* Constants
	-------------------------------*/
	const LIVE_URL	= 'https://secure.authorize.net/gateway/transact.dll';
    const TEST_URL	= 'https://test.authorize.net/gateway/transact.dll';
	
	const AMOUNT		= 'x_amount';       
	const SEQUENCE		= 'x_fp_sequence';   
	const HASH			= 'x_fp_hash';      
	const TIMESTAMP		= 'x_fp_timestamp';  
	const RESPONSE		= 'x_relay_response';
	const RELAY_URL		= 'x_relay_url';     
	const LOGIN			= 'x_login';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_amount		= 0;
	protected $_returnUrl	= NULL;
	protected $_postUrl		= self::TEST_URL;
	
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
     * Set transaction amount 
     *
	 * @param *integer|float Transaction amount
     * @return this
     */
	public function setAmount($amount) {
		//Argument 1 must be an integer or float
		Eden_Authorizenet_Error::i()->argument(1, 'int', 'float');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Demonstrates the Direct Post Method
	 *
	 * return this
	 */
	public function getResponse(){
		//if it is in live mode
		if($this->_isLive) {
			$this->_postUrl = self::LIVE_URL;
		}
		
		//Call get fingerprint method
		$fingerPrint = 	$this->_getFingerprint($this->_amount);
	
		//Call block
		return Eden_Authorizenet_Block_Post::i($this->_postUrl, array(
			self::AMOUNT	=> $this->_amount,		
			self::SEQUENCE	=> $this->_sequence,	
			self::HASH		=> $fingerPrint,		
			self::TIMESTAMP	=> $this->_time,
			self::RESPONSE	=> 'FALSE',
			self::RELAY_URL	=> $this->_returnUrl,
			self::LOGIN		=> $this->_apiLogin));
    }
		
	/**
     * Set return URL 
     *
	 * @param *string
     * @return this
     */
	public function setReturnUrl($url) {
		//Argument 1 must be a string
		Eden_Authorizenet_Error::i()->argument(1, 'string');	
		
		$this->_returnUrl = $url;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/	
	/* Private Methods
	-------------------------------*/
}