<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 VPN Connections (Amazon VPC)
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_VpnConnections extends Eden_Amazon_Ec2_Base {
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
	 * Creates a VPN connection between an existing virtual private gateway 
	 * and a VPN customer gateway.
	 *
	 * @param string The type of VPN connection.
	 * @param string The ID of the customer gateway.
	 * @param string The ID of the virtual private gateway.
	 * @return array
	 */
	public function createVpnConnection($type, $customerGatewayId, $vpnGatewayId) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 			= 'CreateVpnConnection';
		$this->_query['Type'] 				= $type;
		$this->_query['CustomerGatewayId'] 	= $customerGatewayId;
		$this->_query['VpnGatewayId'] 		= $vpnGatewayId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a VPN connection. Use this if you want to delete a VPC and all its associated components
	 *
	 * @param string The ID of the VPN connection
	 * @return array
	 */
	public function deleteVpnConnection($vpnConnectionId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 			= 'DeleteVpnConnection';
		$this->_query['VpnConnectionId'] 	= $vpnConnectionId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives you information about your VPN connections.
	 *
	 * @return array
	 */
	public function describeVpnConnections() {	
		
		$this->_query['Action'] = 'DescribeVpnConnections';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Indicates whether or not the VPN connection requires static routes. If you 
	 * are creating a VPN connection for a device that does not support BGP, you 
	 * must specify this value as true.
	 *
	 * @param boolean
	 * @return array
	 */
	public function setStaticRoutesOnly($options) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		
		$this->_query['Options.StaticRoutesOnly'] = $options;
		
		return $this;
	}
	
	/**
	 * A VPN connection ID. You can specify more than one in the request.
	 *
	 * @param string
	 * @return array
	 */
	public function setVpnConnectionId($vpnConnectionId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['VpnConnectionId_']
			[isset($this->_query['VpnConnectionId_'])?
			count($this->_query['VpnConnectionId_'])+1:1] = $vpnConnectionId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	