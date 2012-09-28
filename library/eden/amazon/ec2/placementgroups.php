<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Placement Groups
 * 
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_PlacementGroups extends Eden_Amazon_Ec2_Base {
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
	 * Creates a placement group that you launch cluster instances into.
	 * You must give the group a name unique within the scope of your account.
	 *
	 * @param string A name for the placement group
	 * @param string The placement group strategy
	 * @return array
	 */
	public function createPlacementGroup($groupName, $strategy) {	
		//argument testing
		Eden_Amazon_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');	
		
		$this->_query['Action'] 	= 'CreatePlacementGroup';
		$this->_query['GroupName']	= $groupName;
		$this->_query['Strategy'] 	= $strategy;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Deletes a placement group from your account. You must terminate all instances 
	 * in the placement group before deleting it
	 *
	 * @param string The name of the placement group
	 * @return array
	 */
	public function deletePlacementGroup($groupName) {		
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['Action'] 	= 'DeletePlacementGroup';
		$this->_query['GroupName']	= $groupName;
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Returns information about one or more placement groups in your account
	 *
	 * @return array
	 */
	public function describePlacementGroups() {		
		
		$this->_query['Action'] = 'DescribePlacementGroups';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Placement group names
	 *
	 * @param string
	 * @return array
	 */
	public function setGroupName($groupName) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['GroupName_']
			[isset($this->_query['GroupName_'])?
			count($this->_query['GroupName_'])+1:1] = $groupName;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	