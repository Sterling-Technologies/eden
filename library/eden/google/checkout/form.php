<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google 
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Checkout_Form extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_TEST_CHECKOUT	= 'https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/%s';
	const URL_LIVE_CHECKOUT	= 'https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/ 
	protected $_merchantId		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($merchantId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
			
		$this->_merchantId = $merchantId;
		
	}
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a checkout form
	 *
	 * @param string
	 * @param string|integer
	 * @param string
	 * @param string|integer
	 * @param string 
	 * @param boolean Set to false for live url
	 * @return array
	 */
	public function checkoutForm($itemName, $price, $description, $quantity, $currency = 'USD', $test = true) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')				//argument 1 must be a string
			->argument(2, 'string', 'int')		//argument 2 must be a string or integer	
			->argument(3, 'string')				//argument 3 must be a string
			->argument(4, 'string', 'int')		//argument 4 must be a string or integer	
			->argument(5, 'string')				//argument 5 must be a string
			->argument(6, 'bool');				//argument 6 must be a booelean	
		
		if($test = true) {
			//set url to sandbox
			$url = sprintf(self::URL_TEST_CHECKOUT, $this->_merchantId);
		} else {
			//set url to live account
			$url = sprintf(self::URL_LIVE_CHECKOUT, $this->_merchantId);
		}
		//make a xml template
		$form = Eden_Template::i()
			->set('url', $url)
			->set('itemName', $itemName)
			->set('itemDescription', $description)
			->set('itemPrice', $price)
			->set('itemCurrency', $currency)
			->set('itemQuantity', $quantity)
			->set('merchantId', $this->_merchantId)
			->parsePHP(dirname(__FILE__).'/template/form.php');
		
		return $form;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}