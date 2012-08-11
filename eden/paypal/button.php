<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Website Payments Standard - Button Manager
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Button extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const SEARCH		= 'BMButtonSearch';
	const SET_BUTTON	= 'BMCreateButton';
	const GET_BUTTON	= 'BMGetButtonDetails';
	const GET_INVENTORY	= 'BMGetInventory';
	const REMOVE_BUTTON	= 'BMManageButtonStatus';
	const UPDATE_BUTTON	= 'BMUpdateButton';
	
	const BUTTON_ID		= 'HOSTEDBUTTONID';
	const REMOVE		= 'DELETE';
	
	const OPTION_NAME		= 'OPTIONnNAME';
	const OPTION_SELECT		= 'L_OPTIONnSELECTx';
	const OPTION_PRICE		= 'L_OPTION0PRICEx';
	const OPTION_TYPE		= 'OPTIONnTYPE';
	const BILLING_PERIOD	= 'L_OPTIONnBILLINGPERIOD x';
	const BILLING_FREQUENCY	= 'L_OPTIONnBILLINGPFREQUENCY x';
	const BILING_TOTAL		= 'L_OPTIONnTOTALBILLINGCYCLES x';
	const OPTION_AMOUNT		= 'L_OPTIONnAMOUNTx';
	const SHIPPING_AMOUNT	= 'L_OPTIONnSHIPPINGAMOUNTx';
	const TAX_AMOUNT		= 'L_OPTIONnTAXAMOUNTx';	
	const START				= 'STARTDATE';
	const END				= 'ENDDATE';
	
	const BUY_NOW			= 'BUYNOW';
	const CART				= 'CART';		
	const GIFT_CERTIFICATE	= 'GIFTCERTIFICATE';
	const SUBSCRIBE			= 'SUBSCRIBE';	
	const DONATE			= 'DONATE';	
	const UNSUBSCRIBE		= 'UNSUBSCRIBE';
	const VIEW_CART			= 'VIEWCART';			
	const PAYMENT_PLAN		= 'PAYMENTPLAN';	
	const AUTOBILLING		= 'AUTOBILLING';
	const PAYMENT			= 'PAYMENT';
	
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_buttonId			= NULL;
	protected $_start				= NULL;
	protected $_end					= NULL;
	protected $_buttonType			= NULL;
	protected $_optionName			= NULL;
	protected $_optionSelect		= NULL;
	protected $_optionPrice			= NULL;
	protected $_optionType			= NULL;
	protected $_billingPeriod		= NULL;
	protected $_billingFrequency	= NULL;
	protected $_billingTotal		= NULL;
	protected $_optionAmount		= NULL;
	protected $_shippingAmount		= NULL;
	protected $_taxAmount			= NULL;
	
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
	 * Initiates the creation of a billing agreement.
	 *
	 * @return string
	 */
	public function getButton() {
		//populate fields
		$query = array(
			self::BUTTON_TYPE		=> $this->_buttonType,		//The kind of button you want to create.
			self::OPTION_NAME		=> $this->_name,			//The menu name
			self::OPTION_SELECT		=> $this->_select,			//The menu item’s name
			self::OPTION_PRICE		=> $this->_price,			//The price associated with the first menu item
			self::OPTION_TYPE		=> $this->_type,			//The installment option type for an OPTIONnNAME
			self::BILLING_PERIOD	=> $this->_billingPeriod,	//The installment cycle unit
			self::BILLING_FREQUENCY	=> $this->_billingFrequency,//The installment cycle frequency in units
			self::BILLING_TOTAL		=> $this->_billingTotal,	//The total number of billing cycles,
			self::OPTION_AMOUNT		=> $this->_optionAmount,	//The base amount to bill for the cycle.
			self::SHIPPING_AMOUNt	=> $this->_shippingAmount,	//The shipping amount to bill for the cycle
			self::TAX_AMOUNT		=> $this->_taxAmount);		//The tax amount to bill for the cycle
		
		//call request method
		$response = $this->_request(self::SET_BUTTON, $query);
		//if parameters are success
		if(isset($response[self::BUTTON_ID])) {
			// Get the button ID 
			$this->_buttonId =  $response[self::BUTTON_ID];	   
			//call get button detail method
			return $this->_request(self::GET_BUTTON, $query);
		}
		
		return $response;
	}
	
	/**
	 * Determine the inventory levels and other 
	 * inventory-related information for a button 
	 * and menu items associated with the button. 
	 * Typically, you call BMGetInventory to obtain 
	 * field values before calling BMSetInventory 
	 * to change the inventory levels.
	 *
	 * @return string
	 */
	public function getInventory() {
		//populate fields
		$query = array(self::BUTTON_ID	=> $this->_buttonId);
		//call request method
		$resposne =  $this->_request(self::GET_INVENTORY, $query);
		
		return $response;
	}
	
	/**
	 * Change the status of a hosted button. 
	 * Currently, you can only delete a button.
	 *
	 * @return string
	 */
	public function remove() {
		//populate fields
		$query = array(
			self::BUTTON_ID	=> $this->_buttonId,	//The Hosted Button Id
			self::STATUS	=> self::REMOVE);		//Delete the button
		//call request method
		$resposne =  $this->_request(self::REMOVE_BUTTON, $query);
		
		return $response;
	}
	
	/**
	 * Obtain a list of your hosted Website
	 * Payments Standard buttons.
	 *
	 * @return string
	 */
	public function search() {
    	//populate fields
		$query = array(
			self::START				=> $this->_start,		//Starting date for the search.  
			self::END				=> $this->_end);		//Ending date for the search. 			
		//call request method
		return $this->_request(self::SEARCH, $query);
	}
	
	/**
	 * The base amount to bill for the cycle.
	 *
	 * @param string
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * The installment cycle frequency in units, 
	 * e.g. if the billing frequency is 2 and the 
	 * billing period is Month, the billing cycle 
	 * is every 2 months. The default billing 
	 * frequency is 1.
	 *
	 * @param string
	 * @return this
	 */
	public function setBillingFrequency($billingFrequency) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'int');	
		
		$this->_billingFrequency = $billingFrequency;
		return $this;
	}
	
	/**
	 * Valid values are
	 * NoBillingPeriodType - None (default)
	 * Day
	 * Week
	 * SemiMonth
	 * Month
	 * Year
	 *
	 * @param string
	 * @return this
	 */
	public function setBillingPeriod($billingPeriod) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_billingPeriod = $billingPeriod;
		return $this;
	}
	
	/**
	 * The total number of billing cycles, regardless of 
	 * the duration of a cycle; 1 is the default
	 *
	 * @param string
	 * @return this
	 */
	public function setBillingTotal($billingTotal) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'int');	
		
		$this->_billingTotal = $billingTotal;
		return $this;
	}
	
	/**
	 * Set hosted button id
	 *
	 * @param string	The hosted button id
	 * @return this
	 */
	public function setButtonId($setbuttonId) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_setbuttonId = setbuttonId;
		return $this;
	}
	
	/**
	 * Ending date for the search.
	 * The value must be in UTC/GMT format
	 *
	 * @param string
	 * @return this
	 */
	public function setEndDate($end) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$date = strtotime($end);
		$this->_end = gmdate('Y-m-d\TH:i:s\Z', $date);
		return $this;
	}
	
	/**
	 * It is one or more variables, in which n is a
	 * digit between 0 and 4, inclusive, for hosted 
	 * buttons; otherwise, it is a digit between 0 
	 * and 9, inclusive
	 *
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_name = $name;
		return $this;
	}
	
	/**
	 * It is a list of variables for each OPTIONnNAME, 
	 * in which x is a digit between 0 and 9, inclusive
	 *
	 * @param string
	 * @return this
	 * @note If you specify a price, you cannot set 
	 * a button variable to amount.
	 */
	public function setOptionPrice($optionPrice) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_optionPrice = $optionPrice;
		return $this;
	}
	
	/**
	 * It is a list of variables for each OPTIONnNAME, 
	 * in which x is a digit between 0 and 9, inclusive
	 *
	 * @param string
	 * @return this
	 */
	public function setOptionSelect($optionSelect) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_optionSelect = $optionSelect;
		return $this;
	}
	
	/**
	 * The shipping amount to bill for the cycle, 
	 * in addition to the base amount.
	 *
	 * @param string
	 * @return this
	 */
	public function setShippingAmount($shippingAmount) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_shippingAmount = $shippingAmount;
		return $this;
	}
	
	/**
	 * Starting date for the search. 
	 * The value must be in UTC/GMT format
	 *
	 * @param string
	 * @return this
	 */
	public function setStartDate($start) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$date = strtotime($start);
		$this->_start = gmdate('Y-m-d\TH:i:s\Z', $date);
		return $this;
	}
	
	/**
	 * The tax amount to bill for the cycle, 
	 * in addition to the base amount.
	 *
	 * @param string
	 * @return this
	 */
	public function setTaxAmount($taxAmount) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_taxAmount = $taxAmount;
		return $this;
	}
	
	/**
	 * Set button type to Autobilling
	 *
	 * @return this
	 */
	public function setToAutobilling() {
		$this->_buttonType = self::AUTOBILLING;
		return $this;
	}
	
	/**
	 * Set button type to buy now
	 *
	 * @return this
	 */
	public function setToBuyNow() {
		$this->_buttonType = self::BUY_NOW;
		return $this;
	}
	
	/**
	 * Set button type to CART
	 *
	 * @return this
	 */
	public function setToCart() {
		$this->_buttonType = self::CART;
		return $this;
	}
	
	/**
	 * Set button type to Donate
	 *
	 * @return this
	 */
	public function setToDonate() {
		$this->_buttonType = self::DONATE;
		return $this;
	}
	
	/**
	 * Set button type to Gift Certificate
	 *
	 * @return this
	 */
	public function setToGiftCertificate() {
		$this->_buttonType = self::GIFT_CERTIFICATE;
		return $this;
	}
	
	/**
	 * Set button type to Payment
	 *
	 * @return this
	 */
	public function setToPayment() {
		$this->_buttonType = self::PAYMENT;
		return $this;
	}
	
	/**
	 * Set button type to Payment Plan
	 *
	 * @return this
	 */
	public function setToPaymentPlan() {
		$this->_buttonType = self::PAYMENT_PLAN;
		return $this;
	}
	
	/**
	 * Set button type to Subscribe
	 *
	 * @return this
	 */
	public function setToSubscribe() {
		$this->_buttonType = self::SUBSCRIBE;
		return $this;
	}
	
	/**
	 * Set button type to UnSubscribe
	 *
	 * @return this
	 */
	public function setToUnSubscribe() {
		$this->_buttonType = self::UNSUBSCRIBE;
		return $this;
	}
	
	/**
	 * Set button type to View Cart
	 *
	 * @return this
	 */
	public function setToViewCart() {
		$this->_buttonType = self::VIEW_CART;
		return $this;
	}
	
	/**
	 * Valid values are
	 * FULL		- Payment in full
	 * VARIABLE - Variable installments
	 * EMI		- Equal installments
	 *
	 * @param string
	 * @return this
	 */
	public function setType() {
		
		$this->_type = $tType;
		return $this;
	}
	
	/**
	 * Valid values are
	 * FULL		- Payment in full
	 * VARIABLE - Variable installments
	 * EMI		- Equal installments
	 *
	 * @param string
	 * @return this
	 */
	public function setTypeFull() {
		
		$this->_optionType = 'FULL';
		return $this;
	}
	
	/**
	 * Updates the an agreeement
	 *
	 * @return string
	 */
	public function update() {
		//populate fields
		$query = array(
			self::BUTTON_ID			=> $this->_buttonId,		//The Hosted Button Id
			self::BUTTON_TYPE		=> $this->_buttonType,		//The kind of button you want to create.
			self::OPTION_NAME		=> $this->_optionName,		//The menu name
			self::OPTION_SELECT		=> $this->_optionSelect,	//The menu item’s name
			self::OPTION_PRICE		=> $this->_optionPrice,		//The price associated with the first menu item
			self::OPTION_TYPE		=> $this->_optionType,		//he installment option type for an OPTIONnNAME
			self::BILLING_PERIOD	=> $this->_billingPeriod,	//The installment cycle unit
			self::BILLING_FREQUENCY	=> $this->_billingFrequency,//The installment cycle frequency in units
			self::BILLING_TOTAL		=> $this->_billingTotal,	//The total number of billing cycles,
			self::OPTION_AMOUNT		=> $this->_amount,			//The base amount to bill for the cycle.
			self::SHIPPING_AMOUNt	=> $this->_shippingAmount,	//The shipping amount to bill for the cycle
			self::TAX_AMOUNT		=> $this->_taxAmount);		//The tax amount to bill for the cycle
		
		//call request method
		$response = $this->_request(self::UPDATE, $query);
		//if parameters are success
		if(isset($response[self::BUTTON_ID])) {
			// Get the button ID 
			$this->_buttonId =  $response[self::BUTTON_ID];	   
			//call get button detail method
			return $this->_getButton;
		} 
		
		return $response;
	
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}