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
	protected $_fileId			= NULL;
	protected $_permissionId	= NULL;
	protected $_kind			= NULL;
	protected $_etag			= NULL;
	protected $_id				= NULL;
	protected $_selfLink		= NULL;
	protected $_name			= NULL;
	protected $_role			= NULL;
	protected $_type			= NULL;
	protected $_photoLink		= NULL;
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
	 * The ID of the file. 
	 *
	 * @param string
	 * @return this
	 */
	public function setFileId($fileId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_fileId = $fileId;
		
		return $this;
	}
	
	/**
	 * The ID for the permission. 
	 *
	 * @param string
	 * @return this
	 */
	public function setPermissionId($permissionId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_permissionId = $permissionId;
		
		return $this;
	}
	
	/**
	 * The ID of the parent. 
	 *
	 * @param string
	 * @return this
	 */
	public function setParentId($parentId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_parentId = $parentId;
		
		return $this;
	}
	
	/**
	 * This is always drive#childReference.
	 *
	 * @param string
	 * @return this
	 */
	public function setKind($kind) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_kind = $kind;
		
		return $this;
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
	 * A link back to this reference.
	 *
	 * @param string
	 * @return this
	 */
	public function setSelfLink($selfLink) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_selfLink = $selfLink;
		
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
	 * The ETag of the permission.
	 *
	 * @param string
	 * @return this
	 */
	public function setEtag($etag) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_etag = $etag;
		
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
	 * WWhether the link is required for this permission.
	 *
	 * @return this
	 */
	public function setWithLink() {
		$this->_withLink = true;
		
		return $this;
	}
	
	/**
	 * A link to the profile photo, if available.
	 *
	 * @param string
	 * @return this
	 */
	public function setPhotoLink($photoLink) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_photoLink = $photoLink;
		
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
	 * Lists a file's permissions
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::URL_PERMISSIONS_LIST, $this->_fileId));
	}
	
	
	/**
	 * Gets a permission by ID
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_PERMISSIONS_GET, $this->_fileId, $this->_permissionId));
	}
	
	/**
	 * Deletes a permission from a file
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_PERMISSIONS_GET, $this->_fileId, $this->_permissionId));
	}
	
	/**
	 * Inserts a permission for a file
	 *
	 * @return array
	 */
	public function insert() {
		//populate fields
		$query = array(
			self::KIND			=> $this->_kind,
			self::ETAG			=> $this->_etag,
			self::ID			=> $this->_id,	
			self::SELF_LINK		=> $this->_selfLink,
			self::NAME			=> $this->_name,
			self::ROLE			=> $this->_role,		//required parameters
			self::TYPE			=> $this->_type,		//required parameters
			self::AUTH_KEY		=> $this->_token,		
			self::WITH_LINK		=> $this->_withLink,
			self::PHOTO_LINK	=> $this->_photoLink,
			self::VALUE			=> $this->_value);		//required parameters
		
		return $this->_post(sprintf(self::URL_PERMISSIONS_LIST, $this->_fileId), $query);
	}
	
	/**
	 * Updates a permission.
	 *
	 * @return array
	 */
	public function update() {
		//populate fields
		$query = array(
			self::KIND			=> $this->_kind,
			self::ETAG			=> $this->_etag,
			self::ID			=> $this->_id,	
			self::SELF_LINK		=> $this->_selfLink,
			self::NAME			=> $this->_name,
			self::ROLE			=> $this->_role,		//required parameters
			self::TYPE			=> $this->_type,		//required parameters
			self::AUTH_KEY		=> $this->_token,		
			self::WITH_LINK		=> $this->_withLink,
			self::PHOTO_LINK	=> $this->_photoLink,
			self::VALUE			=> $this->_value);		//required parameters
		
		return $this->_put(sprintf(self::URL_PERMISSIONS_GET, $this->_fileId, $this->_permissionId), $query);
	}
	
	/**
	 * Updates a permission. This method supports patch semantics.
	 *
	 * @return array
	 */
	public function patch() {
		//populate fields
		$query = array(
			self::KIND			=> $this->_kind,
			self::ETAG			=> $this->_etag,
			self::ID			=> $this->_id,	
			self::SELF_LINK		=> $this->_selfLink,
			self::NAME			=> $this->_name,
			self::ROLE			=> $this->_role,		//required parameters
			self::TYPE			=> $this->_type,		//required parameters
			self::AUTH_KEY		=> $this->_token,		
			self::WITH_LINK		=> $this->_withLink,
			self::PHOTO_LINK	=> $this->_photoLink,
			self::VALUE			=> $this->_value);		//required parameters
		
		return $this->_patch(sprintf(self::URL_PERMISSIONS_GET, $this->_fileId, $this->_permissionId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}