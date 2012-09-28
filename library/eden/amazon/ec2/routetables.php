<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Route Tables (Amazon VPC)
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_RouteTables extends Eden_Amazon_Ec2_Base {
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
	 * Associates a subnet with a route table. The subnet and route table must
	 * be in the same VPC
	 *
	 * @param string The ID of the route table
	 * @param string The ID of the subnet.
	 * @return array
	 */
	public function associateRouteTable($routeTableId, $subnetId) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 		= 'AssociateRouteTable';
		$this->_query['RouteTableId'] 	= $routeTableId;
		$this->_query['SubnetId'] 		= $subnetId;	
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a route in a route table within a VPC. The route's target 
	 * can be either a gateway attached to the VPC or a NAT instance in the VPC.
	 *
	 * @param string The ID of the route table
	 * @param string The CIDR address block used for the destination match
	 * @return array
	 */
	public function createRoute($routeTableId, $destinationCidrBlock) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 				= 'CreateRoute';
		$this->_query['RouteTableId'] 			= $routeTableId;
		$this->_query['DestinationCidrBlock'] 	= $destinationCidrBlock;	
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a route table within a VPC. After you create a new route table, you 
	 * can add routes and associate the table with a subnet
	 *
	 * @param string The ID of the VPC
	 * @return array
	 */
	public function createRouteTable($vpcId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action']	= 'CreateRouteTable';
		$this->_query['VpcId'] 	= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a route from a route table in a VPC
	 *
	 * @param string The ID of the route table
	 * @param string The CIDR address block used for the destination match
	 * @return array
	 */
	public function deleteRoute($routeTableId, $destinationCidrBlock) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 				= 'DeleteRoute';
		$this->_query['RouteTableId'] 			= $routeTableId;
		$this->_query['DestinationCidrBlock'] 	= $destinationCidrBlock;	
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a route table from a VPC. The route table must not be associated 
	 * with a subnet. You can't delete the main route table
	 *
	 * @param string The ID of the route table
	 * @return array
	 */
	public function deleteRouteTable($routeTableId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action']			= 'DeleteRouteTable';
		$this->_query['RouteTableId'] 	= $routeTableId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives you information about your route tables.
	 *
	 * @return array
	 */
	public function describeRouteTables() {
		
		$this->_query['Action']	= 'DescribeRouteTables';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Disassociates a subnet from a route table.
	 *
	 * @param string The association ID representing the current association 
	 * between the route table and subnet
	 * @return array
	 */
	public function disassociateRouteTable($associationId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action']			= 'DisassociateRouteTable';
		$this->_query['AssociationId'] 	= $associationId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	
	/**
	 * Replaces an existing route within a route table in a VPC
	 *
	 * @param string The ID of the route table.
	 * @param string The CIDR address block used for the destination match. 
	 * For example: 0.0.0.0/0. The value you provide must match the CIDR of 
	 * an existing route in the table.
	 * @return array
	 */
	public function replaceRoute($routeTableId, $destinationCidrBlock) {	
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']					= 'ReplaceRoute';
		$this->_query['RouteTableId'] 			= $routeTableId;
		$this->_query['DestinationCidrBlock'] 	= $destinationCidrBlock;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Replaces an existing route within a route table in a VPC
	 *
	 * @param string The ID of the route table.
	 * @param string The ID representing the current association between the original 
	 * route table and the subnet. 
	 * @return array
	 */
	public function replaceRouteTableAssociation($routeTableId, $associationId) {	
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']			= 'ReplaceRouteTableAssociation';
		$this->_query['RouteTableId'] 	= $routeTableId;
		$this->_query['AssociationId'] 	= $associationId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The ID of a gateway attached to your VPC.
	 *
	 * @param string
	 * @return array
	 */
	public function setGatewayId($gatewayId) {
		//argument 1 must be a String
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['GatewayId'] = $gatewayId;
		
		return $this;
	}
	
	/**
	 * The ID of a NAT instance in your VPC.
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceId($instanceId) {
		//argument 1 must be a String
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InstanceId'] = $instanceId;
		
		return $this;
	}
	
	/**
	 * Allows the routing of network interface IDs. Exactly one interface must 
	 * be attached when specifying an instance ID or it fails.
	 *
	 * @param string
	 * @return array
	 */
	public function setNetworkInterfaceId($networkInterfaceId) {
		//argument 1 must be a String
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		
		return $this;
	}
	
	/**
	 * Route table ID
	 *
	 * @param string
	 * @return array
	 */
	public function setRouteTableId($routeTableId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['RouteTableId_']
			[isset($this->_query['RouteTableId_'])?
			count($this->_query['RouteTableId_'])+1:1] = $routeTableId;
		
		return $this;
	}
	
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	