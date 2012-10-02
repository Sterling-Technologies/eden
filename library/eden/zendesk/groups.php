<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Zen Desk Groups
 *
 * @package    Eden
 * @category   zendesk
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com 
 */
class Eden_ZenDesk_Groups extends Eden_ZenDesk_Base {
	/* Constants
	-------------------------------*/
	const USER_GROUPS_LIST		= 'https://%s.zendesk.com/api/v2/groups.json';
	const USER_GROUPS_GET		= 'https://%s.zendesk.com/api/v2/groups/%s.json';
	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_query = array();
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

	/* Public Methods
	-------------------------------*/
	/**
	 * Get list of groups
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::USER_GROUPS_LIST, $this->_subdomain));
	}
		
	/**
	 * Get Specific groups 
	 *
	 * @param string|integer
	 * @return array
	 */
	public function getSpecific($groupId) {
		//argument 1 must be a string or integer
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');
		
		return $this->_getResponse(sprintf(self::USER_GROUPS_GET, $this->_subdomain, $groupId));
	}

	/**
	 * Create a group
	 *
	 * @param string
	 * @return array
	 */
	public function createGroup($name) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['group']['name'] = $name;
		
		return $this->_post(sprintf(self::USER_GROUPS_LIST, $this->_subdomain), $this->_query);
	}


	/**
	 * Update a group
	 *
	 * @param string|integer
	 * @return array
	 */
	public function updateGroup($groupId) {
		//argument 1 must be a string or integer
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');	
			
		return $this->_put(sprintf(self::USER_GROUPS_GET, $this->_subdomain, $groupId), $this->_query);
	}
	
	/**
	 * Delete a group
	 *
	 * @param string|integer
	 * @return array
	 */
	public function deleteGroup($groupId) {
		//argument 1 must be a string or integer
		Eden_ZenDesk_Error::i()->argument(1, 'string', 'int');		
			
		return $this->_delete(sprintf(self::USER_GROUPS_GET, $this->_subdomain, $groupId));
	}
	
	/**
	 * The name of the group
	 *
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//argument 1 must be a string 
		Eden_ZenDesk_Error::i()->argument(1, 'string');
		
		$this->_query['group']['name'] = $name;
		
		return $this;
	}1
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}