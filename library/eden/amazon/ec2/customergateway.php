<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Customer Gateways (Amazon VPC)
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_CustomerGateway extends Eden_Amazon_Ec2_Base {
	/* Constants
	-------------------------------*/
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
	 * Provides information to AWS about your VPN customer gateway device. 
	 * The customer gateway is the appliance at your end of the VPN connection 
	 * (compared to the virtual private gateway, which is the device at the AWS
	 * side of the VPN connection).
	 *
	 * @param string The type of VPN connection this customer gateway supports.
	 * @param string The Internet-routable IP address for the customer gateway's 
	 * outside interface. The address must be static.
	 * @param string The customer gateway's Border Gateway Protocol (BGP) 
	 * Autonomous System Number (ASN).
	 * @return array
	 */
	public function createCustomerGateway($type, $ipAddress, $bgpAsn) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 	= 'CreateCustomerGateway';
		$this->_query['Type']		= $type;
		$this->_query['IpAddress']	= $ipAddress;
		$this->_query['BgpAsn']		= $bgpAsn;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Deletes a VPN customer gateway. You must delete the VPN connection before 
	 * deleting the customer gateway.
	 *
	 * @param string The ID of the request.
	 * @return array
	 */
	public function deleteCustomerGateway($customerGatewayId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 			= 'DeleteCustomerGateway';
		$this->_query['CustomerGatewayId']	= $customerGatewayId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Gives you information about your VPN customer gateways. You can filter 
	 * the results to return information only about customer gateways that match 
	 * criteria you specify. For example, you could get information only about gateways 
	 * whose state is pending or available. The customer gateway must match at least 
	 * one of the specified values for it to be included in the results.
	 *
	 * @return array
	 */
	public function describeCustomerGateway() {
		
		$this->_query['Action'] = 'DescribeCustomerGateways';

		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * A customer gateway ID. You can specify more than one in the request.
	 *
	 * @param string
	 * @return array
	 */
	public function setCustomerGatewayId($customerGatewayId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['CustomerGatewayId']
			[isset($this->_query['CustomerGatewayId'])?
			count($this->_query['CustomerGatewayId'])+1:1] = $customerGatewayId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	