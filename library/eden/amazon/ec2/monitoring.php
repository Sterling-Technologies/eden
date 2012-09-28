<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Amazon EC2 Monitoring
 *
 * @package    Eden
 * @category   amazon
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */ 
class Eden_Amazon_Ec2_Monitoring extends Eden_Amazon_Ec2_Base {
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
	 * Enables monitoring for a running instance.
	 *
	 * @return array
	 */
	public function monitorInstances() {		
		
		$this->_query['Action'] = 'MonitorInstances';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Disables monitoring for a running instance
	 *
	 * @return array
	 */
	public function unmonitorInstances() {		
		
		$this->_query['Action'] = 'UnmonitorInstances';
		
		return $this->_getResponse(self::AMAZON_EC2_HOST, $this->_query);
	}
	
	/**
	 * Instance ID
	 *
	 * @param string
	 * @return array
	 */
	public function setInstanceId($instanceId) {
		//argument 1 must be a string
		Eden_Amazon_Error::i()->argument(1, 'string');
		
		$this->_query['InstanceId_']
			[isset($this->_query['InstanceId_'])?
			count($this->_query['InstanceId_'])+1:1] = $instanceId;
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
	