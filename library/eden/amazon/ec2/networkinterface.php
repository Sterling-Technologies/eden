<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Elastic Network Interfaces
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_NetworkInterface extends Eden_Amazon_Ec2_Base {
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
	 * Attaches a network interface to an instance.
	 *
	 * @param string The ID of the network interface to attach.
	 * @param string The ID of the instance to attach to the network interface.
	 * @param string The index of the device for the network interface attachment on the instance
	 * @return array
	 */
	public function attachNetworkInterface($networkInterfaceId, $instanceId, $deviceIndex) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action']				= 'AttachNetworkInterface';
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		$this->_query['InstanceId'] 		= $instanceId;
		$this->_query['DeviceIndex'] 		= $deviceIndex;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Detaches a network interface from an instance.
	 *
	 * @param string The ID of the attachment.
	 * @return array
	 */
	public function detachNetworkInterface($attachmentId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']			= 'DetachNetworkInterface';
		$this->_query['AttachmentId'] 	= $attachmentId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a network interface in the specified subnet. 
	 *
	 * @param string The ID of the subnet to associate with the network interface.
	 * @return array
	 */
	public function createNetworkInterface($subnetId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']		= 'CreateNetworkInterface';
		$this->_query['SubnetId'] 	= $subnetId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes the specified network interface. 
	 *
	 * @param string The ID of the network interface.
	 * @return array
	 */
	public function deleteNetworkInterface($networkInterfaceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']				= 'DeleteNetworkInterface';
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Provides information about one or more network interfaces.
	 *
	 * @param string The ID of the network interface.
	 * @return array
	 */
	public function describeNetworkInterfaces($networkInterfaceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']				= 'DescribeNetworkInterfaces';
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes a network interface attribute. 
	 * Only one attribute can be specified per call.
	 *
	 * @param string The ID of the network interface.
	 * @param string The attribute of the network interface. Valid values: description | groupSet | sourceDestCheck | attachment
	 * @return array
	 */
	public function describeNetworkInterfaceAttribute($networkInterfaceId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']				= 'DescribeNetworkInterfaceAttribute';
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		$this->_query['Attribute'] 			= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Resets a network interface attribute.
	 * Only one attribute can be specified per call.
	 *
	 * @param string The ID of the network interface.
	 * @param string The name of the attribute to reset; sourceDestCheck defaults to true.
	 * @return array
	 */
	public function resetNetworkInterfaceAttribute($networkInterfaceId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']				= 'ResetNetworkInterfaceAttribute';
		$this->_query['NetworkInterfaceId'] = $networkInterfaceId;
		$this->_query['Attribute'] 			= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Force a detachment
	 *
	 * @return array
	 */
	public function forceDetachment() {
		
		$this->_query['Force'] = true;
		
		return $this;
	}
	
	/**
	 * The primary private IP address of the network interface.
	 *
	 * @param string
	 * @return array
	 */
	public function setPrivateIpAddress($privateIpAddress) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['PrivateIpAddress	'] = $privateIpAddress;
		
		return $this;
	}
	
	/**
	 * The private IP address of the specified network interface. 
	 * This parameter can be used multiple times to specify explicit 
	 * private IP addresses for a network interface, but only one private 
	 * IP address can be designated as primary.
	 *
	 * @param string
	 * @return array
	 */
	public function setPrivateIpAddresses($privateIpAddresses) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['PrivateIpAddresses_PrivateIpAddress']
			[isset($this->_query['PrivateIpAddresses_PrivateIpAddress'])?
			count($this->_query['PrivateIpAddresses_PrivateIpAddress'])+1:1] = $privateIpAddresses;
		
		return $this;
	}
	
	/**
	 * Specifies whether the private IP address is the primary private IP address.
	 *
	 * @param boolean
	 * @return array
	 */
	public function setPrimaryPrivateIpAddress($primaryPrivateIpAddress) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		
		$this->_query['PrivateIpAddresses_Primary']
			[isset($this->_query['PrivateIpAddresses_Primary'])?
			count($this->_query['PrivateIpAddresses_Primary'])+1:1] = $primaryPrivateIpAddress;
		
		return $this;
	}
	
	/**
	 * The number of secondary private IP addresses to assign to a network interface. 
	 * When you specify a number of secondary IP addresses, AWS automatically assigns 
	 * these IP addresses within the subnet’s range.
	 *
	 * @param integer
	 * @return array
	 */
	public function setSecondaryPrivateIpAddressCount($secondaryPrivateIpAddressCount) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');
		
		$this->_query['SecondaryPrivateIpAddressCount'] = $secondaryPrivateIpAddressCount;
		
		return $this;
	}
	
	/**
	 * The description of the network interface.
	 *
	 * @param string
	 * @return array
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Description'] = $description;
		
		return $this;
	}
	
	/**
	 * A list of group IDs for use by the network interface.
	 *
	 * @param string
	 * @return array
	 */
	public function setSecurityGroupId($securityGroupId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SecurityGroupId_']
			[isset($this->_query['SecurityGroupId_'])?
			count($this->_query['SecurityGroupId_'])+1:1] = $securityGroupId;
		
		return $this;
	}
	
	/**
	 * Network interface ID
	 *
	 * @param string
	 * @return array
	 */
	public function setNetworkInterfaceId($networkInterfaceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterfaceId_']
			[isset($this->_query['NetworkInterfaceId_'])?
			count($this->_query['NetworkInterfaceId_'])+1:1] = $networkInterfaceId;
		
		return $this;
	} 
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	