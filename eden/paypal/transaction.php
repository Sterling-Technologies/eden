<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Paypal Website Payments Pro - Common transaction
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Paypal_Transaction extends Eden_Paypal_Base {
	/* Constants
	-------------------------------*/
	const GET_DETAIL			= 'GetTransactionDetails';
	const MANAGE_STATUS			= 'ManagePendingTransactionStatus';
	const REFUND_TRANSACTION	= 'RefundTransaction';
	const SEARCH				= 'TransactionSearch';
	
	const ACTION			= 'ACTION';
	const REFUND_TYPE		= 'REFUNDTYPE';
	const STORE_ID			= 'STOREID';
	const START				= 'STARTDATE';
	const END				= 'ENDDATE';
	const EMAIL				= 'EMAIL';
	const RECEIVER			= 'RECEIVER';
	const RECEIPT_ID		= 'RECEIPTID';
	const TRANSACTION_ID	= 'TRANSACTIONID';
	const CARD_NUMBER		= 'ACCT';
	const AMOUNT			= 'AMT';				
	const CURRENCY			= 'CURRENCYCODE';
	const STATUS			= 'STATUS';
	const NOTE				= 'NOTE';
	
	/* Public Properties
	-------------------------------*/	
	/* Protected Properties
	-------------------------------*/
	protected $_action			= NULL;
	protected $_refundType		= NULL;
	protected $_amount			= NULL;
	protected $_currency		= NULL;
	protected $_note			= NULL;
	protected $_storeId			= NULL;
	protected $_start			= NULL;	
	protected $_end				= NULL;
	protected $_email			= NULL;
	protected $_receiver		= NULL;
	protected $_receiptId		= NULL;
	protected $_transactionId	= NULL;
	protected $_cardNumber		= NULL;
	protected $_status			= NULL;
	
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
	 * Obtains information about a specific transaction. 
	 *
	 * @return string
	 */
	public function getDetail() {
    	//populate fields
		$query = array(self::TRANSACTION_ID => $this->_transactionId);
		//call request method
		$response = $this->_request(self::GET_DETAIL, $query);
		
		return $response;
	}
	
	/**
	 * Accepts or denys a pending transaction held 
	 * by Fraud Management Filters. 
	 *
	 * @return string
	 */
	public function manageStatus() {
    	//populate fields
		$query = array(
			self::TRANSACTION_ID	=> $this->_transactionId,	//The transaction ID of the payment transaction.
			self::ACTION			=> $this->_action);			//Valid values are Accept or Deny
		//call request method
		$response = $this->_request(self::MANAGE_STATUS, $query);
		
		return $response;
	}
	
	/**
	 * Issues a refund to the PayPal account holder 
	 * associated with a transaction.
	 *
	 * @return string
	 */
	public function refundTransaction() {
    	//populate fields
		$query = array(
			self::TRANSACTION_ID	=> $this->_transactionId,	//The transaction ID of the payment transaction.
			self::REFUND_TYPE		=> $this->_refundType,		//Valid values are Full,Partial,ExternalDispute or Other 
			self::AMOUNT			=> $this->_amount,			//Refund amount. 
			self::CURRENCY			=> $this->_currency,		//Currency code
			self::NOTE				=> $this->_note,			//Custom memo about refund
			self::STORE_ID			=> $this->_storeId);		//ID of merchant store
		//call request method
		$response = $this->_request(self::REFUND_TRANSACTION, $query);
		
		return $response;
	}
	
	/**
	 * Searches transaction history for transactions 
	 * that meet the specified criteria.
	 *
	 * @return string
	 * @note The maximum number of transactions that 
	 * can be returned from a TransactionSearch API call is 100.
	 */
	public function search() {
    	//populate fields
		$query = array(
			self::START				=> $this->_start,			//The earliest transaction date at which to start the search 
			self::END				=> $this->_end,				//The latest transaction date to be included in the search. 
			self::EMAIL				=> $this->_email,			//Search by the buyer’s email address.
			self::RECEIVER			=> $this->_receiver,		//Search by the receiver’s email address.
			self::RECEIPT_ID		=> $this->_receiptId,		//Search by the PayPal Account Optional receipt ID.
			self::TRANSACTION_ID	=> $this->_transactionId,	//The transaction ID of the payment transaction.
			self::CARD_NUMBER		=> $this->_cardNumber,		//Search by credit card number
			self::AMOUNT			=> $this->_amount,			//Search by transaction amount
			self::CURRENCY			=> $this->_currency,		//Search by currency code.
			self::STATUS			=> $this->_status);			//Search by transaction status.
		
		//call request method
		$response = $this->_request(self::SEARCH, $query);
		
		return $response;
	}
	
	/**
	 * Valid values are Accept or Deny
	 *
	 * @param string
	 * @return this
	 */
	public function setAction($action) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_action = $action;
		return $this;
	}
	
	/**
	 * Set item amount  
	 *
	 * @param string		Item amount
	 * @return this
	 */
	public function setAmount($amount) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_amount = $amount;
		return $this;
	}
	
	/**
	 * Search by credit card number  
	 *
	 * @param string		Credit card number
	 * @return this
	 */
	public function setCardNumber($cardNumber) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_cardNumber = $cardNumber;
		return $this;
	}
	
	/**
	 * Set currency code 
	 *
	 * @param string		Currency code
	 * @return this
	 */
	public function setCurrency($currency) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_currency = $currency;
		return $this;
	}
	
	/**
	 * Search by the buyer’s email address.
	 *
	 * @param string
	 * @return this
	 */
	public function setEmail($email) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_email = $email;
		return $this;
	}
	
	/**
	 * The latest transaction date to be 
	 * included in the search.
	 *
	 * @param string
	 * @return this
	 */
	public function setEndDate($end) {
		$date = strtotime($end);
		$this->_end = gmdate('Y-m-d\TH:i:s\Z', $date);
		return $this;
	}
	
	/**
	 * Custom memo about the refund.
	 *
	 * @param string
	 * @return this
	 */
	public function setNote($note) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_note = $note;
		return $this;
	}
	
	/**
	 * Search by the PayPal Account Optional 
	 * receipt ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setReceiptId($receiptId) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_receiptId = $receiptId;
		return $this;
	}
	
	/**
	 * Search by the receiver’s email address. 
	 * If the merchant account has only one email 
	 * address, this is the primary email. It can 
	 * also be a non-primary email address.
	 *
	 * @param string
	 * @return this
	 */
	public function setReceiver($receiver) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_receiver = $receiver;
		return $this;
	}
	
	/**
	 * Valid values are 
	 * Full - Full refund (default).
	 * Partial – Partial refund.
	 * ExternalDispute – External dispute.
	 * Other – Other type of refund.
	 *
	 * @param string
	 * @return this
	 */
	public function setRefundType($refundType) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_refundType = $refundType;
		return $this;
	}
	
	/**
	 * The earliest transaction date at 
	 * which to start the search.
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
	 * Search by transaction status. 
	 *
	 * @param string		Currency code
	 * @return this
	 */
	public function setStatus($status) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_status = $status;
		return $this;
	}
	
	/**
	 * ID of the merchant store. This field is 
	 * required for point-of-sale transactions.
	 *
	 * @param string
	 * @return this
	 */
	public function setStoreId($storeId) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_storeId = $storeId;
		return $this;
	}
	
	/**
	 * Search by the transaction ID. The 
	 * returned results are from the merchant’s
	 * transaction records.
	 *
	 * @param string
	 * @return this
	 */
	public function setTransactionId($transactionId) {
		//Argument 1 must be a string
		Eden_Paypal_Error::i()->argument(1, 'string');	
		
		$this->_transactionId = $transactionId;
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}