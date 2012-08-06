<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google youtube profile
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Profile extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_PROFILE	= 'https://gdata.youtube.com/feeds/api/users/%s';
	const URL_YOUTUBE_UPLOADS	= 'https://gdata.youtube.com/feeds/api/users/%s/uploads';
	const URL_YOUTUBE_GET		= 'https://gdata.youtube.com/feeds/api/users/%s/uploads/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId		= 'default';
	protected $_videoId		= NULL;
	protected $_userName	= NULL;
	
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
	 * set user name.
	 *
	 * @param string
	 * @return this
	 */
	public function setUserName($userName) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_userName = $userName;
		
		return $this;
	}
	
	/**
	 * YouTube video ID.
	 *
	 * @param string
	 * @return this
	 */
	public function setVideoId($videoId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_videoId = $videoId;
		
		return $this;
	}
	
	/**
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @return array
	 */
	public function getlist() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_PROFILE, $this->_userId), $query);
	}
	
	/**
	 * Returns all videos uploaded by user,
	 *
	 * @return array
	 */
	public function getUserVideoUploads() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_UPLOADS, $this->_userId), $query);
	}
	
	/**
	 * Returns specific videos uploaded by user,
	 *
	 * @return array
	 */
	public function getSpecificUserVideo() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_GET, $this->_userId, $this->_videoId), $query);
	}
	
	/**
	 * Activate user account for youtube 
	 *
	 * @return array
	 */
	public function activateAccount() {
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::USER_NAME, $this->_userName)
			->parsePHP(dirname(__FILE__).'/template/activate.php');
		
		return $this->_put(sprintf(self::URL_YOUTUBE_PROFILE, $this->_userId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}