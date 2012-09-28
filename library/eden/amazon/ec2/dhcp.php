<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 DHCP Options (Amazon VPC)
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Dhcp extends Eden_Amazon_Ec2_Base {
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
	 * Associates a set of DHCP options (that you've previously created) 
	 * with the specified VPC. Or, associates no DHCP options with the VPC.
	 *
	 * @param string The ID of the DHCP options you want to associate with the VPC, 
	 * or default if you want the VPC to use no DHCP options.
	 * @param string The ID of the VPC you want to associate the DHCP options with.
	 * @return array
	 */
	public function associateDhcpOptions($dhcpOptionsId, $vpcId) {
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 		= 'AssociateDhcpOptions ';
		$this->_query['DhcpOptionsId']	= $dhcpOptionsId;
		$this->_query['VpcId']			= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Creates a set of DHCP options for your VPC. After creating the new set, 
	 * you must associate it with the VPC, causing all existing and new instances 
	 * that you launch in the VPC to use the new set of DHCP options. The following 
	 * table lists the individual DHCP options you can specify
	 *
	 * @return array
	 */
	public function createDhcpOptions() {
		
		$this->_query['Action'] = 'CreateDhcpOptions';

		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	
	}
	
	/**
	 * Deletes a set of DHCP options that you specify. Amazon VPC returns an error 
	 * if the set of options you specify is currently associated with a VPC. 
	 * You can disassociate the set of options by associating either a new set 
	 * of options or the default options with the VPC.
	 *
	 * @param string The ID of the DHCP options set.
	 * @return array
	 */
	public function deleteDhcpOptions($dhcpOptionsId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 		= 'DeleteDhcpOptions';
		$this->_query['DhcpOptionsId']	= $dhcpOptionsId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The name of a DHCP option
	 *
	 * @param string
	 * @return array
	 */
	public function setDhcpConfigurationKey($key) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['DhcpConfiguration_Key']
			[isset($this->_query['DhcpConfiguration_Key'])?
			count($this->_query['DhcpConfiguration_Key'])+1:1] = $key;
		
		return $this;
	}
	
	/**
	 * A value for the DHCP option.
	 *
	 * @param string
	 * @return array
	 */
	public function setDhcpConfigurationValue($value) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['DhcpConfiguration_Value_']
			[isset($this->_query['DhcpConfiguration_Value_'])?
			count($this->_query['DhcpConfiguration_Value_'])+1:1] = $value;
		
		return $this;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	