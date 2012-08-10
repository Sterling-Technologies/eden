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
	protected $_pinned					= false;
	protected $_publishAuto				= false;
	protected $_publishedOutsideDomain	= false;
	protected $_published				= NULL;
	
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
	 * Removes a revision
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($fileId, $revisionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_REVISIONS_GET, $fileId, $revisionId));
	}
	
	/**
	 * Lists a file's revisions
	 *
	 * @param string
	 * @return array
	 */
	public function getList($fileId) {
		//argument test
		Eden_Google_Error::i()->argument(1, 'string');
		
		return $this->_getResponse(sprintf(self::URL_REVISIONS_LIST, $fileId));
	}
	
	/**
	 * Gets a specific revision
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($fileId, $revisionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_getResponse(sprintf(self::URL_REVISIONS_GET, $fileId, $revisionId));
	}
	
	/**
	 * Updates a revision. This method supports patch semantics
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function patch($fileId, $revisionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(
			self::PINNED			=> $this->_pinned,					//optional
			self::PUBLISHED			=> $this->_published,				//optional
			self::PUBLISHED_LINK	=> $this->_publishedLink,			//optional
			self::PUBLISHED_AUTO	=> $this->_publishAuto,				//optional
			self::OUTSIDE_DOMAIN	=> $this->_publishedOutsideDomain);	//optional
		
		return $this->_patch(sprintf(self::URL_PERMISSIONS_GET, $fileId, $revisionId), $query);
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
	 * Whether subsequent revisions will be automatically republished.
	 *
	 * @return this
	 */
	public function setPublishAuto() {
		$this->_publishAuto = true;
		
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
	 * Whether this revision is published outside the domain.
	 *
	 * @return this
	 */
	public function setPublishedOutsideDomain() {
		$this->_publishedOutsideDomain = true;
		
		return $this;
	}
	
	/**
	 * Updates a revision.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function update($fileId, $revisionId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		//populate fields
		$query = array(
			self::PINNED			=> $this->_pinned,					//optional
			self::PUBLISHED			=> $this->_published,				//optional
			self::PUBLISHED_LINK	=> $this->_publishedLink,			//optional
			self::PUBLISHED_AUTO	=> $this->_publishAuto,				//optional
			self::OUTSIDE_DOMAIN	=> $this->_publishedOutsideDomain);	//optional
		
		return $this->_put(sprintf(self::URL_PERMISSIONS_GET, $fileId, $revisionId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}