<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Permissions Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Permissions extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_PERMISSIONS_LIST	= 'https://www.googleapis.com/drive/v2/files/%s/permissions';
	const URL_PERMISSIONS_GET	= 'https://www.googleapis.com/drive/v2/files/%s/permissions/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_withLink		= false;
	protected $_id				= NULL;
	protected $_name			= NULL;
	protected $_role			= NULL;
	protected $_type			= NULL;
	protected $_value			= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_token = $token; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Deletes a permission from a file
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($fileId, $permissionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 1 must be a string	
		
		return $this->_delete(sprintf(self::URL_PERMISSIONS_GET, $fileId, $permissionId));
	}
	
	/**
	 * Lists a file's permissions
	 *
	 * @param string
	 * @return array
	 */
	public function getList($fileId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_PERMISSIONS_LIST, $fileId));
	}
	
	/**
	 * Gets a permission by ID
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($fileId, $permissionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string	
		
		return $this->_getResponse(sprintf(self::URL_PERMISSIONS_GET, $fileId, $permissionId));
	}
	
	/**
	 * Inserts a permission for a file
	 *
	 * @param string
	 * @param string The primary role for this user
	 * @param string The account type
	 * @param string The email address or domain name for the entity
	 * @return array
	 */
	public function insert($fileId, $role, $type, $value = 'me') {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string')		//argument 3 must be a string
			->argument(4, 'string');	//argument 4 must be a string	
		
		//if the input value is not allowed
		if(!in_array($role, array('owner', 'reader', 'writer'))) {
			//throw error
			Eden_Google_Error::i()
				->setMessage(Eden_Google_Error::INVALID_ROLE) 
				->addVariable($role)
				->trigger();
		}
		
		//if the input value is not allowed
		if(!in_array($type, array('user', 'group', 'domain', 'anyone'))) {
			//throw error
			Eden_Google_Error::i()
				->setMessage(Eden_Google_Error::INVALID_TYPE) 
				->addVariable($type)
				->trigger();
		}
		
		//populate fields
		$query = array(
			self::VALUE			=> $value,
			self::ROLE			=> $role,		
			self::TYPE			=> $type,	
			self::NAME			=> $this->_name,		//optional
			self::WITH_LINK		=> $this->_withLink);	//optional	
		
		return $this->_post(sprintf(self::URL_PERMISSIONS_LIST, $fileId), $query);
	}
	
	/**
	 * Updates a permission. This method supports patch semantics.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function patch($fileId, $permissionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(
			self::NAME			=> $this->_name,		//optional
			self::ROLE			=> $this->_role,		//optional
			self::TYPE			=> $this->_type,		//optional
			self::WITH_LINK		=> $this->_withLink,	//optional
			self::VALUE			=> $this->_value);		//optional		
		
		return $this->_patch(sprintf(self::URL_PERMISSIONS_GET, $fileId, $permissionId), $query);
	}
	
	/**
	 * The ID of the child.
	 *
	 * @param string
	 * @return this
	 */
	public function setId($id) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_id = $id;
		
		return $this;
	}
	
	/**
	 * The name for this permission.
	 *
	 * @param string
	 * @return this
	 */
	public function setName($name) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_name = $name;
		
		return $this;
	}
	
	/**
	 * The primary role for this user
	 * Allowed values are:
     * - owner
     * - reader
     * - writer
	 *
	 * @param string
	 * @return this
	 */
	public function setRole($role) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_role = $role;
		
		return $this;
	}
	
	/**
	 * Allowed values are:
     * - user
     * - group
     * - domain
     * - anyone
	 *
	 * @param string
	 * @return this
	 */
	public function setType($type) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_type = $type;
		
		return $this;
	}
	
	/**
	 * The email address or domain name for the 
	 * entity. This is not populated in responses.
	 *
	 * @param string
	 * @return this
	 */
	public function setValue($value) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_value = $value;
		
		return $this;
	}
	
	/**
	 * WWhether the link is required for this permission.
	 *
	 * @return this
	 */
	public function setWithLink() {
		$this->_withLink = true;
		
		return $this;
	}
	
	/**
	 * Updates a permission.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function update($fileId, $permissionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(
			self::NAME			=> $this->_name,		//optional
			self::ROLE			=> $this->_role,		//optional
			self::TYPE			=> $this->_type,		//optional
			self::WITH_LINK		=> $this->_withLink,	//optional
			self::VALUE			=> $this->_value);		//optional		
		
		return $this->_put(sprintf(self::URL_PERMISSIONS_GET, $fileId, $permissionId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}