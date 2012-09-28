
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
class Eden_Amazon_Ec2_Ami extends Eden_Amazon_Ec2_Base {
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
	 * Registers a new AMI with Amazon EC2. When you're creating an AMI, this is the final
	 * step you must complete before you can launch an instance from the AMI
	 *
	 * @param string A name for your AMI.
	 * @param string The instance.
	 * @return array
	 */
	public function registerImage($name) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] = 'RegisterImage';
		$this->_query['Name']	= $name;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Creates an Amazon EBS-backed AMI from an Amazon EBS-backed instance that is 
	 * either running or stopped. For more information about Amazon EBS-backed AMIs
	 *
	 * @param string Image name
	 * @param string The instance.
	 * @return array
	 */
	public function createImage($imageName, $instanceId) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$this->_query['Action'] 	= 'CreateImage';
		$this->_query['Name']		= $imageName;
		$this->_query['InstanceId'] = $instanceId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);		
	}
	
	/**
	 * Deregisters the specified AMI. Once deregistered, the AMI cannot be used to launch new instances.
	 *
	 * @param string Image ID
	 * @return array
	 */
	public function deregisterImage($imageId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
			
		$this->_query['Action']		= 'DeregisterImage';
		$this->_query['ImageId'] 	= $ImageId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);		
	}
	
	/**
	 * Gets information about an attribute of an AMI.
	 *
	 * @param string Image ID
	 * @param string The AMI attribute Valid values: description, kernel, ramdisk, launchPermission, 
	 * productCodes, blockDeviceMapping 
	 * @return array
	 */
	public function describeImageAttribute($imageId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string	
		
		//if the input value is not allowed
		if(!in_array($attribute, array('description', 'kernel', 'ramdisk', 'launchPermission', 'productCodes', 'blockDeviceMapping'))) {
			//throw error
			Eden_Amazon_Error::i()
				->setMessage(Eden_Amazon_Error::INVALID_ATTRIBUTES) 
				->addVariable($attribute)
				->trigger();
		}
		
		$this->_query['Action']		= 'DescribeImageAttribute';
		$this->_query['ImageId']	= $imageId;
		$this->_query['Attribute']	= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);		
	}
	
	/**
	 * Describes the images (AMIs, AKIs, and ARIs) available to you. 
	 * Images available to you include public images, private images 
	 * that you own, and private images owned by other AWS accounts 
	 * but for which you have explicit launch permissions.
	 * 
	 * @return array
	 */
	public function describeImages() {
		
		$this->_query['Action'] = 'DescribeImages';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);		
	}
	
	/**
	 * Modifies an attribute of an AMI.
	 * 
	 * @param string
	 * @return array
	 */
	public function modifyImageAttribute() {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']		= 'ModifyImageAttribute';
		$this->_query['ImageId'] 	= $imageId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);		
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
	 * Suppresses a device mapping.
	 *
	 * @param boolean
	 * @return array
	 */
	public function suppressDevice($supressDevice) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		
		$this->_query['BlockDeviceMapping_NoDevice']
			[isset($this->_query['BlockDeviceMapping_NoDevice'])?
			count($this->_query['BlockDeviceMapping_NoDevice'])+1:1] = $supressDevice;
		
		return $this;
	}
	
	/**
	 * The name of the virtual device, ephemeral[0..3]. 
	 * The number of instance store volumes depends on the instance type.
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
	 * The ID of the snapshot.
	 *
	 * @param string
	 * @return array
	 */
	public function setSnapshotId($snapshotId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['BlockDeviceMapping_Ebs.SnapshotId']
			[isset($this->_query['BlockDeviceMapping_Ebs.SnapshotId'])?
			count($this->_query['BlockDeviceMapping_Ebs.SnapshotId'])+1:1] = $snapshotId;
		
		return $this;
	}
	
	/**
	 * The size of the volume, in GiBs.
	 *
	 * @param string|integer
	 * @return array
	 */
	public function setVolumeSize($volumeSize) {
		//argument 1 must be a string or integer
		Eden_Amazon_Error::i()->argument(1, 'string', 'int');
		
		$this->_query['BlockDeviceMapping_Ebs.VolumeSize']
			[isset($this->_query['BlockDeviceMapping_Ebs.VolumeSize'])?
			count($this->_query['BlockDeviceMapping_Ebs.VolumeSize'])+1:1] = $volumeSize;
		
		return $this;
	}
	
	/**
	 * Whether the volume is deleted on instance termination.
	 *
	 * @param boolean
	 * @return array
	 */
	public function deleteOnTermination($deleteOnTermination) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');
		
		$this->_query['BlockDeviceMapping_Ebs.DeleteOnTermination']
			[isset($this->_query['BlockDeviceMapping_Ebs.DeleteOnTermination'])?
			count($this->_query['BlockDeviceMapping_Ebs.DeleteOnTermination'])+1:1] = $deleteOnTermination;
		
		return $this;
	}
	
	/**
	 * The volume type. Valid values: standard | io1
	 *
	 * @param string
	 * @return array
	 */
	public function setVolumeType($volumeType) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['BlockDeviceMapping_Ebs.VolumeType']
			[isset($this->_query['BlockDeviceMapping_Ebs.VolumeType'])?
			count($this->_query['BlockDeviceMapping_Ebs.VolumeType'])+1:1] = $volumeType;
		
		return $this;
	}
	
	/**
	 * The number of I/O operations per second (IOPS) that the volume supports.
	 *
	 * @param string|integer
	 * @return array
	 */
	public function setIops($iops) {
		//argument 1 must be a string or integer
		Eden_Amazon_Error::i()->argument(1, 'string', 'integer');
		
		$this->_query['BlockDeviceMapping_Ebs.Iops']
			[isset($this->_query['BlockDeviceMapping_Ebs.Iops'])?
			count($this->_query['BlockDeviceMapping_Ebs.Iops'])+1:1] = $iops;
		
		return $this;
	}
	
	/**
	 * The AMIs for which the specified user ID has explicit launch permissions.
	 * The user ID can be an AWS account ID, self to return AMIs for which the 
	 * sender of the request has explicit launch permissions, or all to return 
	 * AMIs with public launch permissions.
	 *
	 * @param string
	 * @return array
	 */
	public function setPermission($permission) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ExecutableBy']
			[isset($this->_query['ExecutableBy'])?
			count($this->_query['ExecutableBy'])+1:1] = $permission;
		
		return $this;
	}
	
	/**
	 * One or more AMI IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setImageId($imageId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ImageId']
			[isset($this->_query['ImageId'])?
			count($this->_query['ImageId'])+1:1] = $imageId;
		
		return $this;
	}
	
	/**
	 * The AMIs owned by the specified owner. Multiple owner 
	 * values can be specified. The IDs amazon, aws-marketplace,
	 * and self can be used to include AMIs owned by Amazon, AWS 
	 * Marketplace, or AMIs owned by you, respectively.
	 *
	 * @param string
	 * @return array
	 */
	public function setOwner($owner) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Owner']
			[isset($this->_query['Owner'])?
			count($this->_query['Owner'])+1:1] = $owner;
		
		return $this;
	} 
	
	/**
	 * The full path to your AMI manifest in Amazon S3 storage.
	 *
	 * @param string
	 * @return array
	 */
	public function setImageLocation($imageLocation) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ImageLocation'] = $imageLocation;
		
		return $this;
	}
	
	/**
	 * A description of the AMI.
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
	 * The architecture of the image.
	 *
	 * @param string Valid values: i386 | x86_64
	 * @return array
	 */
	public function setArchitecture($architecture) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Architecture'] = $architecture;
		
		return $this;
	}
	
	/**
	 * The ID of the kernel.
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
	 * The ID of the RAM disk. Some kernels require additional drivers at 
	 * launch. Check the kernel requirements for information on whether 
	 * you need to specify a RAM disk. To find kernel requirements, refer 
	 * to the Resource Center and search for the kernel ID.
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
	 * The name of the root device (for example, /dev/sda1, or xvda).
	 *
	 * @param string 
	 * @return array
	 */
	public function setRootDeviceName($rootDeviceName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['RootDeviceName'] = $rootDeviceName;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	