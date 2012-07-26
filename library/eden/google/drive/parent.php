<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Parent Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Parent extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_PARENT_LIST	= 'https://www.googleapis.com/drive/v2/files/%s/parents';
	const URL_PARENT_GET	= 'https://www.googleapis.com/drive/v2/files/%s/parents/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_fileId		= NULL;
	protected $_parentId	= NULL;
	protected $_kind		= NULL;
	protected $_id			= NULL;
	protected $_selfLink	= NULL;
	protected $_childLink	= NULL;
	protected $_isRoot		= false;
	
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
	 * A link to the child.
	 *
	 * @param string
	 * @return this
	 */
	public function setChildLink($childLink) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_childLink = $childLink;
		
		return $this;
	}
	
	/**
	 * Whether or not the parent is the root folder.
	 *
	 * @return this
	 */
	public function setIsRoot() {
		$this->_isRoot = true;
		
		return $this;
	}
	
	/**
	 * Lists a file's parents. 
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::URL_PARENT_LIST, $this->_fileId));
	}
	
	/**
	 * Gets a specific parent reference.
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_PARENT_GET, $this->_fileId, $this->_parentId));
	}
	
	/**
	 * Removes a parent from a file.
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_PARENT_GET, $this->_fileId, $this->_parentId));
	}
	
	/**
	 * Adds a parent folder for a file.
	 *
	 * @return array
	 */
	public function insert() {
		//populate fields
		$query = array(
			self::KIND			=> $this->_kind,
			self::ID			=> $this->_id,	
			self::SELF_LINK		=> $this->_selfLink,
			self::CHILD_LINK	=> $this->_childLink,
			self::IS_ROOT		=> $this->_isRoot);
		
		return $this->_post(sprintf(self::URL_PARENT_LIST, $this->_fileId), $query);
	}
	 
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}