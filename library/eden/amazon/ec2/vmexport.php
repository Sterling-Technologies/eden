<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 VM Export
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_VmExport extends Eden_Amazon_Ec2_Base {
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
	 * Cancels an active export task. The command removes all artifacts of the export, 
	 * including any partially created Amazon S3 objects. If the export task is complete
	 * or is in the process of transferring the final disk image, the command fails and returns an error.
	 *
	 * @param string The ID of the export task
	 * @return array
	 */
	public function cancelExportTask($exportTaskId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');				
		
		$this->_query['Action'] 		= 'CancelExportTask';
		$this->_query['ExportTaskId'] 	= $exportTaskId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Exports a running or stopped instance to an Amazon S3 bucket
	 *
	 * @param string The ID of the instance being exported.
	 * @param string The target virtualization environment. Valid values: vmware | citrix | microsoft
	 * @param string The Amazon S3 bucket for the destination image. The bucket must exist and 
	 * grant write permissions to AWS account vm-import-export@amazon.com.
	 * @return array
	 */
	public function createInstanceExportTask($instanceId, $targetEnvironment, $s3Bucket) {	
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		$this->_query['Action'] 				= 'CreateInstanceExportTask';
		$this->_query['InstanceId'] 			= $instanceId;
		$this->_query['TargetEnvironment']		= $targetEnvironment;
		$this->_query['ExportToS3.S3Bucket'] 	= $s3Bucket;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes your export tasks. If no export task IDs are specified, 
	 * all export tasks initiated by you are returned.
	 *
	 * @return array
	 */
	public function describeExportTasks() {	
		
		$this->_query['Action'] = 'DescribeExportTasks';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * A description of the conversion task or the resource being exported.
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
	 * The format for the exported image. Valid values: vmdk | vhd
	 *
	 * @param string
	 * @return array
	 */
	public function setDiskImageFormat($diskImageFormat) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ExportToS3.DiskImageFormat'] = $diskImageFormat;
		
		return $this;
	}
	
	/**
	 * The container format used to combine disk images with metadata (such as OVF). 
	 * If absent, only the disk image will be exported. Valid values: ova
	 *
	 * @param string
	 * @return array
	 */
	public function setContainerFormat($containerFormat) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ExportToS3.ContainerFormat'] = $containerFormat;
		
		return $this;
	}
	
	/**
	 * The image is written to a single object in the Amazon S3 bucket at the 
	 * S3 key s3prefix + exportTaskId + ‘.’ +diskImageFormat.
	 *
	 * @param string
	 * @return array
	 */
	public function setS3Prefix($s3Prefix) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ExportToS3.S3Prefix'] = $s3Prefix;
		
		return $this;
	}
	
	/**
	 * One or more export task IDs. If no task IDs are provided, 
	 * all active export tasks are described
	 *
	 * @param string
	 * @return array
	 */
	public function setExportTaskId($exportTaskId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ExportTaskId_']
			[isset($this->_query['ExportTaskId_'])?
			count($this->_query['ExportTaskId_'])+1:1] = $exportTaskId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	