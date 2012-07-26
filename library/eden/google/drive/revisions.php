<?php //--> 
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Revisions Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Revisions extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_REVISIONS_LIST	= 'https://www.googleapis.com/drive/v2/files/%s/revisions';
	const URL_REVISIONS_GET		= 'https://www.googleapis.com/drive/v2/files/%s/revisions/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_modifiedDate			= false;
	protected $_pinned					= false;
	protected $_publishAuto				= false;
	protected $_publishedOutsideDomain	= false;
	protected $_fileId					= NULL;
	protected $_permissionId			= NULL;
	protected $_kind					= NULL;
	protected $_etag					= NULL;
	protected $_id						= NULL;
	protected $_selfLink				= NULL;
	protected $_mimeType				= NULL;
	protected $_published				= NULL;
	protected $_publishedLink			= NULL;
	protected $_downloadUrl				= NULL;
	protected $_exportLinks				= NULL;
	protected $_lastModifyingUserName	= NULL;
	protected $_originalFilename		= NULL;
	protected $_md5Checksum				= NULL;
	protected $_fileSize				= NULL;
	
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
	 * The ID of the revision. 
	 *
	 * @param string
	 * @return this
	 */
	public function setRevisionId($revisionId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_revisionId = $revisionId;
		
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
	 * The MIME type of the revision.
	 *
	 * @param string
	 * @return this
	 */
	public function setMimeType($mimeType) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_mimeType = $mimeType;
		
		return $this;
	}
	
	/**
	 * Last time this revision was modified (formatted RFC 3339 timestamp).
	 *
	 * @param string|int
	 * @return this
	 */
	public function setModifiedDate($modifiedDate) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($modifiedDate)) {
			$modifiedDate = strtotime($modifiedDate);
		}
		
		$this->_modifiedDate['dateTime'] = date('c', $modifiedDate);
		
		return $this;
	}
	
	/**
	 * Whether this revision is pinned to prevent automatic purging. 
	 * This will only be populated on files with content stored in Drive.
	 *
	 * @return this
	 */
	public function setPinned() {
		$this->_pinned = true;
		
		return $this;
	}
	
	/**
	 * Whether this revision is published. This is only populated for Google Docs.
	 *
	 * @return this
	 */
	public function setPublished() {
		$this->_published = true;
		
		return $this;
	}
	
	/**
	 * Whether subsequent revisions will be automatically republished.
	 *
	 * @return this
	 */
	public function setPublishAuto() {
		$this->_publishAuto = true;
		
		return $this;
	}
	
	
	/**
	 * Whether this revision is published outside the domain.
	 *
	 * @return this
	 */
	public function setPublishedOutsideDomain() {
		$this->_publishedOutsideDomain = true;
		
		return $this;
	}
	
	/**
	 * A link to the published revision.
	 *
	 * @param string
	 * @return this
	 */
	public function setPublishedLink($publishedLink) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_publishedLink = $publishedLink;
		
		return $this;
	}
	
	/**
	 * Short term download URL for the file. 
	 * This will only be populated on files with content stored in Drive.
	 *
	 * @param string
	 * @return this
	 */
	public function setDownloadUrl($downloadUrl) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_downloadUrl = $downloadUrl;
		
		return $this;
	}
	
	/**
	 * Links for exporting Google Docs to specific formats.
	 *
	 * @param string|object
	 * @return this
	 */
	public function setExportLinks($exportLinks) {
		//argument 1 must be a string or object
		Eden_Google_Error::i()->argument(1, 'string', 'object');
		$this->_exportLinks = $exportLinks;
		
		return $this;
	}
	
	/**
	 * Name of the last user to modify this revision.
	 *
	 * @param string
	 * @return this
	 */
	public function setLastModifyingUserName($lastModifyingUserName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_lastModifyingUserName = $lastModifyingUserName;
		
		return $this;
	}
	
	/**
	 * The original filename when this revision was created. 
	 * This will only be populated on files with content stored in Drive.
	 *
	 * @param string
	 * @return this
	 */
	public function setOriginalFilename($originalFilename) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_originalFilename = $originalFilename;
		
		return $this;
	}
	
	/**
	 * An MD5 checksum for the content of this revision. 
	 * This will only be populated on files with content stored in Drive.
	 *
	 * @param string
	 * @return this
	 */
	public function setMd5Checksum($md5Checksum) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_md5Checksum = $md5Checksum;
		
		return $this;
	}
	
	/**
	 * The size of the revision in bytes. This will only be 
	 * populated on files with content stored in Drive.
	 *
	 * @param string
	 * @return this
	 */
	public function setFileSize($fileSize) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_fileSize = $fileSize;
		
		return $this;
	}
	
	/**
	 * Lists a file's revisions
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(sprintf(self::URL_REVISIONS_LIST, $this->_fileId));
	}
	
	/**
	 * Gets a specific revision
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_REVISIONS_GET, $this->_fileId, $this->_revisionId));
	}
	
	/**
	 * Removes a revision
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_REVISIONS_GET, $this->_fileId, $this->_revisionId));
	}
	
	/**
	 * Updates a revision.
	 *
	 * @return array
	 */
	public function update() {
		//populate fields
		$query = array(
			self::KIND				=> $this->_kind,
			self::ETAG				=> $this->_etag,
			self::ID				=> $this->_id,	
			self::SELF_LINK			=> $this->_selfLink,
			self::MIME_TYPE			=> $this->_mimeType,
			self::MODIFIED_DATE		=> $this->_modifiedDate,
			self::PINNED			=> $this->_pinned,
			self::PUBLISHED			=> $this->_published,
			self::PUBLISHED_LINK	=> $this->_publishedLink,
			self::PUBLISHED_AUTO	=> $this->_publishAuto,
			self::OUTSIDE_DOMAIN	=> $this->_publishedOutsideDomain,
			self::DOWNLOAD_URL		=> $this->_downloadUrl,
			self::EXPORT_LINK		=> $this->_exportLinks,
			self::LAST_MODIFY		=> $this->_lastModifyingUserName,
			self::ORIGINAL_FILENAME	=> $this->_originalFilename,
			self::MD5_CHECKSUM		=> $this->_md5Checksum,
			self::FILESIZE			=> $this->_fileSize);
		
		return $this->_put(sprintf(self::URL_PERMISSIONS_GET, $this->_fileId, $this->_revisionId), $query);
	}
	
	/**
	 * Updates a revision. This method supports patch semantics
	 *
	 * @return array
	 */
	public function patch() {
		//populate fields
		$query = array(
			self::KIND				=> $this->_kind,
			self::ETAG				=> $this->_etag,
			self::ID				=> $this->_id,	
			self::SELF_LINK			=> $this->_selfLink,
			self::MIME_TYPE			=> $this->_mimeType,
			self::MODIFIED_DATE		=> $this->_modifiedDate,
			self::PINNED			=> $this->_pinned,
			self::PUBLISHED			=> $this->_published,
			self::PUBLISHED_LINK	=> $this->_publishedLink,
			self::PUBLISHED_AUTO	=> $this->_publishAuto,
			self::OUTSIDE_DOMAIN	=> $this->_publishedOutsideDomain,
			self::DOWNLOAD_URL		=> $this->_downloadUrl,
			self::EXPORT_LINK		=> $this->_exportLinks,
			self::LAST_MODIFY		=> $this->_lastModifyingUserName,
			self::ORIGINAL_FILENAME	=> $this->_originalFilename,
			self::MD5_CHECKSUM		=> $this->_md5Checksum,
			self::FILESIZE			=> $this->_fileSize);
		
		return $this->_patch(sprintf(self::URL_PERMISSIONS_GET, $this->_fileId, $this->_revisionId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}