<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Asia pay client post
 *
 * @package    Eden
 * @category   asiapay
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Asiapay_Client extends Eden_Asiapay_Base { 
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_secureHashSecret	= NULL;
	protected $_currencyCode		= '608';
	protected $_payType				= 'N';
	protected $_language			= 'E';
	protected $_payMethod			= 'CC';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($merchantId, $test = true, $secureHash = NULL) {
		//argument test
		Eden_Asiapay_Error::i()
			->argument(1, 'string')				//argument 1 must be a string
			->argument(2, 'bool')				//argument 2 must be a boolean
			->argument(3, 'string', 'null');	//argument 3 must be a string or null
		
		$this->_merchantId 			= $merchantId;
		$this->_test 				= $test;
		$this->_secureHashSecret	= $secureHash; 

	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Set Multi-Currency Processing Service (MPS) Mode
	 * For merchant who applied MPS function
	 * Accepted values are:  
	 * NIL or not provide – Disable MPS (merchant not using MPS)
	 * SCP – Enable MPS with ‘Simple Currency Conversion’
	 * DCC – Enable MPS with ‘Dynamic Currency Conversion’
	 * MCP – Enable MPS with ‘Multi Currency Pricing’
	 * 
	 * @param string 
	 * @return this
	 */
	public function setMpsmode($mpsMode) {
		//argument 1 must be a string
		Eden_Asiapay_Error::i()->argument(1, 'string');
		$this->_query['mpsMode'] = $mpsMode;
		
		return $this;
	}
	
	/**
	 * A remark field for you to store additional data that will
	 * not show on the transaction web page
	 * 
	 * @param string 
	 * @return this
	 */
	public function setRemark($remark) {
		//argument 1 must be a string
		Eden_Asiapay_Error::i()->argument(1, 'string');		
		$this->_query['remark'] = $remark;
		
		return $this;
	}
	
	/**
	 * Number of seconds auto-redirection to merchant’s site
	 * takes place at PesoPay’s Payment Success / Fail page
	 * 
	 * @param string|integer
	 * @return this
	 */
	public function setRedirect($redirect) {
		//argument 1 must be a string or integer
		Eden_Asiapay_Error::i()->argument(1, 'int', 'string');	
		$this->_query['redirect'] = $redirect;
		
		return $this;
	}
	
	/**
	 * Disable the print function at payment result page
	 * 
	 * @return this
	 */
	public function disablePrint() {
		$this->_query['print'] = 'no';
		
		return $this;
	}
	
	/**
	 * Disable the retry function when the transaction is rejected
	 * 
	 * @return this
	 */
	public function disableFailRetry() {	
		$this->_query['failRetry'] = 'no';
		
		return $this;
	}
	/**
	 * Set the currency of the payment:
	 * 
	 * @param string 
	 * @return this
	 */
	public function setCurrencyCode($currencyCode) {
		//argument 1 must be a string
		Eden_Asiapay_Error::i()->argument(1, 'string');						
		$this->_currencyCode = $currencyCode;
		
		return $this;
	}
	
	/**
	 * Set payment type
	 * 
	 * @param string 
	 * @return this
	 */
	public function setPaymentType($payType) {
		//argument 1 must be a string
		Eden_Asiapay_Error::i()->argument(1, 'string');						
		$this->_payType = $payType;
		
		return $this;
	}
	
	/**
	 * Set language of the payment page
	 * 
	 * @param string 
	 * @return this
	 */
	public function setLanguage($language) {
		//argument 1 must be a string
		Eden_Asiapay_Error::i()->argument(1, 'string');						
		$this->_language = $language;
		
		return $this;
	}
	
	/**
	 * The payment method
	 * Accepted values are:
	 * ALL –All the available payment method
	 * CC – Credit Card Payment
	 * VISA – Visa Payment
	 * Master – MasterCard Payment
	 * JCB – JCB Payment
	 * AMEX – AMEX Payment
	 * Diners – Diners Club Payment
	 * PAYPAL – PayPal By PesoPay Payment
	 * BancNet – BancNet Debit Payment
	 * GCash – GCash Payment
	 * SMARTMONEY – Smartmoney Payment
	 * 
	 * @param string 
	 * @return this
	 */
	public function setPaymentMethod($payMethod) {
		//argument 1 must be a string
		Eden_Asiapay_Error::i()->argument(1, 'string');						
		$this->_payMethod = $payMethod;
		
		return $this;
	}
	
	/**
	 * Create asia pay form 
	 *  
	 * @param integer|float The total amount your want to charge the customer for the provided currency
	 * @param url A Web page address you want us to redirect upon the transaction being rejected by us.
	 * @param url A Web page address you want us to redirect upon the transaction being rejected by us.
	 * @param url A Web page address you want us to redirect upon the transaction being cancelled by your customer
	 * @return string
	 */
	public function createForm($amount, $successUrl, $failUrl, $cancelUrl) {
		//argument test
		Eden_Asiapay_Error::i()
			->argument(1, 'int', 'float')	//argument 1 must be a integer or float
			->argument(2, 'url')			//argument 2 must be a url
			->argument(3, 'url')			//argument 3 must be a url
			->argument(4, 'url');			//argument 4 must be a url
		
		//creata a random order reference number 
		$orderRef = rand(10000, 99999);
		
		$this->_query['amount'] 	= $amount;
		$this->_query['successUrl'] = $successUrl;
		$this->_query['failUrl'] 	= $failUrl;
		$this->_query['cancelUrl'] 	= $cancelUrl;
		$this->_query['orderRef'] 	= $orderRef;
		$this->_query['merchantId'] = $this->_merchantId;
		$this->_query['currCode']	= $this->_currencyCode;		//if not specify, default is '608' - PH
		$this->_query['payType']	= $this->_payType;			//if not specify, default is 'N' - Normal Payment (Sales)
		$this->_query['lang']		= $this->_language;			//if not specify, default is 'E' - English
		$this->_query['payMethod']	= $this->_payMethod;		//if not specify, default is 'CC' - Credit Card Payment
		
		//prevent sending fields with no value
		$this->_query = $this->_removeNull($this->_query);
		
		//if test is true
		if($this->_test) {
			//use the test url
			$url = self::CLIENTPOST_TEST_URL;
		//else test is false
		} else {
			//use the live url
			$url = self::CLIENTPOST_LIVE_URL;
			//make a secure hash to prevent hacking
			$hash = $this->_generateHash($amount, $orderRef);
			//use secure hash when using live transaction
			$this->_query['secureHash'] = $hash;
		}
		//echo '<pre>'; print_r($this->_query); exit;
		//make a form template
		$parameters = Eden_Template::i()
			->set('query', $this->_query)
			->set('url', $url)
			->parsePHP(dirname(__FILE__).'/template/asiapay.php');
		
		//reset variables
		unset($this->_query);
		
		return $parameters;
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}