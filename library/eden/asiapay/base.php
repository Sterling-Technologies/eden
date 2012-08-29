<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Asia pay base
 *
 * @package    Eden
 * @category   asiapay
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Asiapay_Base extends Eden_Class {
	/* Constants
	-------------------------------*/
	const MERCHANT_ID				= 'merchantId';
	const ORDER_REF					= 'orderRef';
	const CLIENTPOST_TEST_URL 		= 'https://test.pesopay.com/b2cDemo/eng/payment/payForm.jsp';
	const CLIENTPOST_LIVE_URL 		= 'https://www.pesopay.com/b2c2/eng/payment/payForm.jsp';
	const DIRECTCLIENT_TEST_URL 	= 'https://test.pesopay.com/b2cDemo/eng/dPayment/payComp.jsp';
	const DIRECTCLIENT_LIVE_URL 	= 'https://www.pesopay.com/b2c2/eng/dPayment/payComp.jsp';
	
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
	protected function _removeNull($array) {
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->_accessKey($val);
			}
			
			if($val == false || $val == NULL || empty($val)) {
				unset($array[$key]);
			}
			
		}
		
		return $array;
	}
	
	protected function _generateHash($amount, $orderRef) { 
		//merge parameters to generate hash
		$hash = $this->_merchantId . '|' . 
			$orderRef. '|' . 
			$this->_currencyCode . '|' . 
			$amount . '|' . 
			$this->_payType . '|' . 
			$this->_secureHashSecret;
		
		return sha1($hash);
	}
	
	/* Private Methods
	-------------------------------*/
}