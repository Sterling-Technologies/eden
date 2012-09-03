<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Google youtube message
 *
 * @package    Eden
 * @category   google
 * @author     Christian Symon M. Buenavista sbuenavista@openovate.com
 */
class Eden_Google_Youtube_Message extends Eden_Google_Base {
	/* Constants
	-------------------------------*/ 
	const URL_YOUTUBE_MESSAGE		= 'https://gdata.youtube.com/feeds/api/users/%s/inbox';
	const URL_YOUTUBE_MESSAGE_GET	= 'https://gdata.youtube.com/feeds/api/users/%s/inbox/%s';
	
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
	 * Retrieve all user's contacts
	 *
	 * @param string
	 * @return array
	 */
	public function getList($userId = self::DEFAULT_VALUE) {
		//argument 1 must be a string
		Eden_Google_Error::i()->argument(1, 'string');
		
		$this->_query[self::RESPONSE] = self::JSON_FORMAT;
		
		return $this->_getResponse(sprintf(self::URL_YOUTUBE_MESSAGE, $userId), $this->_query);
	}
	
	/**
	 * Send a video message
	 *
	 * @param string
	 * @param string
	 * @param string
	 * @return array
	 */
	public function sendMessage($videoId, $summary, $userName) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string')		//argument 2 must be a string
			->argument(3, 'string');	//argument 3 must be a string
		
		//make a xml template
		$query = Eden_Template::i()
			->set(self::VIDEO_ID, $videoId)
			->set(self::SUMMARY, $summary)
			->parsePHP(dirname(__FILE__).'/template/sendmessage.php');
		
		return $this->_post(sprintf(self::URL_YOUTUBE_MESSAGE, $userName), $query);
	}
	
	/**
	 * Delete a message 
	 *
	 * @param string
	 * @param string
	 * @return array
	 */
	public function delete($messageId, $userId = self::DEFAULT_VALUE) {
		//argument test
		Eden_Google_Error::i()
			->argument(1, 'string')		//argument 1 must be a string
			->argument(2, 'string');	//argument 2 must be a string
		
		return $this->_delete(sprintf(self::URL_YOUTUBE_MESSAGE_GET, $userId, $messageId));
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}