<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Elastic Block Store
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_ElasticBookStore extends Eden_Amazon_Ec2_Base {
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
	 * Attaches an Amazon EBS volume to a running instance and exposes it 
	 * to the instance with the specified device name.
	 *
	 * @param string The ID of the Amazon EBS volume. The volume and instance must be within the same Availability Zone.
	 * @param string The ID of the instance. The instance must be running.
	 * @param string The device name as exposed to the instance (e.g., /dev/sdh, or xvdh).
	 * @return array
	 */
	public function attachVolume($volumeId, $instanceId, $device) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 	= 'AttachVolume';
		$this->_query['VolumeId']	= $volumeId;
		$this->_query['InstanceId']	= $instanceId;
		$this->_query['Device']		= $device;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Creates a snapshot of an Amazon EBS volume and stores it in Amazon 
	 * S3. You can use snapshots for backups, to make copies of instance 
	 * store volumes, and to save data before shutting down an instance
	 *
	 * @param string The ID of the Amazon EBS volume.
	 * @param string A description of the Amazon EBS snapshot.
	 * @return array
	 */
	public function createSnapShot($volumeId, $description) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 		= 'CreateSnapshot';
		$this->_query['VolumeId']		= $volumeId;
		$this->_query['Description']	= $description;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Creates an Amazon EBS volume that can be attached to any Amazon EC2 instance in
	 * the same Availability Zone. Any AWS Marketplace product codes from the snapshot
	 * are propagated to the volume
	 *
	 * @param string The Availability Zone for the new volume. Use DescribeAvailabilityZones 
	 * to display Availability Zones that are currently available to your 
	 * @return array
	 */
	public function createVolume($availabilityZone) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 			= 'CreateVolume';
		$this->_query['AvailabilityZone']	= $availabilityZone;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Deletes a snapshot of an Amazon EBS volume.
	 *
	 * @param string The ID of the Amazon EBS snapshot 
	 * @return array
	 */
	public function deleteSnapshot($snapshotId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 	= 'DeleteSnapshot';
		$this->_query['SnapshotId']	= $snapshotId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes an Amazon EBS volume. The volume must be in the available 
	 * state (not attached to an instance)
	 *
	 * @param string The ID of the volume.
	 * @return array
	 */
	public function deleteVolume($volumeId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 	= 'DeleteSnapshot';
		$this->_query['VolumeId']	= $volumeId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns information about an attribute of a snapshot. You can 
	 * get information about only one attribute per call.
	 *
	 * @param string The ID of the Amazon EBS snapshot.
	 * @param string The snapshot attribute. Valid values: createVolumePermission | productCodes
	 * @return array
	 */
	public function describeSnapshotAttribute($snapshotId, $attribute) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 	= 'DescribeSnapshotAttribute';
		$this->_query['SnapshotId']	= $snapshotId;
		$this->_query['Attribute']	= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns information about Amazon EBS snapshots available to you. 
	 * Snapshots available to you include public snapshots available for 
	 * any AWS account to launch, private snapshots you own, and private 
	 * snapshots owned by another AWS account but for which you've been 
	 * given explicit create volume permissions.
	 *
	 * @return array
	 */
	public function describeSnapshots() {
		
		$this->_query['Action'] = 'DescribeSnapshots';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes your Amazon EBS volumes. For more information about Amazon EBS
	 *
	 * @return array
	 */
	public function describeVolumes() {
		
		$this->_query['Action'] = 'DescribeVolumes';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes an attribute of the volume.
	 *
	 * @param string The ID of the volume.
	 * @param string The instance attribute. Valid values: autoEnableIO |productCodes
	 * @return array
	 */
	public function describeVolumeAttribute($volumeId, $attribute) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 	= 'DescribeVolumeAttribute';
		$this->_query['VolumeId'] 	= $volumeId;
		$this->_query['Attribute'] 	= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns the status of one or more volumes
	 *
	 * @return array
	 */
	public function describeVolumeStatus() {
		
		$this->_query['Action'] = 'DescribeVolumeStatus';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns the status of one or more volumes
	 *
	 * @param string The ID of the volume.
	 * @return array
	 */
	public function detachVolume($volumeId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']		= 'DetachVolume';
		$this->_query['VolumeId']	= $volumeId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Enables I/O operations for a volume that had I/O operations disabled because 
	 * the data on the volume was potentially inconsistent.
	 *
	 * @param string The ID of the volume.
	 * @return array
	 */
	public function enableVolumeIO($volumeId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']		= 'EnableVolumeIO';
		$this->_query['VolumeId']	= $volumeId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a new import volume task using metadata from the specified disk image. 
	 * After importing the image, you then upload it using the ec2-upload-disk-image 
	 * command in the EC2 command line tools
	 *
	 * @param string The file format of the disk image. Valid values: VMDK | RAW | VHD
	 * @param string The number of bytes in the disk image.
	 * @param string The manifest for the disk image, stored in Amazon S3 and presented here as an Amazon S3 presigned URL
	 * @param integer The size, in GB (2^30 bytes), of an Amazon EBS volume to hold the converted image.
	 * @return array
	 */
	public function importVolume($imageFormat, $imageBytes, $url, $volumeSize) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')	//argument 1 must be a string
			->argument(2, 'string')	//argument 2 must be a string
			->argument(3, 'string')	//argument 3 must be a string
			->argument(4, 'int');	//argument 4 must be a integer
		
		$this->_query['Action']						= 'ImportVolume';
		$this->_query['Image.Format']				= $imageFormat;
		$this->_query['Image.Bytes']				= $imageBytes;
		$this->_query['Image.ImportManifestUrl']	= $url;
		$this->_query['Volume.Size']				= $volumeSize;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Modifies a volume attribute.
	 *
	 * @param string The ID of the volume.
	 * @param boolean This attribute exists to auto-enable the I/O operations to the volume.
	 * @return array
	 */
	public function modifyVolumeAttribute($volumeId, $autoEnableIO = false) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')	//argument 1 must be a string
			->argument(2, 'bool');	//argument 2 must be a boolean
		
		$this->_query['Action']				= 'ModifyVolumeAttribute';
		$this->_query['VolumeId']			= $imageFormat;
		$this->_query['AutoEnableIO.Value']	= $autoEnableIO;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Resets permission settings for the specified snapshot.
	 *
	 * @param string The ID of the snapshot.
	 * @param string The attribute to reset (currently only the attribute for permission 
	 * to create volumes can be reset) Valid value: createVolumePermission
	 * @return array
	 */
	public function resetSnapshotAttribute($snapshotId, $attribute) {
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']		= 'ResetSnapshotAttribute';
		$this->_query['SnapshotId']	= $snapshotId;
		$this->_query['Attribute']	= $attribute;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The size of the volume, in GiBs.
	 *
	 * @param string Valid values: 1-1024
	 * @return array
	 */
	public function setSize($size) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Size'] = $size;
		
		return $this;
	}
	
	/**
	 * The snapshot from which to create the new volume.
	 *
	 * @param string 
	 * @return array
	 */
	public function setSnapshotId($snapshotId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SnapshotId'] = $snapshotId;
		
		return $this;
	}
	
	/**
	 * The volume type.
	 *
	 * @param string Valid values: standard | io1
	 * @return array
	 */
	public function setVolumeType($volumeType) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['VolumeType'] = $volumeType;
		
		return $this;
	}
	
	/**
	 * The number of I/O operations per second (IOPS) that the volume supports.
	 *
	 * @param string  Range is 1 to 1000.
	 * @return array
	 */
	public function setIops($iops) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Iops'] = $iops;
		
		return $this;
	}
	
	/**
	 * Snapshot ID
	 *
	 * @param string
	 * @return array
	 */
	public function setSnapshotsId($snapshotId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SnapshotId_']
			[isset($this->_query['SnapshotId_'])?
			count($this->_query['SnapshotId_'])+1:1] = $snapshotId;
		
		return $this;
	}

	/**
	 * Returns the snapshots owned by the specified owner. Multiple owners can be specified.
	 *
	 * @param string
	 * @return array
	 */
	public function setOwner($owner) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Owner_']
			[isset($this->_query['Owner_'])?
			count($this->_query['Owner_'])+1:1] = $owner;
		
		return $this;
	}
	
	/**
	 * AWS accounts IDs that can create volumes from the snapshot.
	 *
	 * @param string
	 * @return array
	 */
	public function restorableBy($accountId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['RestorableBy_']
			[isset($this->_query['RestorableBy_'])?
			count($this->_query['RestorableBy_'])+1:1] = $accountId;
		
		return $this;
	}
	 
	/**
	 * Volume ID
	 *
	 * @param string
	 * @return array
	 */
	public function setVolumeId($volumeId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['VolumeId_']
			[isset($this->_query['VolumeId_'])?
			count($this->_query['VolumeId_'])+1:1] = $volumeId;
		
		return $this;
	}
	
	/**
	 * The maximum number of paginated volume items per response.
	 *
	 * @param integer 
	 * @return array
	 */
	public function setMaxResults($maxResults) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');
		
		$this->_query['MaxResults'] = $maxResults;
		
		return $this;
	}
	
	/**
	 * A string specifying the next paginated set of results to return 
	 * using the pagination token returned by a previous call to this API.
	 *
	 * @param string 
	 * @return array
	 */
	public function setNextToken($nextToken) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NextToken'] = $nextToken;
		
		return $this;
	}
	
	/**
	 * The ID of the instance.
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
	 * The device name.
	 *
	 * @param string 
	 * @return array
	 */
	public function setDevice($device) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Device'] = $device;
		
		return $this;
	}
	
	/**
	 * Forces detachment if the previous detachment attempt did not occur 
	 * cleanly (logging into an instance, unmounting the volume, and detaching normally). 
	 * This option can lead to data loss or a corrupted file system. Use this option 
	 * only as a last resort to detach a volume from a failed instance. The instance 
	 * won't have an opportunity to flush file system caches or file system metadata. 
	 * If you use this option, you must perform file system check and repair procedures.
	 *
	 * @return array
	 */
	public function userForce() {
		
		$this->_query['Force'] = true;
		
		return $this;
	}
	
	/**
	 * The Availability Zone for the resulting Amazon EBS volume.
	 *
	 * @param string 
	 * @return array
	 */
	public function setAvailabilityZone($availabilityZone) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['AvailabilityZone'] = $availabilityZone;
		
		return $this;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	