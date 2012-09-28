<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 DevPay
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Devpay extends Eden_Amazon_Ec2_Base {
	/* Constants
	-------------------------------*/
	const CONFIRM_PRODUCT_INSTACE = 'ConfirmProductInstance';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
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
	 * Determines whether a product code is associated with an instance. 
	 * This action can only be used by the owner of the product code. 
	 * It is useful when a product code owner needs to verify whether 
	 * another EC2 user’s instance is eligible for support.
	 *
	 * @param string The product code
	 * @param string The instance.
	 * @return array
	 */
	public function confirmProductInstance($productCode, $instanceId) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$query = array(
			'Action'		=> self::CONFIRM_PRODUCT_INSTACE,
			'ProductCode' 	=> $productCode,
			'InstanceId'	=> $instanceId);
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $query);		
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	