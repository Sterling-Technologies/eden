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
	 * Returns a collection of videos that match the API request parameters.
	 *
	 * @param string
	 * @return array
	 */
	public function getList($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_PROFILE, $userId), $this->_query);
	}
	
	/**
	 * Returns all videos uploaded by user,
	 *
	 * @param string
	 * @return array
	 */
	public function getUserVideoUploads($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_UPLOADS, $userId), $this->_query);
	}
	
	/**
	 * Returns specific videos uploaded by user,
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function getSpecificUserVideo($videoId, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
			
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_GET, $userId, $videoId), $this->_query);
	}
	
	/**
	 * Activate user account for youtube 
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function activateAccount($userName, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::USER_NAME, $userName)
			->parsePHP(dirname(__FILE__).'/template/activate.php');
		
		return $this->_put(sprintf(self::URL_YOUTUBE_PROFILE, $userId), $query);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}