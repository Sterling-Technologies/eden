<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Security Groups
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_SecurityGroups extends Eden_Amazon_Ec2_Base {
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
	 * Adds one or more egress rules to a VPC security group. Specifically, this action 
	 * permits instances in a security group to send traffic to one or more destination 
	 * CIDR IP address ranges, or to one or more destination security groups in the same VPC.
	 *
	 * @param string The ID of the VPC security group to modify.
	 * @return array
	 */
	public function authorizeSecurityGroupEgress($groupId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');		
		
		$this->_query['Action'] 	= 'AuthorizeSecurityGroupEgress';
		$this->_query['GroupId'] 	= $groupId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Creates a new security group. You can create either an EC2 security group 
	 * (which works only with EC2), or a VPC security group (which works only with 
	 * Amazon Virtual Private Cloud). The two types of groups have different capabilities
	 *
	 * @param string The name of the security group.
	 * @param string A description of the group. This is informational only.
	 * @return array
	 */
	public function createSecurityGroup($groupId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		$this->_query['Action'] 			= 'CreateSecurityGroup';
		$this->_query['GroupName'] 			= $groupName;
		$this->_query['GroupDescription'] 	= $groupDescription;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a security group. This action applies to both EC2 security groups 
	 * and VPC security groups.
	 *
	 * @param string|int Name or ID or security group
	 * @return array
	 */
	public function deleteSecurityGroup($securityGroup) {	
		//argument 1 must be a string or ineteger
		Eden_Amazon_Error::i()->argument(1, 'string', 'int');			
		
		//if it is integer
		if(is_int($securityGroup)) {
			$this->_query['GroupId'] = $securityGroup;
		//else it must be a string
		} else {
			$this->_query['GroupName'] = $securityGroup;
		}
		
		$this->_query['Action']	= 'DeleteSecurityGroup';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns information about security groups in your account.
	 *
	 * @return array
	 */
	public function describeSecurityGroups() {	
		
		$this->_query['Action']	= 'DescribeSecurityGroups';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}	
	
	/**
	 * This action applies only to security groups in a VPC. It doesn't work with EC2 security groups.
	 *
	 * @param string The ID of the VPC security group to modify.
	 * @return array
	 */
	public function revokeSecurityGroupEgress($groupId) {	
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');			
	
		$this->_query['Action']	= 'RevokeSecurityGroupEgress';
		$this->_query['GroupId'] = $groupId;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * The ID of the EC2 or VPC security group to modify. The group 
	 * must belong to your account.
	 *
	 * @param string
	 * @return array
	 */
	public function setGroupId($groupId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['GroupId'] = $groupId;
		
		return $this;
	}
	
	/**
	 * Security group IDs.
	 *
	 * @param string
	 * @return array
	 */
	public function setGroupIds($groupIds) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['GroupId_']
			[isset($this->_query['GroupId_'])?
			count($this->_query['GroupId_'])+1:1] = $groupIds;
		
		return $this;
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
		
		$this->_query['VpcId'] = $vpcId;
		
		return $this;
	}
	
	/**
	 * The name of the EC2 security group to modify.
	 *
	 * @param string
	 * @return array
	 */
	public function setGroupName($groupName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['GroupName'] = $groupName;
		
		return $this;
	}
	
	/**
	 * Security group names.
	 *
	 * @param string
	 * @return array
	 */
	public function setGroupNames($groupNames) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['GroupName_']
			[isset($this->_query['GroupName_'])?
			count($this->_query['GroupName_'])+1:1] = $groupNames;
		
		return $this;
	}
	
	/**
	 * The IP protocol name or number. 
	 * Valid values: tcp | udp | icmp or any protocol number
	 *
	 * @param string
	 * @return array
	 */
	public function setIpPermissionsIpProtocol($ipProtocol) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['IpPermissions_IpProtocol']
			[isset($this->_query['IpPermissions_IpProtocol'])?
			count($this->_query['IpPermissions_IpProtocol'])+1:1] = $ipProtocol;
		
		return $this;
	}
	
	/**
	 * The start of port range for the TCP and UDP protocols, or an ICMP type number.
	 * For the ICMP type number, you can use -1 to specify all ICMP types.
	 *
	 * @param integer
	 * @return array
	 */
	public function setIpPermissionsFromPort($ip) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');
		
		$this->_query['IpPermissions_FromPort']
			[isset($this->_query['IpPermissions_FromPort'])?
			count($this->_query['IpPermissions_FromPort'])+1:1] = $ip;
		
		return $this;
	}
	
	/**
	 * The end of port range for the TCP and UDP protocols, or an ICMP code number.
	 * For the ICMP code number, you can use -1 to specify all ICMP codes for the given ICMP type.
	 *
	 * @param integer
	 * @return array
	 */
	public function setIpPermissionsToPort($ip) {
		//argument 1 must be a integer
		Eden_Amazon_Error::i()->argument(1, 'int');
		
		$this->_query['IpPermissions_ToPort']
			[isset($this->_query['IpPermissions_ToPort'])?
			count($this->_query['IpPermissions_ToPort'])+1:1] = $ip;
		
		return $this;
	}
	
	/**
	 * The name of the destination security group. Cannot be used when specifying
	 * a CIDR IP address.
	 *
	 * @param string
	 * @return array
	 */
	public function setIpPermissionsGroupId($groupId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['IpPermissions_Groups_GroupId']
			[isset($this->_query['IpPermissions_Groups_GroupId'])?
			count($this->_query['IpPermissions_Groups_GroupId'])+1:1] = $groupId;
		
		return $this;
	}
	
	/**
	 * The AWS account ID that owns the source security group. Cannot be 
	 * used when specifying a CIDR IP address.
	 *
	 * @param string
	 * @return array
	 */
	public function setIpPermissionsUserId($userId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['IpPermissions_Groups_UserId']
			[isset($this->_query['IpPermissions_Groups_UserId'])?
			count($this->_query['IpPermissions_Groups_UserId'])+1:1] = $userId;
		
		return $this;
	}
	
	/**
	 * The name of the source security group. 
	 * Cannot be used when specifying a CIDR IP address.
	 *
	 * @param string
	 * @return array
	 */
	public function setIpPermissionsGroupName($groupName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['IpPermissions_Groups_GroupName']
			[isset($this->_query['IpPermissions_Groups_GroupName'])?
			count($this->_query['IpPermissions_Groups_GroupName'])+1:1] = $groupName;
		
		return $this;
	}
	
	/**
	 * The CIDR range. Cannot be used when specifying a source security group.
	 *
	 * @param string
	 * @return array
	 */
	public function setIpPermissionsCidrIp($cidrIp) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['IpPermissions_IpRanges_CidrIp']
			[isset($this->_query['IpPermissions_IpRanges_CidrIp'])?
			count($this->_query['IpPermissions_IpRanges_CidrIp'])+1:1] = $cidrIp;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	