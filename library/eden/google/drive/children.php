<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Children Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Children extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_CHILDREN_LIST		= 'https://www.googleapis.com/drive/v2/files/%s/children';
	const URL_CHILDREN_SPECIFIC	= 'https://www.googleapis.com/drive/v2/files/%s/children/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_folderId	= NULL;
	protected $_childrenId	= NULL;
	protected $_kind		= NULL;
	protected $_id			= NULL;
	protected $_selfLink	= NULL;
	protected $_childLink	= NULL;
	
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
	 * Removes a child from a folder
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_CHILDREN_SPECIFIC, $this->_fileId, $this->_childrenId));
	}
	
	/**
	 * Lists the changes for a user.
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::URL_CHANGES_LIST, $this->_folderId));
	}
	
	/**
	 * Gets a specific child reference
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_CHILDREN_SPECIFIC, $this->_fileId, $this->_childrenId));
	}
	
	/**
	 * Inserts a file into a folder
	 *
	 * @return array
	 */
	public function insert() {
		//populate fields
		$query = array(
			self::KIND			=> $this->_kind,
			self::ID			=> $this->_id,	
			self::SELF_LINK		=> $this->_selfLink,
			self::CHILD_LINK	=> $this->_childLink);
		
		return $this->_post(sprintf(self::URL_CHANGES_LIST, $this->_folderId), $query);
	}
	 
	/**
	 * The ID of the child. 
	 *
	 * @param string
	 * @return this
	 */
	public function setChildId($childId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_childId = $childId;
		
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
	 * The ID of the folder. 
	 *
	 * @param string
	 * @return this
	 */
	public function setFolderId($folderId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_folderId = $folderId;
		
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
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}