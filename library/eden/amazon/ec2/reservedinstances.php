<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Reserved Instances
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_ReservedInstances extends Eden_Amazon_Ec2_Base {
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
	 * Describes Reserved Instances that you purchased.
	 *
	 * @return array
	 */
	public function DescribeReservedInstances() {	
		
		$this->_query['Action'] = 'DescribeReservedInstances';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes Reserved Instance offerings that are available for purchase.
	 *
	 * @return array
	 */
	public function describeReservedInstancesOfferings() {	
		
		$this->_query['Action'] = 'DescribeReservedInstancesOfferings';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Describes Reserved Instance offerings that are available for purchase.
	 *
	 * @param string The ID of the Reserved Instance offering
	 * @return array
	 */
	public function purchaseReservedInstancesOffering($reservedInstancesOfferingId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action'] 						= 'PurchaseReservedInstancesOffering';
		$this->_query['ReservedInstancesOfferingId'] 	= $reservedInstancesOfferingId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Reserved Instance ID.
	 *
	 * @param string
	 * @return array
	 */
	public function setReservedInstancesId($reservedInstancesId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ReservedInstancesId_']
			[isset($this->_query['ReservedInstancesId_'])?
			count($this->_query['ReservedInstancesId_'])+1:1] = $reservedInstancesId;
		
		return $this;
	}
	
	/**
	 * The Reserved Instance offering type.
	 * Valid values: Heavy Utilization | Medium Utilization | Light Utilization
	 *
	 * @param string
	 * @return array
	 */
	public function setOfferingType($offeringType) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['offeringType'] = $offeringType;
		
		return $this;
	}
	
	/**
	 * Reserved Instances offering ID
	 *
	 * @param string
	 * @return array
	 */
	public function setReservedInstancesOfferingId($reservedInstancesOfferingId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ReservedInstancesOfferingId_']
			[isset($this->_query['ReservedInstancesOfferingId_'])?
			count($this->_query['ReservedInstancesOfferingId_'])+1:1] = $reservedInstancesOfferingId;
		
		return $this;
	}
	
	/**
	 * The instance type on which the Reserved Instance can be used.
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceType($instanceType) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InstanceType'] = $instanceType;
		
		return $this;
	}
	
	/**
	 * The Availability Zone in which the Reserved Instance can be used.
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
	
	/**
	 * The Reserved Instance description. Instances that include (Amazon VPC) in the 
	 * description are for use with Amazon VPC Valid values: Linux/UNIX | Linux/UNIX 
	 * (Amazon VPC) | Windows | Windows (Amazon VPC)
	 *
	 * @param string
	 * @return array
	 */
	public function setProductDescription($productDescription) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['ProductDescription'] = $productDescription;
		
		return $this;
	}
	
	/**
	 * The tenancy of the Reserved Instance offering. A Reserved Instance with 
	 * tenancy of dedicated will run on single-tenant hardware and can only be 
	 * launched within a VPC. Valid values: default | dedicated
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceTenancy($instanceTenancy) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['instanceTenancy'] = $instanceTenancy;
		
		return $this;
	}
	
	/**
	 * The number of Reserved Instances to purchase
	 *
	 * @param Integer
	 * @return array
	 */
	public function setInstanceCount($instanceCount) {
		//argument 1 must be a Integer
		Eden_Amazon_Error::i()->argument(1, 'int');
		
		$this->_query['InstanceCount'] = $instanceCount;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	