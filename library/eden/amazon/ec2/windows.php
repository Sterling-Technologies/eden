<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Windows
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Windows extends Eden_Amazon_Ec2_Base {
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
	 * Bundles an Amazon instance store-backed Windows instance.
	 *
	 * @param string The ID of the instance to bundle.
	 * @param string The bucket in which to store the AMI
	 * @param string The beginning of the file name of the AMI.
	 * @param string A Base64-encoded Amazon S3 upload policy
	 * @param string The signature of the Base64 encoded JSON document.
	 * @return array
	 */
	public function bundleInstance($instancesId, $bucket, $prefix, $uploadPolicy, $signature) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string')		//argument 3 must be a string
			->argument(4, 'string')		//argument 4 must be a string
			->argument(5, 'string');	//argument 5 must be a string
		
		$this->_query['Action'] 							= 'BundleInstance';
		$this->_query['InstanceId'] 						= $instancesId;
		$this->_query['Storage.S3.Bucket'] 					= $bucket;
		$this->_query['Storage.S3.Prefix'] 					= $prefix;
		$this->_query['Storage.S3.UploadPolicy'] 			= $uploadPolicy;
		$this->_query['Storage.S3.UploadPolicySignature'] 	= $signature;
		$this->_query['Storage.S3.AWSAccessKeyId'] 			= $this->_accessKey;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Cancels a bundling operation for an instance store-backed Windows instance
	 *
	 * @param string The ID of the bundle task
	 * @return array
	 */
	public function cancelBundleTask($bundleId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']		= 'CancelBundleTask';
		$this->_query['BundleId'] 	= $bundleId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes current bundling tasks for instance store-backed Windows instances.
	 *
	 * @return array
	 */
	public function describeBundleTasks() {	
		
		$this->_query['Action']	= 'DescribeBundleTasks';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Retrieves the encrypted administrator password for an instance running Windows.
	 *
	 * @param string A Windows instance ID
	 * @return array
	 */
	public function getPasswordData($instanceId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action']		= 'GetPasswordData';
		$this->_query['InstanceId'] = $instanceId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Bundle task IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setBundleId($bundleId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['BundleId_']
			[isset($this->_query['BundleId_'])?
			count($this->_query['BundleId_'])+1:1] = $bundleId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	