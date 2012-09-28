<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Subnets (Amazon VPC)
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Subnets extends Eden_Amazon_Ec2_Base {
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
	 * Creates a subnet in an existing VPC. You can create up to 20 subnets in a VPC
	 *
	 * @param string The ID of the VPC.
	 * @param string The CIDR block for the subnet to cover (e.g., 10.0.0.0/24)
	 * @return array
	 */
	public function createSubnet($vpcId, $cidrBlock) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 	= 'CreateSubnet';
		$this->_query['VpcId'] 		= $vpcId;
		$this->_query['CidrBlock'] 	= $cidrBlock;	
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a subnet from a VPC. You must terminate all running instances in 
	 * the subnet before deleting it, otherwise Amazon VPC returns an error.
	 *
	 * @param string The ID of the subnet
	 * @return array
	 */
	public function deleteSubnet($subnetId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action'] 	= 'DeleteSubnet';
		$this->_query['SubnetId'] 	= $subnetId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives you information about your subnets. You can filter the results to return 
	 * information only about subnets that match criteria you specify
	 *
	 * @return array
	 */
	public function describeSubnets() {	
		
		$this->_query['Action'] = 'DescribeSubnets';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The Availability Zone for the subnet.
	 * AWS selects a zone for you (recommended)
	 *
	 * @param string 
	 * @return array
	 */
	public function setTimeZone($timeZone) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		

		$this->_query['AvailabilityZone'] 	= $timeZone;	
		
		return $this;
	}
	
	/**
	 * A subnet ID. You can specify more than one in the request.
	 *
	 * @param string
	 * @return array
	 */
	public function setSubnetId($subnetId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['SubnetId_']
			[isset($this->_query['SubnetId_'])?
			count($this->_query['SubnetId_'])+1:1] = $subnetId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	