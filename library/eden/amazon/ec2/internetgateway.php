<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Internet Gateways (Amazon VPC)
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_InternetGateway extends Eden_Amazon_Ec2_Base {
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
	 * Attaches an Internet gateway to a VPC, enabling connectivity between the 
	 * Internet and the VPC
	 *
	 * @param string The ID of the Internet gateway
	 * @param string The ID of the VPC.
	 * @return array
	 */
	public function attachInternetGateway($internetGatewayId, $vpcId) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']				= 'AttachInternetGateway';
		$this->_query['InternetGatewayId'] 	= $internetGatewayId;
		$this->_query['VpcId'] 				= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a new Internet gateway for use with a VPC. After creating the 
	 * Internet gateway, you attach it to a VPC using AttachInternetGateway
	 *
	 * @return array
	 */
	public function createInternetGateway() {
		
		$this->_query['Action'] = 'CreateInternetGateway';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	 
	/**
	 * Deletes an Internet gateway from your AWS account. The gateway must not be 
	 * attached to a VPC.
	 *
	 * @param string The ID of the Internet gateway
	 * @return array
	 */
	public function deleteInternetGateway($internetGatewayId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action']				= 'DeleteInternetGateway';
		$this->_query['InternetGatewayId']	= $internetGatewayId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives you information about your Internet gateways.
	 *
	 * @return array
	 */
	public function describeInternetGateways() {
		
		$this->_query['Action'] = 'DescribeInternetGateways';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Detaches an Internet gateway from a VPC, disabling connectivity between 
	 * the Internet and the VPC. The VPC must not contain any running instances 
	 * with Elastic IP addresses.
	 *
	 * @param string The ID of the Internet gateway
	 * @param string The ID of the VPC.
	 * @return array
	 */
	public function detachInternetGateway($vpcId, $internetGatewayId) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 			= 'DetachInternetGateway';
		$this->_query['VpcId']				= $vpcId;	
		$this->_query['InternetGatewayId']	= $internetGatewayId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The name of a filter. 
	 *
	 * @param string
	 * @return array
	 */
	public function setInternetGatewayId($internetGatewayId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InternetGatewayId_']
			[isset($this->_query['InternetGatewayId_'])?
			count($this->_query['InternetGatewayId_'])+1:1] = $internetGatewayId;
		
		return $this;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	