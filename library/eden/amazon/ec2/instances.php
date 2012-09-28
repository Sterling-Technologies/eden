<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Instances
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Instances extends Eden_Amazon_Ec2_Base {
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
	 * Describes the specified attribute of the specified instance
	 *
	 * @param string The ID of the instance.
	 * @param string The instance attribute.
	 * @return array
	 */
	public function describeInstanceAttribute($instanceId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']		= 'DescribeInstanceAttribute';
		$this->_query['InstanceId'] = $instanceId;
		$this->_query['Attribute'] 	= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns information about instances that you own.
	 *
	 * @return array
	 */
	public function describeInstances() {
		
		$this->_query['Action'] = 'DescribeInstances';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes the status of an Amazon EC2 instance including any scheduled events for an instance
	 *
	 * @return array
	 */
	public function describeInstanceStatus() {
		
		$this->_query['Action'] = 'DescribeInstanceStatus';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Requests a reboot of one or more instances. This operation is asynchronous; 
	 * it only queues a request to reboot the specified instance(s). The operation 
	 * will succeed if the instances are valid and belong to you. Requests to reboot 
	 * terminated instances are ignored.
	 *
	 * @return array
	 */
	public function rebootInstances() {
		
		$this->_query['Action'] = 'RebootInstances';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Requests a reboot of one or more instances. This operation is asynchronous; 
	 * it only queues a request to reboot the specified instance(s). The operation 
	 * will succeed if the instances are valid and belong to you. Requests to reboot 
	 * terminated instances are ignored.
	 *
	 * @param string
	 * @return array
	 */
	public function reportInstanceStatus() {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] = 'ReportInstanceStatus';
		$this->_query['Status'] = $status;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Resets an attribute of an instance to its default value. To reset the kernel or 
	 * RAM disk, the instance must be in a stopped state. To reset the SourceDestCheck, 
	 * the instance can be either running or stopped.
	 *
	 * @param string The ID of the instance.
	 * @param string The attribute to reset.Valid values: kernel | ramdisk | sourceDestCheck
	 * @return array
	 */
	public function resetInstanceAttribute($instanceId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 	= 'ResetInstanceAttribute';
		$this->_query['InstanceId'] = $instanceId;
		$this->_query['Attribute'] 	= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Resets an attribute of an instance to its default value. To reset the kernel or 
	 * RAM disk, the instance must be in a stopped state. To reset the SourceDestCheck, 
	 * the instance can be either running or stopped.
	 *
	 * @param string The ID of the AMI.
	 * @param integer The minimum number of instances to launch
	 * @param integer The maximum number of instances to launch
	 * @return array
	 */
	public function runInstances($instanceId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(1, 'int')		//argument 1 must be a integer
			->argument(2, 'int');		//argument 2 must be a integer
		
		$this->_query['Action'] 	= 'RunInstances';
		$this->_query['ImageId'] 	= $imageId;
		$this->_query['MinCount'] 	= $minCount;
		$this->_query['MaxCount'] 	= $maxCount;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Starts an Amazon EBS-backed AMI that you've previously stopped.
	 *
	 * @return array
	 */
	public function startInstances() {
		
		$this->_query['Action'] = 'StartInstances';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * One or more instance IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceId($instanceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InstanceId_']
			[isset($this->_query['InstanceId_'])?
			count($this->_query['InstanceId_'])+1:1] = $instanceId;
		
		return $this;
	}
	
	/**
	 * A reason code that describes a specific instance's health state
	 *
	 * @param string
	 * @return array
	 */
	public function setReasonCodes($reasonCodes) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ReasonCodes_']
			[isset($this->_query['ReasonCodes_'])?
			count($this->_query['ReasonCodes_'])+1:1] = $reasonCodes;
		
		return $this;
	}
	
	/**
	 * The status of all instances Valid values: ok | impaired
	 *
	 * @param string
	 * @return array
	 */
	public function setStatus($status) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Status'] = $status;
		
		return $this;
	}
	
	/**
	 * The time at which the reported instance health state began.
	 *
	 * @param string
	 * @return array
	 */
	public function setStartTime($startTime) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['StartTime'] = $startTime;
		
		return $this;
	}
	
	/**
	 * The time at which the reported instance health state ended.
	 *
	 * @param string
	 * @return array
	 */
	public function setEndTime($endTime) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['EndTime'] = $endTime;
		
		return $this;
	}
	
	/**
	 * The time at which the reported instance health state ended.
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
	 * The name of the key pair to use.
	 *
	 * @param string
	 * @return array
	 */
	public function setKeyName($keyName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['KeyName'] = $keyName;
		
		return $this;
	}
	
	/**
	 * One or more security group IDs.
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
	 * One or more security group IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setSecurityGroup($securityGroup) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SecurityGroup_']
			[isset($this->_query['SecurityGroup_'])?
			count($this->_query['SecurityGroup_'])+1:1] = $securityGroup;
		
		return $this;
	}
	
	/**
	 * The Base64-encoded MIME user data to be made available to 
	 * the instance(s) in this reservation.
	 *
	 * @param string
	 * @return array
	 */
	public function setUserData($userData) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['UserData'] = base64_encode($userData);
		
		return $this;
	}
	
	/**
	 * The instance type.
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceType($InstanceType) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InstanceType'] = $instanceType;
		
		return $this;
	}
	
	/**
	 * The Availability Zone to launch the instance into.
	 *
	 * @param string
	 * @return array
	 */
	public function setAvailabilityZone($availabilityZone) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Placement.AvailabilityZone'] = $availabilityZone;
		
		return $this;
	}
	
	/**
	 * The name of an existing placement group you want to launch the instance 
	 * into (for cluster instances).
	 *
	 * @param string
	 * @return array
	 */
	public function setGroupName($groupName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Placement.GroupName'] = $groupName;
		
		return $this;
	}
	
	/**
	 * The tenancy of the instance. An instance with a tenancy of dedicated runs on single-tenant 
	 * hardware and can only be launched into a VPC.
	 *
	 * @param string
	 * @return array
	 */
	public function setTenancy($tenancy) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Placement.Tenancy'] = $tenancy;
		
		return $this;
	}
	
	/**
	 * The ID of the kernel with which to launch the instance.
	 *
	 * @param string
	 * @return array
	 */
	public function setKernelId($kernelId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['KernelId'] = $kernelId;
		
		return $this;
	}
	
	/**
	 * The ID of the RAM disk. Some kernels require additional drivers at launch
	 *
	 * @param string
	 * @return array
	 */
	public function setRamdiskId($ramdiskId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['RamdiskId'] = $ramdiskId;
		
		return $this;
	}
	
	/**
	 * The device name exposed to the instance
	 *
	 * @param string
	 * @return array
	 */
	public function setDeviceName($deviceName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['BlockDeviceMapping_DeviceName']
			[isset($this->_query['BlockDeviceMapping_DeviceName'])?
			count($this->_query['BlockDeviceMapping_DeviceName'])+1:1] = $deviceName;
		
		return $this;
	}
	
	/**
	 * Suppresses the device mapping.
	 *
	 * @param string
	 * @return array
	 */
	public function setNoDevice($noDevice) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['BlockDeviceMapping_NoDevice']
			[isset($this->_query['BlockDeviceMapping_NoDevice'])?
			count($this->_query['BlockDeviceMapping_NoDevice'])+1:1] = $noDevice;
		
		return $this;
	}
	
	/**
	 * The virtual device name, ephemeral[0..3]. The number of instance store 
	 * volumes depends on the instance type.
	 *
	 * @param string
	 * @return array
	 */
	public function setVirtualName($virtualName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['BlockDeviceMapping_VirtualName']
			[isset($this->_query['BlockDeviceMapping_VirtualName'])?
			count($this->_query['BlockDeviceMapping_VirtualName'])+1:1] = $virtualName;
		
		return $this;
	}
	
	/**
	 * Enables monitoring for the instance.
	 *
	 * @return array
	 */
	public function enableMonitoring() {
		
		$this->_query['Monitoring.Enabled'] = true;
		
		return $this;
	}
	
	/**
	 * Whether you can terminate the instance using the EC2 API
	 *
	 * @return array
	 */
	public function disableApiTermination() {
		
		$this->_query['DisableApiTermination'] = true;
		
		return $this;
	}
	
	/**
	 * If you're using Amazon Virtual Private Cloud, this specifies the ID
	 * of the subnet you want to launch the instance into.
	 *
	 * @param string
	 * @return array
	 */
	public function setSubnetId($subnetId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SubnetId'] = $subnetId;
		
		return $this;
	}
	
	/**
	 * Whether the instance stops or terminates on instance-initiated shutdown.
	 *
	 * @return array
	 */
	public function terminateInstance() {
		
		$this->_query['InstanceInitiatedShutdownBehavior'] = 'terminate	';
		
		return $this;
	}
	
	/**
	 * If you're using Amazon Virtual Private Cloud, you can optionally use this parameter to 
	 * assign the instance a specific available IP address from the subnet (e.g., 10.0.0.25) 
	 * as the primary IP address.
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
	 * If you're using Amazon Virtual Private Cloud, you can optionally use this parameter to 
	 * assign the instance a specific available IP address from the subnet (e.g., 10.0.0.25) 
	 * as the primary IP address.
	 *
	 * @param string
	 * @return array
	 */
	public function setClientToken($clientToken) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ClientToken'] = $clientToken;
		
		return $this;
	}
	
	/**
	 * Attaches an existing interface to a single instance. 
	 *
	 * @param string
	 * @return array
	 */
	public function setNetworkInterfaceId($networkInterfaceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterface_NetworkInterfaceId']
			[isset($this->_query['NetworkInterface_NetworkInterfaceId'])?
			count($this->_query['NetworkInterface_NetworkInterfaceId'])+1:1] = $networkInterfaceId;
		
		return $this;
	}
	
	/**
	 * Attaches an existing interface to a single instance. 
	 *
	 * @param string
	 * @return array
	 */
	public function setDeviceIndex($deviceIndex) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterface_DeviceIndex']
			[isset($this->_query['NetworkInterface_DeviceIndex'])?
			count($this->_query['NetworkInterface_DeviceIndex'])+1:1] = $deviceIndex;
		
		return $this;
	}
	
	/**
	 * Applies only when creating new network interfaces.
	 *
	 * @param string
	 * @return array
	 */
	public function setSubnetIds($subnetId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterface_SubnetId']
			[isset($this->_query['NetworkInterface_SubnetId'])?
			count($this->_query['NetworkInterface_SubnetId'])+1:1] = $subnetId;
		
		return $this;
	}
	
	/**
	 * Applies only when creating new network interfaces.
	 *
	 * @param string
	 * @return array
	 */
	public function setDescriptions($description) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkInterface_Description']
			[isset($this->_query['NetworkInterface_Description'])?
			count($this->_query['NetworkInterface_Description'])+1:1] = $description;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	