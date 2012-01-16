<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2009-2011 Christian Blanquera <cblanquera@gmail.com>
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * 
 *
 * @package    Eden
 * @category   Paypal
 * @author     Christian Blanquera <cblanquera@gmail.com>
 * @version    $Id: javascript.php 1 2010-01-02 23:06:36Z blanquera $
 */
class Eden_Paypal extends Eden_Class {
	/* Constants
	-------------------------------*/
	const PEM = '/paypal/cacert.pem';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns paypal express checkout
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_ExpressCheckout
	 */
	public function expressCheckout($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_ExpressCheckout::i($user, $password, $signature, $certificate);
	}
	
	/**
	 * Returns paypal transaction
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_Transaction
	 */
	public function transaction($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_Transaction::i($user, $password, $signature, $certificate);
	}
	
	/**
	 * Returns paypal autorization
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_Authorization
	 */
	public function autorization($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_Authorization::i($user, $password, $signature, $certificate);
	}
	
	/**
	 * Returns paypal directPayment
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_DirectPayment
	 */
	public function directPayment($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_DirectPayment::i($user, $password, $signature, $certificate);
	}
	
	/**
	 * Returns paypal recurringPayment
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_RecurringPayment
	 */
	public function recurringPayment($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_RecurringPayment::i($user, $password, $signature, $certificate);
	}
	
	/**
	 * Returns paypal buttonManager
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_DirectPayment
	 */
	public function buttonManager($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_ButtonManager::i($user, $password, $signature, $certificate);
	}
	
	/**
	 * Returns paypal billingAgreement
	 *
	 * @param string	API username
	 * @param string	API password
	 * @param string	API signature
	 * @param string	API certificate file
	 * @return Eden_Paypal_DirectPayment
	 */
	public function billingAgreement($user, $password, $signature, $certificate = NULL) {
		if(!is_string($certificate)) {
			$certificate = dirname(__FILE__).self::PEM;
		}
		
		return Eden_Paypal_BillingAgreement::i($user, $password, $signature, $certificate);
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}