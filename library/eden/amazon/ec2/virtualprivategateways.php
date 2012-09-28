<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Virtual Private Gateways (Amazon VPC)
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_VirtualPrivateGateways extends Eden_Amazon_Ec2_Base {
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
	 * Attaches a virtual private gateway to a VPC
	 *
	 * @param string The ID of the virtual private gateway.
	 * @param string The ID of the VPC.
	 * @return array
	 */
	public function attachVpnGateway($vpnGatewayId, $vpcId) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 		= 'AttachVpnGateway';
		$this->_query['VpnGatewayId'] 	= $vpnGatewayId;
		$this->_query['VpcId'] 			= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Attaches a virtual private gateway to a VPC
	 *
	 * @param string The type of VPN connection this 
	 * virtual private gateway supports.
	 * @return array
	 */
	public function createVpnGateway($type) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] = 'CreateVpnGateway';
		$this->_query['Type'] 	= $type;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a virtual private gateway. Use this when you want to delete a VPC 
	 * and all its associated components because you no longer need them. We 
	 * recommend that before you delete a virtual private gateway, you detach 
	 * it from the VPC and delete the VPN connection.
	 *
	 * @param string The ID of the virtual private gateway
	 * virtual private gateway supports.
	 * @return array
	 */
	public function deleteVpnGateway($vpnGatewayId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] = 'DeleteVpnGateway';
		$this->_query['VpnGatewayId'] 	= $vpnGatewayId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives you information about your virtual private gateways.
	 *
	 * @return array
	 */
	public function describeVpnGateways($vpnGatewayId) {	
		
		$this->_query['Action'] = 'DescribeVpnGateways';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Detaches a virtual private gateway from a VPC. 
	 *
	 * @param string The ID of the virtual private gateway.
	 * @param string The ID of the VPC.
	 * @return array
	 */
	public function detachVpnGateway($vpnGatewayId, $vpcId) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 		= 'DetachVpnGateway';
		$this->_query['VpnGatewayId'] 	= $vpnGatewayId;
		$this->_query['VpcId'] 			= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * A virtual private gateway ID
	 *
	 * @param string
	 * @return array
	 */
	public function setVpnGatewayId($vpnGatewayId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['VpnGatewayId_']
			[isset($this->_query['VpnGatewayId_'])?
			count($this->_query['VpnGatewayId_'])+1:1] = $vpnGatewayId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	