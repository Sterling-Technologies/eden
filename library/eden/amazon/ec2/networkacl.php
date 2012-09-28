<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Network ACLs (Amazon VPC)
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_NetworkAcl extends Eden_Amazon_Ec2_Base {
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
	 * Creates a network ACL in a VPC
	 *
	 * @param string The ID of the VPC
	 * @return array
	 */
	public function createNetworkAcl($VpcId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action'] = 'CreateNetworkAcl';
		$this->_query['VpcId'] 	= $vpcId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a network ACL in a VPC
	 *
	 * @param string The ID of the ACL
	 * @param integer The rule number to assign to the entry (for example, 100)
	 * @param integer The IP protocol the rule applies to. You can use -1 to mean all protocols.
	 * @param string Indicates whether to allow or deny traffic that matches the rule. Valid values: allow | deny
	 * @param string The CIDR range to allow or deny, in CIDR notation (for example, 172.16.0.0/24).
	 * @return array
	 */
	public function createNetworkAclEntry($networkAclId, $ruleNumber, $protocol, $ruleAction, $cidrBlock) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'int')		//argument 2 must be a integer
			->argument(3, 'int')		//argument 3 must be a integer
			->argument(4, 'string')		//argument 4 must be a string
			->argument(5, 'string');	//argument 5 must be a string
		
		$this->_query['Action'] 		= 'CreateNetworkAclEntry';
		$this->_query['NetworkAclId'] 	= $networkAclId;
		$this->_query['RuleNumber'] 	= $ruleNumber;
		$this->_query['Protocol'] 		= $protocol;
		$this->_query['RuleAction'] 	= $ruleAction;
		$this->_query['CidrBlock'] 		= $cidrBlock;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a network ACL from a VPC. The ACL must not have any subnets associated with
	 * it. You can't delete the default network ACL
	 *
	 * @param string The ID of the network ACL
	 * @return array
	 */
	public function deleteNetworkAcl($networkAclId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');	
		
		$this->_query['Action']		 	= 'DeleteNetworkAcl';
		$this->_query['NetworkAclId'] 	= $networkAclId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes an ingress or egress entry (i.e., rule) from a network ACL
	 *
	 * @param string The ID of the network ACL
	 * @param integer The rule number for the entry to delete.
	 * @return array
	 */
	public function deleteNetworkAclEntry($networkAclId, $ruleNumber) {	
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'int');		//argument 2 must be a integer
		
		$this->_query['Action']		 	= 'DeleteNetworkAclEntry';
		$this->_query['NetworkAclId'] 	= $networkAclId;
		$this->_query['RuleNumber'] 	= $ruleNumber;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	} 	
	
	/**
	 * Gives you information about the network ACLs in your VPC.
	 *
	 * @return array
	 */
	public function describeNetworkAcls() {	
	
		$this->_query['Action'] = 'DescribeNetworkAcls';
	
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes an ingress or egress entry (i.e., rule) from a network ACL
	 *
	 * @param string The ID of the network ACL
	 * @param string The ID representing the current association between 
	 * the original network ACL and the subnet.
	 * @return array
	 */
	public function replaceNetworkAclAssociation($networkAclId, $associationId) {	
		//argument test
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action']		 	= 'ReplaceNetworkAclAssociation';
		$this->_query['NetworkAclId'] 	= $networkAclId;
		$this->_query['AssociationId'] 	= $associationId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	} 
	
	/**
	 * Replaces an entry in a network ACL. 
	 *
	 * @param string The ID of the ACL
	 * @param integer The rule number to assign to the entry (for example, 100)
	 * @param integer The IP protocol the rule applies to. You can use -1 to mean all protocols.
	 * @param string Indicates whether to allow or deny traffic that matches the rule. Valid values: allow | deny
	 * @param string The CIDR range to allow or deny, in CIDR notation (for example, 172.16.0.0/24).
	 * @return array
	 */
	public function replaceNetworkAclEntry($networkAclId, $ruleNumber, $protocol, $ruleAction, $cidrBlock) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'int')		//argument 2 must be a integer
			->argument(3, 'int')		//argument 3 must be a integer
			->argument(4, 'string')		//argument 4 must be a string
			->argument(5, 'string');	//argument 5 must be a string
		
		$this->_query['Action'] 		= 'ReplaceNetworkAclEntry';
		$this->_query['NetworkAclId'] 	= $networkAclId;
		$this->_query['RuleNumber'] 	= $ruleNumber;
		$this->_query['Protocol'] 		= $protocol;
		$this->_query['RuleAction'] 	= $ruleAction;
		$this->_query['CidrBlock'] 		= $cidrBlock;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Indicates whether this rule applies to egress traffic from the subnet 
	 * (true) or ingress traffic to the subnet (false).
	 *
	 * @param boolean
	 * @return array
	 */
	public function setEgress($egress) {
		//argument 1 must be a boolean
		Eden_Amazon_Error::i()->argument(1, 'bool');				
		
		$this->_query['Egress'] = $egress;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * For the ICMP protocol, the ICMP code. You can use -1 to specify all ICMP 
	 * codes for the given ICMP type.
	 *
	 * @param integer
	 * @return array
	 */
	public function setIcmpCode($code) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');				
		
		$this->_query['Icmp.Code'] = $code;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * For the ICMP protocol, the ICMP type. You can use -1 to specify all ICMP types.
	 *
	 * @param integer
	 * @return array
	 */
	public function setIcmpType($code) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');				
		
		$this->_query['Icmp.Type'] = $code;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The first port in the range. Required if specifying 6 (TCP) or 17 
	 * (UDP) for the protocol.
	 *
	 * @param integer
	 * @return array
	 */
	public function setPortRangeFrom($firstPort) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');				
		
		$this->_query['PortRange.From'] = $firstPort;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The last port in the range. Required if specifying 6 (TCP) or 17 
	 * (UDP) for the protocol.
	 *
	 * @param integer
	 * @return array
	 */
	public function setPortRangeTo($lastPort) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');				
		
		$this->_query['PortRange.To'] = $lastPort;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}

	/**
	 * Network ACL ID
	 *
	 * @param string
	 * @return array
	 */
	public function setNetworkAclId($networkAclId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['NetworkAclId_']
			[isset($this->_query['NetworkAclId_'])?
			count($this->_query['NetworkAclId_'])+1:1] = $networkAclId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	