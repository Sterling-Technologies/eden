<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 VM Import
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_VmImport extends Eden_Amazon_Ec2_Base {
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
	 * Cancels an active conversion task. The task can be the import of an instance or volume.
	 * The action removes all artifacts of the conversion, including a partially uploaded volume 
	 * or instance. If the conversion is complete or is in the process of transferring the final 
	 * disk image, the command fails and returns an exception.
	 *
	 * @param string The ID of the task
	 * @return array
	 */
	public function cancelConversionTask($conversionTaskId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');				
		
		$this->_query['Action'] 			= 'CancelConversionTask';
		$this->_query['ConversionTaskId'] 	= $conversionTaskId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes your conversion tasks
	 *
	 * @return array
	 */
	public function describeConversionTasks() {		
		
		$this->_query['Action'] = 'DescribeConversionTasks';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a new import volume task using metadata from the specified disk image. 
	 * After importing the image, you then upload it using the ec2-upload-disk-image 
	 * command in the EC2 command line tools
	 *
	 * @param string The Availability Zone for the resulting Amazon EBS volume.
	 * @param string The file format of the disk image. Valid values: VMDK | RAW | VHD
	 * @param string The number of bytes in the disk image.
	 * @param string The manifest for the disk image, stored in Amazon S3 and presented here as an Amazon S3 presigned URL.
	 * @param string|integer The size, in GB (2^30 bytes), of an Amazon EBS volume to hold the converted image.
	 * @return array
	 */
	public function importVolume($conversionTaskId) {	
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')			//argument 1 must be a string
			->argument(2, 'string')			//argument 2 must be a string
			->argument(3, 'string')			//argument 3 must be a string
			->argument(4, 'string')			//argument 4 must be a string
			->argument(5, 'string', 'int');	//argument 5 must be a string or integer			
		
		$this->_query['Action'] 					= 'ImportVolume';
		$this->_query['AvailabilityZone'] 			= $availabilityZone;
		$this->_query['Image.Format'] 				= $format;
		$this->_query['Image.Bytes'] 				= $bytes;
		$this->_query['Image.ImportManifestUrl'] 	= $importManifestUrl;
		$this->_query['Volume.Size'] 				= $size;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * An optional description of the volume being imported.
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
	 * One or more conversion task IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setConversionTaskId($conversionTaskId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ConversionTaskId_']
			[isset($this->_query['ConversionTaskId_'])?
			count($this->_query['ConversionTaskId_'])+1:1] = $conversionTaskId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	