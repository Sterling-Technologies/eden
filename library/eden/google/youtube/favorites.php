<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package. 
 */

/**
 * Google youtube favorites
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Favorites extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_FAVORITES		= 'https://gdata.youtube.com/feeds/api/users/%s/favorites';
	const URL_YOUTUBE_FAVORITES_GET = 'https://gdata.youtube.com/feeds/api/users/%s/favorites/%s';
	
	/* Public Properties 
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_userId 			= 'default';
	protected $_videoId 		= NULL;
	protected $_favoriteVideoId	= NULL;
	
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
	 * Set user id
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
	 * Set youtube video id
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
	 * Set youtube favorite video id
	 *
	 * @param string
	 * @return this
	 */
	public function setFavoriteVideoId($favoriteVideoId) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		$this->_favoriteVideoId = $favoriteVideoId;
		
		return $this;
	}
	
	/**
	 * Retrieving all user's favorite videos.
	 *
	 * @return array
	 */
	public function getList() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_FAVORITES, $this->_userId), $query);
	}
	
	/**
	 * Retrieving specific user's favorite videos.
	 *
	 * @return array
	 */
	public function getSpecific() {
		//populate fields
		$query  = array(self::RESPONSE => self::JSON_FORMAT);
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_FAVORITES_GET, $this->_userId, $this->_favoriteVideoId), $query);
	}
	
	/**
	 * Retrieving a user's favorite videos.
	 *
	 * @return array
	 */
	public function addFavorites() {
	
		//make a xml template file
		$query = Eden_Template::i()
			->set(self::VIDEO_ID, $this->_videoId)
			->parsePHP(dirname(__FILE__).'/template/addfavorites.php');
			
		return $this->_post(sprintf(self::URL_YOUTUBE_FAVORITES, $this->_userId), $query);
	}
	
	/**
	 * Retrieving a user's favorite videos.
	 *
	 * @return array
	 */
	public function removeFavorites() {
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_FAVORITES_GET, $this->_userId, $this->_favoriteVideoId));
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}