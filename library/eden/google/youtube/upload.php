<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google Youtube Upload 
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Upload extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_UPLOAD = 'http://uploads.gdata.youtube.com/action/GetUploadToken';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId		= 'default';
	protected $_version		= '2';
	protected $_title		= NULL;
	protected $_description	= NULL;
	protected $_category	= NULL;
	protected $_keyword		= NULL;
	protected $_uploadToken	= NULL;
	protected $_redirectUrl	= NULL;
	protected $_postUrl		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($token, $developerId) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')
			->argument(2, 'string');
			
		$this->_token 		= $token;
		$this->_developerId = $developerId; 
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * YouTube user ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserId($userId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userId = $userId;
		
		return $this;
	}
	
	/**
	 * Set video title.
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
	 * Set video description.
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
	 * Set video category.
	 *
	 * @param string
	 * @return this
	 */
	public function setCategory($category) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_category = $category;
		
		return $this;
	}
	
	/**
	 * Set video Keyword.
	 *
	 * @param string
	 * @return this
	 */
	public function setKeyword($keyword) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_keyword = $keyword;
		
		return $this;
	}
	
	/**
	 * Set upload token from getUploadToken()
	 *
	 * @param string|object
	 * @return this
	 */
	public function setUploadToken($uploadToken) {
		//argument 1 must be a string or object
		Eden_Google_Error::i()->argument(1, 'object', 'string');
		$this->_uploadToken = $uploadToken;
		
		return $this;
	}
	
	/**
	 * Set redirect url
	 *
	 * @param string
	 * @return this
	 */
	public function setRedirectUrl($redirectUrl) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_redirectUrl = $redirectUrl;
		
		return $this;
	}
	
	/**
	 * Set post url
	 *
	 * @param string|object
	 * @return this
	 */
	public function setPostUrl($postUrl) {
		//argument 1 must be a string or object
		Eden_Google_Error::i()->argument(1, 'object', 'string');
		$this->_postUrl = $postUrl;
		
		return $this;
	}
	
	/**
	 * Get upload token
	 *
	 * @return array
	 */
	public function getUploadToken() {
		//make a xml template
		$query = Eden_Template::i()
			->set(self::TITLE, $this->_title)
			->set(self::DESCRIPTION, $this->_description)
			->set(self::CATEGORY, $this->_category)
			->set(self::KEYWORD, $this->_keyword)
			->parsePHP(dirname(__FILE__).'/template/upload.php');
		
		return $this->_upload(sprintf(self::URL_YOUTUBE_UPLOAD, $this->_userId), $query);
	}
	
	/**
	 * Upload video to youtube
	 *
	 * @return string
	 */
	public function upload() {
		//make a xml template
		$query = Eden_Template::i()
			->set(self::UPLOAD_TOKEN, $this->_uploadToken)
			->set(self::REDIRECT_URL, $this->_redirectUrl)
			->set(self::POST_URL, $this->_postUrl)
			->parsePHP(dirname(__FILE__).'/template/form.php');
		
		return $query;
	}

	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}