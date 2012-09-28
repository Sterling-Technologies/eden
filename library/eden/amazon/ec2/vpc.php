<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 VPCs (Amazon VPC)
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Vpc extends Eden_Amazon_Ec2_Base {
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
	 * Creates a VPC with the specified CIDR block.
	 *
	 * @param string The CIDR block you want the VPC to cover
	 * @param string|null The supported tenancy of instances launched into the VPC.
	 * @return array
	 */
	public function createVpc($cidrBlock, $instanceTenancy = NULL) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')				//argument 1 must be a string
			->argument(2, 'string', 'null');	//argument 2 must be a string or null
		
		$this->_query['Action'] 			= 'CreateVpc';
		$this->_query['CidrBlock'] 			= $cidrBlock;
		$this->_query['instanceTenancy'] 	= $instanceTenancy;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a VPC. You must detach or delete all gateways or other objects 
	 * that are dependent on the VPC first. 
	 *
	 * @param string The ID of the VPC
	 * @return array
	 */
	public function deleteVpc($vpcId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action'] = 'DeleteVpc';
		$this->_query['VpcId'] 	= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Gives you information about your VPCs 
	 *
	 * @return array
	 */
	public function describeVpcs() {			
		
		$this->_query['Action'] = 'DescribeVpcs';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The ID of the VPC.
	 *
	 * @param string
	 * @return array
	 */
	public function setVpcId($vpcId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['VpcId_']
			[isset($this->_query['VpcId_'])?
			count($this->_query['VpcId_'])+1:1] = $vpcId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	