<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon ec2 factory class
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Amazon_Ec2 extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_accessKey		= NULL;
	protected $_accessSecret	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($accessKey, $accessSecret) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
		
		$this->_accessKey		= $accessKey;
		$this->_accessSecret	= $accessSecret;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Factory method for amazon AMI
	 *
	 * @return Eden_Amazon_Ec2_Ami
	 */
	public function ami() {
		return Eden_Amazon_Ec2_Ami::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon customer gateway
	 *
	 * @return Eden_Amazon_Ec2_CustomerGateway
	 */
	public function customerGateway() {
		return Eden_Amazon_Ec2_CustomerGateway::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon devpay
	 *
	 * @return Eden_Amazon_Ec2_Devpay
	 */
	public function devPay() {
		return Eden_Amazon_Ec2_Devpay::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon dhcp
	 *
	 * @return Eden_Amazon_Ec2_Dhcp
	 */
	public function dhcp() {
		return Eden_Amazon_Ec2_Dhcp::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Elastic Book Store
	 *
	 * @return Eden_Amazon_Ec2_ElasticBookStore
	 */
	public function elasticBookStore() {
		return Eden_Amazon_Ec2_ElasticBookStore::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Elastic IP address
	 *
	 * @return Eden_Amazon_Ec2_ElasticIpAddress
	 */
	public function elasticIpAddress() {
		return Eden_Amazon_Ec2_ElasticIpAddress::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon General
	 *
	 * @return Eden_Amazon_Ec2_General
	 */
	public function general() {
		return Eden_Amazon_Ec2_General::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Instances
	 *
	 * @return Eden_Amazon_Ec2_Instances
	 */
	public function instances() {
		return Eden_Amazon_Ec2_Instances::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Internet Gateway
	 *
	 * @return Eden_Amazon_Ec2_InternetGateway
	 */
	public function internetGateWay() {
		return Eden_Amazon_Ec2_InternetGateway::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Keypairs
	 *
	 * @return Eden_Amazon_Ec2_KeyPairs
	 */
	public function keyPairs() {
		return Eden_Amazon_Ec2_KeyPairs::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Monitoring
	 *
	 * @return Eden_Amazon_Ec2_Monitoring
	 */
	public function monitoring() {
		return Eden_Amazon_Ec2_Monitoring::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Network ACL
	 *
	 * @return Eden_Amazon_Ec2_NetworkAcl
	 */
	public function networkAcl() {
		return Eden_Amazon_Ec2_NetworkAcl::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Network Interface
	 *
	 * @return Eden_Amazon_Ec2_NetworkInterface
	 */
	public function networkInterface() {
		return Eden_Amazon_Ec2_NetworkInterface::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Placement Groups
	 *
	 * @return Eden_Amazon_Ec2_PlacementGroups
	 */
	public function placementGroups() {
		return Eden_Amazon_Ec2_PlacementGroups::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Reserved Instances
	 *
	 * @return Eden_Amazon_Ec2_PlacementGroups
	 */
	public function reservedInstances() {
		return Eden_Amazon_Ec2_ReservedInstances::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Route Tables
	 *
	 * @return Eden_Amazon_Ec2_RouteTables
	 */
	public function routeTables() {
		return Eden_Amazon_Ec2_RouteTables::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Security Groups
	 *
	 * @return Eden_Amazon_Ec2_SecurityGroups
	 */
	public function securityGroups() {
		return Eden_Amazon_Ec2_SecurityGroups::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Spot Instances
	 *
	 * @return Eden_Amazon_Ec2_SpotInstances
	 */
	public function spotInstances() {
		return Eden_Amazon_Ec2_SpotInstances::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Subnets
	 *
	 * @return Eden_Amazon_Ec2_Subnets
	 */
	public function subnets() {
		return Eden_Amazon_Ec2_Subnets::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon tags
	 *
	 * @return Eden_Amazon_Ec2_Tags
	 */
	public function tags() {
		return Eden_Amazon_Ec2_Tags::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon virtual private gateway
	 *
	 * @return Eden_Amazon_Ec2_VirtualPrivateGateway
	 */
	public function virtualPrivateGateway() {
		return Eden_Amazon_Ec2_VirtualPrivateGateway::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon vm export
	 *
	 * @return Eden_Amazon_Ec2_VmExport
	 */
	public function vmExport() {
		return Eden_Amazon_Ec2_VmExport::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon vm import
	 *
	 * @return Eden_Amazon_Ec2_VmImport
	 */
	public function vmImport() {
		return Eden_Amazon_Ec2_VmImport::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon VPN Connections
	 *
	 * @return Eden_Amazon_Ec2_VpnConnections
	 */
	public function vpnConnections() {
		return Eden_Amazon_Ec2_VpnConnections::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon VPC
	 *
	 * @return Eden_Amazon_Ec2_Vpc
	 */
	public function vpc() {
		return Eden_Amazon_Ec2_Vpc::i($this->_accessKey, $this->_accessSecret);
	}
	
	/**
	 * Factory method for amazon Windows
	 *
	 * @return Eden_Amazon_Ec2_Windows
	 */
	public function windows() {
		return Eden_Amazon_Ec2_Windows::i($this->_accessKey, $this->_accessSecret);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
