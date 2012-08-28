<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

require_once dirname(__FILE__).'/curl.php';

/**
 * Intuit Innovative Gateway Solution WebCharge application
 * model for payment processing.
 *
 * @package    Eden
 * @category   webcharge
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Webcharge_Model extends Eden_Class
{
	/* Constants
	-------------------------------*/
	const PAYMENT_URL = 'https://transactions.innovativegateway.com/servlet/com.gateway.aai.Aai';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_user 		= NULL;
	protected $_agent 		= 'Mozilla/4.0';
	protected $_password	= NULL;
	protected $_proxy 		= NULL;
	protected $_timeout 	= 120;
	protected $_error		= NULL;
	
	protected $_template = array(
		//merchant authentication
		'username'				=> NULL,
		'pw'					=> NULL,
		//payment mode
		'test_override_errors'	=> 'true',
		//transaction information
		'response_mode'			=> 'simple',
		'response_fmt'			=> 'delimited',
		'upg_auth'				=> 'zxcvlkjh',
		'fulltotal'				=> NULL, 	// Total amount WITHOUT dollar sign.
		'authamount'			=> '', 		// Only valid for POSTAUTH and is equal to the original preauth amount.
		'trantype'				=> 'sale', 	// Options:  preauth, postauth, sale, credit, void
		'reference'				=> '', 		// Blank for new sales; required for VOID, POSTAUTH, and CREDITS; Will be original Approval value.
		'trans_id'				=> '', 		// Blank for new sales; required for VOID, POSTAUTH, and CREDITS; Will be original ANATRANSID value.
		//credit card information
		'cardtype'				=> NULL, 	// Options visa, mc, amex, diners, discover, jcb
		'ccnumber'				=> NULL, 	// CC# may include spaces or dashes.
		'month'					=> NULL, 	// Must be TWO DIGIT month.
		'year'					=> NULL, 	// Must be TWO or FOUR DIGIT year.
		'ccname'				=> NULL,
		//customer information
		'baddress'				=> NULL,
		'baddress1'				=> NULL,
		'bcity'					=> NULL,
		'bstate'				=> NULL,
		'bcountry'				=> 'US', 	// TWO DIGIT COUNTRY (United States = "US")
		'zip'					=> NULL,
		'phone'					=> NULL,
		'email'					=> NULL,
		//things that do not usually change
		'target_app'						=> 'WebEden_Chargev5.06',
		'delimited_fmt_field_delimiter'		=> '=',
		'delimited_fmt_include_fields'		=> 'true',
		'delimited_fmt_value_delimiter'		=> '|');
	
	protected $_creditCards 		= array('visa', 'mc', 'amex', 'diners', 'discover', 'jcb');
	protected $_transactionTypes 	= array('preauth', 'postauth', 'sale', 'credit', 'void');
	
	protected $_transaction = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($user = NULL, $password = NULL, array $options = array()) {
		$this->setUser($user)->setPassword($password);
			
		$this->_proxy 	= isset($options['proxy']) ? $options['proxy'] : NULL;
		$this->_agent 	= isset($options['agent']) ? $options['agent'] : 'Mozilla/4.0';
		$this->_timeout = isset($options['timeout']) ? $options['timeout'] : 120;
	}
	
	/* Public Methods
	-------------------------------*/	
	/**
	 * Validates required transaction parameters and sends 
	 * the transaction to Innovative Gateway Solutions.
	 *
	 * @return string the cURL result
	 */
	public function send() {
		//test for valid amount
		if(!$this->_transaction['fulltotal'] || !is_numeric($this->_transaction['fulltotal'])) {
			//throw exception
			Eden_Webcharge_Error::i()
				->setMessage(Eden_Webcharge_Error::INVALID_AMOUNT)
				->addVariable((string) $this->_transaction['fulltotal']);
		}
		
		//test for valid transaction type
		if(!$this->_transaction['trantype'] || !in_array($this->_transaction['trantype'], $this->_transactionTypes)) {
			//throw exception
			Eden_Webcharge_Error::i()
				->setMessage(Eden_Webcharge_Error::INVALID_TRANSACTION_TYPE)
				->addVariable((string) $this->_transaction['trantype'])
				->trigger();
		}
		
		//test for valid card type
		if(!$this->_transaction['cardtype'] || !in_array($this->_transaction['cardtype'], $this->creditCards)) {
			//throw exception
			Eden_Webcharge_Error::i()
				->setMessage(Eden_Webcharge_Error::INVALID_CARD_TYPE)
				->addVariable((string) $this->_transaction['cardtype'])
				->trigger();
		}
		
		//test for valid month
		if(!$this->_transaction['month'] || !is_numeric($this->_transaction['month']) || strlen((string) $this->_transaction['month']) != 2) {
			//throw exception
			Eden_Webcharge_Error::i()
				->setMessage(Eden_Webcharge_Error::INVALID_CREDIT_CARD_MONTH)
				->addVariable((string) $this->_transaction['month'])
				->trigger();
		}
		
		//test for valid year
		if(!$this->_transaction['year'] || !is_numeric($this->_transaction['year']) || !in_array(strlen((string) $this->_transaction['year']), array(2, 4))) {
			//throw exception																																	  
			Eden_Webcharge_Error::i()
				->setMessage(Eden_Webcharge_Error::INVALID_CREDIT_CARD_YEAR)
				->addVariable((string) $this->_transaction['year'])
				->trigger();
		}
		
		//test for valid creditcard name
		if(!$this->_transaction['ccname']) {
			//throw exception
			Eden_Webcharge_Error::i(Eden_Webcharge_Error::INVALID_CREDIT_CARD_NAME)->trigger();
		}
		
		// Create the connection through the cURL extension
		return Eden_Curl::i()
			->setUrl(self::PAYMENT_URL)
			->when($this->_proxy != NULL)
			->setProxy($this->_proxy)
			->endWhen()
			->setUserAgent($this->_agent)
			->setPost(true)
			->setPostFields($this->_transaction)
			->setFollowLocation(true)
			->setTimeout($this->_timeout)
			->getResponse();
	}
	
	/**
	 * Sets the merchant password
	 *
	 * @param string password
	 * @return this
	 */
	public function setPassword($password) {
		Eden_Webcharge_Error::i()
				->setMessage()->argument(1, 'string');
		$this->_transaction['pw'] = $password;
		return $this;
	}
	
	/**
	 * Set a transaction to send.
	 *
	 * @param array the transaction to set
	 * @return string the cURL result
	 */
	public function setTransaction(array $transaction) {
		//we loop through the template because
		//these are the keys WebCharge will take
		//and we do not want to add any extra variables
		//when we query their server
		foreach($this->_template as $key => $value) {
			//if the passed in transaction
			if(isset($transaction[$key])) {
				//allow this transaction to be set by it
				$this->_transaction[$key] = $transaction[$key];
			//else if it is not set in this transaction
			} else if(!isset($this->_transaction[$key])) {
				//set it using the template's value
				$this->_transaction[$key] = $value;
			}
		}
		
		return $this;
	}
	
	/**
	 * Sets the Merchant user name
	 *
	 * @param string user name
	 * @return this
	 */
	public function setUser($user) {
		Eden_Webcharge_Error::i()
				->setMessage()->argument(1, 'string');
		$this->_transaction['username'] = $user;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

/**
 * WebCharge exception
 */
class Eden_Webcharge_Error extends Eden_Error
{
	/* Constants
	-------------------------------*/
	const INVALID_AMOUNT			= 'The amount set in the transaction (fulltotal) must be a number. %s was given.';
	const INVALID_TRANSACTION_TYPE	= 'The transaction type (trantype) is invalid. "preauth", "postauth", "sale", "credit", "void" are allowed. %s was given.';
	const INVALID_CARD_TYPE			= 'The credit card type (cardtype) is invalid. "visa", "mc", "amex", "diners", "discover", "jcb" are allowed. %s was given.';
	const INVALID_CREDIT_CARD_MONTH	= 'The credit card month (month) must be a 2 digit number. %s was given.';
	const INVALID_CREDIT_CARD_YEAR	= 'The credit card year (year) must be a 2 or 4 digit number. %s was given.';
	const INVALID_CREDIT_CARD_NAME	= 'The credit card name cannot be empty.';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}