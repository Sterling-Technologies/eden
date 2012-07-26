<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Drive Files Class
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Drive_Files extends Eden_Google_Base {
	/* Constants
	-------------------------------*/
	const URL_DRIVE_LIST	= 'https://www.googleapis.com/drive/v2/files';
	const URL_DRIVE_GET		= 'https://www.googleapis.com/drive/v2/files/%s';
	const URL_DRIVE_TRASH	= 'https://www.googleapis.com/drive/v2/files/%s/trash';
	const URL_DRIVE_UNTRASH	= 'https://www.googleapis.com/drive/v2/files/%s/untrash';
	const URL_DRIVE_TOUCH	= 'https://www.googleapis.com/drive/v2/files/%s/touch';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_convert				= false;
	protected $_ocr					= false;
	protected $_pinned				= false;
	protected $_newRevision			= false;
	protected $_ocrLanguage			= NULL;
	protected $_sourceLanguage		= NULL;
	protected $_targetLanguage		= NULL;
	protected $_timedTextLanguage	= NULL;
	protected $_timedTextTrackName	= NULL;
	protected $_description			= NULL;
	protected $_lastViewedByMeDate	= NULL;
	protected $_mimeType			= NULL;
	protected $_modifiedDate		= NULL;
	protected $_title				= NULL;
	protected $_fileId				= NULL;
	
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
	 * The ID for the file
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
	 * Whether to convert this file 
	 * to the corresponding Google Docs format. 
	 *
	 * @return this
	 */
	public function setToConvert() {
		$this->_convert = true;
		
		return $this;
	}
	
	/**
	 * Whether to attempt OCR on .jpg, .png, or .gif uploads. 
	 *
	 * @return this
	 */
	public function setToOcr() {
		$this->_ocr = true;
		
		return $this;
	}
	
	/**
	 * If ocr is true, hints at the language 
	 * to use. Valid values are ISO 639-1 codes. 
	 *
	 * @param string
	 * @return this
	 */
	public function setOcrLanguage($ocrLanguage) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_ocrLanguage = $ocrLanguage;
		
		return $this;
	}
	
	/**
	 * Whether to pin the head revision of the uploaded file. 
	 *
	 * @return this
	 */
	public function setToPinned() {
		$this->_pinned = true;
		
		return $this;
	}
	
	/**
	 * The language of the original file to be translated. 
	 *
	 * @param string
	 * @return this
	 */
	public function setSourceLanguage($sourceLanguage) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_sourceLanguage = $sourceLanguage;
		
		return $this;
	}
	
	/**
	 * Target language to translate the 
	 * file to. If no sourceLanguage is provided, 
	 * the API will attempt to detect the language. 
	 *
	 * @param string
	 * @return this
	 */
	public function setTargetLanguage($targetLanguage) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_targetLanguage = $targetLanguage;
		
		return $this;
	}
	
	/**
	 * The language of the timed text. 
	 *
	 * @param string
	 * @return this
	 */
	public function setTimedTextLanguage($timedTextLanguage) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_timedTextLanguage = $timedTextLanguageE;
		
		return $this;
	}
	
	/**
	 * The timed text track name. 
	 *
	 * @param string
	 * @return this
	 */
	public function setTimedTextTrackName($timedTextTrackName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_timedTextTrackName = $timedTextTrackName;
		
		return $this;
	}
	
	/**
	 * A short description of the file.
	 *
	 * @param string
	 * @return this
	 */
	public function setDescription($description) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_description = $description;
		
		return $this;
	}
	
	/**
	 * Last time this file was viewed by the user 
	 * (formatted RFC 3339 timestamp).
	 *
	 * @param string|int
	 * @return this
	 */
	public function setLastViewedByMeDate($lastViewedByMeDate) {
		//argument 1 must be a string or integer
		Eden_Google_Error::i()->argument(1, 'string', 'int');
		
		if(is_string($lastViewedByMeDate)) {
			$lastViewedByMeDate = strtotime($lastViewedByMeDate);
		}
		
		$this->_lastViewedByMeDate['dateTime'] = date('c', $lastViewedByMeDate);
		
		return $this;
	}
	
	/**
	 * Last time this file was modified by anyone (formatted RFC 3339 timestamp). 
	 * This is only mutable on update when the setModifiedDate parameter is set.
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
	 * The title of the this file. Used 
	 * to identify file or folder name.
	 *
	 * @param string
	 * @return this
	 */
	public function setTitle($title) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_title = $title;
		
		return $this;
	}
	
	/**
	 * Whether a blob upload should create a new revision. 
	 * If false, the blob data in the current head revision will be replaced. 
	 *
	 * @return this
	 */
	public function setToNewRevision() {
		$this->_newRevision = true;
		
		return $this;
	}
	
	/**
	 * Returns the color definitions for 
	 * calendars and events. 
	 *
	 * @return array
	 */
	public function getList() {
		
		return $this->_getResponse(self::URL_DRIVE_LIST);
	}
	
	/**
	 * Gets a file's metadata by ID.
	 *
	 * @return array
	 */
	public function getSpecific() {
		
		return $this->_getResponse(sprintf(self::URL_DRIVE_GET, $this->_fileId));
	}
	
	/**
	 * Updates file metadata and/or content.
	 *
	 * @return array
	 */
	public function delete() {
		
		return $this->_delete(sprintf(self::URL_DRIVE_GET, $this->_fileId));
	}
	
	/**
	 * Moves a file to the trash.
	 *
	 * @return array
	 */
	public function trash() {
		
		return $this->_post(sprintf(self::URL_DRIVE_TRASH, $this->_fileId));
	}
	
	/**
	 * Restores a file from the trash
	 *
	 * @return array
	 */
	public function untrash() {
		
		return $this->_post(sprintf(self::URL_DRIVE_UNTRASH, $this->_fileId));
	}
	
	/**
	 * Creates a copy of the specified file
	 *
	 * @return array
	 */
	public function copyFile() {
		
		return $this->_post(sprintf(self::URL_DRIVE_COPY, $this->_fileId));
	}
	
	/**
	 * Set the file's updated time to the current server time
	 *
	 * @return array
	 */
	public function touchFile() {
		
		return $this->_post(sprintf(self::URL_DRIVE_TOUCH, $this->_fileId));
	}
	
	/**
	 * This method supports media upload. 
	 * Uploaded files must conform to these constraints: 
	 *
	 * @return array
	 */
	public function create() {
		//populate parameters
		$parameters = array(
			self::CONVERT			=> $this->_convert,
			self::OCR				=> $this->_ocr,
			self::OCR_LANGUAGE		=> $this->_ocrLanguage,
			self::PINNED			=> $this->_pinned,
			self::SOURCE_LANGUAGE	=> $this->_sourceLanguage,
			self::TARGET_LANGUAGE	=> $this->_targetLanguage,
			self::TEXT_LANGUAGE		=> $this->_timedTextLanguage,
			self::TEXT_TRACKNAME	=> $this->_timedTextTrackName);
		
		//populate fields
		$requestBody = array (
			self::DESCRIPTION	=> $this->_description,
			self::LAST_VIEW		=> $this->_lastViewedByMeDate,
			self::MIME_TYPE		=> $this->_mimeType,
			self::MODIFIED_DATE	=> $this->_modifiedDate,
			self::TITLE			=> $this->_title);	
		
		return $this->_post(self::URL_DRIVE_LIST, $query = array_merge($parameters, $requestBody));
	}
	
	 /**
	 * Updates file metadata and/or content.
	 *
	 * @return array
	 */
	public function update() {
		//populate parameters
		$parameters = array(
			self::CONVERT			=> $this->_convert,
			self::NEW_REVISION		=> $this->_newRevision,
			self::OCR				=> $this->_ocr,
			self::OCR_LANGUAGE		=> $this->_ocrLanguage,
			self::PINNED			=> $this->_pinned,
			self::SOURCE_LANGUAGE	=> $this->_sourceLanguage,
			self::TARGET_LANGUAGE	=> $this->_targetLanguage,
			self::TEXT_LANGUAGE		=> $this->_timedTextLanguage,
			self::TEXT_TRACKNAME	=> $this->_timedTextTrackName);
		
		//populate fields
		$requestBody = array (
			self::DESCRIPTION	=> $this->_description,
			self::LAST_VIEW		=> $this->_lastViewedByMeDate,
			self::MIME_TYPE		=> $this->_mimeType,
			self::MODIFIED_DATE	=> $this->_modifiedDate,
			self::TITLE			=> $this->_title);	
		
		return $this->_post(sprintf(self::URL_DRIVE_GET, $this->_fileId), $query = array_merge($parameters, $requestBody));
	}
	
	/**
	 * Updates file metadata and/or content.
	 * This method supports patch semantics.
	 *
	 * @return array
	 */
	public function patch() {
		//populate parameters
		$parameters = array(
			self::CONVERT			=> $this->_convert,
			self::NEW_REVISION		=> $this->_newRevision,
			self::OCR				=> $this->_ocr,
			self::OCR_LANGUAGE		=> $this->_ocrLanguage,
			self::PINNED			=> $this->_pinned,
			self::SOURCE_LANGUAGE	=> $this->_sourceLanguage,
			self::TARGET_LANGUAGE	=> $this->_targetLanguage,
			self::TEXT_LANGUAGE		=> $this->_timedTextLanguage,
			self::TEXT_TRACKNAME	=> $this->_timedTextTrackName);
		
		//populate fields
		$requestBody = array (
			self::DESCRIPTION	=> $this->_description,
			self::LAST_VIEW		=> $this->_lastViewedByMeDate,
			self::MIME_TYPE		=> $this->_mimeType,
			self::MODIFIED_DATE	=> $this->_modifiedDate,
			self::TITLE			=> $this->_title);	
		
		return $this->_patch(sprintf(self::URL_DRIVE_GET, $this->_fileId), $query = array_merge($parameters, $requestBody));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}