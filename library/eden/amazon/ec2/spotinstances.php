<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Spot Instances
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_SpotInstances extends Eden_Amazon_Ec2_Base {
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
	 * Cancels one or more Spot Instance requests. Spot Instances are instances that 
	 * Amazon EC2 starts on your behalf when the maximum price that you specify exceeds 
	 * the current Spot Price. Amazon EC2 periodically sets the Spot Price based on available 
	 * Spot Instance capacity and current Spot Instance requests
	 *
	 * @return array
	 */
	public function cancelSpotInstanceRequests() {	
		
		$this->_query['Action'] = 'CancelSpotInstanceRequests';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates the datafeed for Spot Instances, enabling you to view Spot Instance 
	 * usage logs. You can create one data feed per account
	 *
	 * @param string
	 * @return array
	 */
	public function createSpotDatafeedSubscription($bucket) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] = 'CreateSpotDatafeedSubscription';
		$this->_query['Bucket'] = $bucket;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes the datafeed for Spot Instances
	 *
	 * @return array
	 */
	public function deleteSpotDatafeedSubscription() {	
		
		$this->_query['Action'] = 'DeleteSpotDatafeedSubscription';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes the Spot Instance requests that belong to your account. Spot Instances 
	 * are instances that Amazon EC2 starts on your behalf when the maximum price that 
	 * you specify exceeds the current Spot Price. Amazon EC2 periodically sets the Spot 
	 * Price based on available Spot Instance capacity and current Spot Instance requests. 
	 *
	 * @return array
	 */
	public function describeSpotInstanceRequests() {	
		
		$this->_query['Action'] = 'DescribeSpotInstanceRequests';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes the Spot Price history. Spot Instances are instances that Amazon EC2 
	 * starts on your behalf when the maximum price that you specify exceeds the 
	 * current Spot Price. Amazon EC2 periodically sets the Spot Price based on 
	 * available Spot Instance capacity and current Spot Instance requests
	 *
	 * @return array
	 */
	public function describeSpotPriceHistory() {	
		
		$this->_query['Action'] = 'DescribeSpotPriceHistory';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Spot Instance request IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setSpotInstanceRequestIds($spotInstanceRequestId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SpotInstanceRequestId_']
			[isset($this->_query['GrouSpotInstanceRequestId_pId_'])?
			count($this->_query['SpotInstanceRequestId_'])+1:1] = $spotInstanceRequestId;
		
		return $this;
	}
	
	/**
	 * A prefix that is prepended to datafeed files.
	 *
	 * @param string
	 * @return array
	 */
	public function setSpotInstanceRequestId($prefix) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Prefix'] = $prefix;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	