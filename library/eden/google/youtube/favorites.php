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
	 * Retrieving all user's favorite videos.
	 *
	 * @param string
	 * @return array
	 */
	public function getList($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_FAVORITES, $userId), $this->_query);
	}
	
	/**
	 * Retrieving specific user's favorite videos.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecific($favoriteVideoId, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_FAVORITES_GET, $userId, $favoriteVideoId), $this->_query);
	}
	
	/**
	 * Retrieving a user's favorite videos.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function addFavorites($videoId, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
	
		//make a xml template file
		$query = Eden_Template::i()
			->set(self::VIDEO_ID, $videoId)
			->parsePHP(dirname(__FILE__).'/template/addfavorites.php');
			
		return $this->_post(sprintf(self::URL_YOUTUBE_FAVORITES, $userId), $query);
	}
	
	/**
	 * Retrieving a user's favorite videos.
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function removeFavorites($favoriteVideoId, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_FAVORITES_GET, $userId, $favoriteVideoId));
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}