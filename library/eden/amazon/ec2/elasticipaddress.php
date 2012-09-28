<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Elastic IP Addresses
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_ElasticIpAddress extends Eden_Amazon_Ec2_Base {
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
	 * For EC2 Elastic IP addresses: Acquires an Elastic IP address
	 * for use with your Amazon Web Services (AWS) account
	 *
	 * @return array
	 */
	public function allocateAddress() {
		
		$this->_query['Action'] = 'AllocateAddress';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * For EC2 Elastic IP addresses: Associates an Elastic IP address 
	 * with an instance (not running in a VPC). If the IP address is 
	 * currently assigned to another instance, the IP address is assigned 
	 * to the new instance.
	 *
	 * @return array
	 */
	public function associateAddress() {
		
		$this->_query['Action'] = 'AssociateAddress';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives information about Elastic IP addresses allocated to your account. 
	 * This includes both EC2 and VPC Elastic IP addressese.
	 *
	 * @return array
	 */
	public function describeAddresses() {
		
		$this->_query['Action'] = 'DescribeAddresses';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Disassociates an Elastic IP address from the instance it's assigned to.
	 *
	 * @return array
	 */
	public function disassociateAddress() {
		
		$this->_query['Action'] = 'DisassociateAddress';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Releases an Elastic IP address allocated to your account.
	 *
	 * @return array
	 */
	public function releaseAddress() {
		
		$this->_query['Action'] = 'ReleaseAddress';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Set to vpc to allocate the address to your VPC.
	 *
	 * @return array
	 */
	public function setDomain() {
		
		$this->_query['Domain'] = 'vpc';
		
		return $this;
	}
	
	/**
	 * The Elastic IP address to assign to the instance.
	 *
	 * @param string
	 * @return array
	 */
	public function setPublicIp($publicIp) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['PublicIp'] = $publicIp;
		
		return $this;
	}
	
	/**
	 * The instance to associate with the IP address.
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceId($instanceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InstanceId'] = $instanceId;
		
		return $this;
	}
	
	/**
	 * The allocation ID that AWS returned when you allocated the Elastic IP 
	 * address for use with Amazon VPC.
	 *
	 * @param string
	 * @return array
	 */
	public function setAllocationId($allocationId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['AllocationId'] = $allocationId;
		
		return $this;
	}
	
	/**
	 * The network interface ID to associate with an instance. Association 
	 * fails when specifying an instance ID unless exactly one interface is attached.
	 *
	 * @param string
	 * @return array
	 */
	public function setNetworkInterfaceId($networkInterfaceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		
		return $this;
	}
		
	/**
	 * The primary or secondary private IP address to associate with the Elastic 
	 * IP address. If no private IP address is specified, the Elastic IP address 
	 * is associated with the primary private IP address. This is only available 
	 * in Amazon VPC.
	 *
	 * @param string
	 * @return array
	 */
	public function setPrivateIpAddress($privateIpAddress) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['PrivateIpAddress'] = $privateIpAddress;
		
		return $this;
	}
	
	/**
	 * Allows an Elastic IP address that is already associated with another network 
	 * interface or instance to be re-associated with the specified instance or interface. 
	 * If the Elastic IP address is associated, and this option is not specified, the 
	 * operation fails. This is only available in Amazon VPC.
	 *
	 * @param boolean
	 * @return array
	 */
	public function setAllowReassociation($allowReassociation) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		
		$this->_query['AllowReassociation'] = $allowReassociation;
		
		return $this;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	